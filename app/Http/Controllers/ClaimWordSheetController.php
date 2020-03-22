<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClaimWordSheetRequest;
use App\Http\Requests\UpdateClaimWordSheetRequest;
use App\ClaimWordSheet;
use App\HBS_MR_MEMBER;
use Auth;
use App\User;
use App\Claim;
use App\HBS_CL_CLAIM;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Arr;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClaimWordSheetController extends Controller
{
    /** @var  ClaimWordSheetRepository */
    private $claimWordSheetRepository;

    public function __construct()
    {
        //$this->authorizeResource(ClaimWordSheet::class);
        parent::__construct();
    }

    /**
     * Display a listing of the ClaimWordSheet.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $search_params = [
            'created_user' => $request->get('created_user'),
            'created_at' => $request->get('created_at'),
            'updated_user' => $request->get('updated_user'),
            'updated_at' => $request->get('updated_at'),
            'status' => $request->get('status'),
        ];
        $admin_list = User::getListIncharge();
        $limit_list = config('constants.limit_list');
        $limit = $request->get('limit');
        $per_page = !empty($limit) ? $limit : Arr::first($limit_list);

        $claimWordSheets =  ClaimWordSheet::findByParams($search_params)->whereIn('status', [1,2])->orderBy('id', 'desc');
        $claimWordSheets  = $claimWordSheets->paginate($per_page);

        return view('claim_word_sheets.index', compact('search_params', 'admin_list', 'limit', 'limit_list', 'claimWordSheets' ));           
    }

    /**
     * Show the form for creating a new ClaimWordSheet.
     *
     * @return Response
     */
    /**
     * Store a newly created ClaimWordSheet in storage.
     *
     * @param CreateClaimWordSheetRequest $request
     *
     * @return Response
     */
    public function store(CreateClaimWordSheetRequest $request)
    {
        $userId = Auth::User()->id;
        $data = $request->except([]);
        $data['created_user'] = $userId;
        $data['updated_user'] = $userId;
        ClaimWordSheet::create($data);
        $request->session()->flash('status', 'Claim Word Sheet saved successfully.');

        return redirect(route('claim.show',['claim'=>$request->claim_id]));
    }

    /**
     * Display the specified ClaimWordSheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(ClaimWordSheet $claimWordSheet)
    {
        $claim  = Claim::itemClaimReject()->findOrFail($claimWordSheet->claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $member = HBS_MR_MEMBER::where('MEMB_REF_NO',$claimWordSheet->mem_ref_no)->first();
        $claim_line = $member->CL_LINE;
        $log_history = $claimWordSheet->log;
        //dd($member->MR_MEMBER_EVENT->where('scma_oid_event_code', 'EVENT_CODE_EXPL')->first());
        return view('claim_word_sheets.show', compact('claimWordSheet', 'claim', 'HBS_CL_CLAIM', 'member','claim_line', 'log_history'));
    }

    public function pdf(ClaimWordSheet $claimWordSheet){
        
        $claim  = Claim::itemClaimReject()->findOrFail($claimWordSheet->claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $member = HBS_MR_MEMBER::where('MEMB_REF_NO',$claimWordSheet->mem_ref_no)->first();
        $claim_line = $member->CL_LINE;
        $log_history = $claimWordSheet->log;
        $mpdf = new \Mpdf\Mpdf(['tempDir' => base_path('resources/fonts/')]);
        $mpdf->WriteHTML(view('claim_word_sheets.pdf', compact('claimWordSheet', 'claim', 'HBS_CL_CLAIM', 'member','claim_line', 'log_history'))->render());
        $mpdf->SetHTMLFooter('
        <div style="text-align: right; font-weight: bold;">
            <img src="'.asset("images/footer.png").'" alt="foot">
        </div>');
        header("Content-Type: application/pdf");
        header("Expires: 0");//no-cache
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
        header("content-disposition: attachment;filename=worksheet.pdf");
        echo $mpdf->Output('filename.pdf',\Mpdf\Output\Destination::STRING_RETURN);
    }

    public function summary(ClaimWordSheet $claimWordSheet){
        $path_file = [] ;
        $claim  = Claim::itemClaimReject()->findOrFail($claimWordSheet->claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $member = HBS_MR_MEMBER::where('MEMB_REF_NO',$claimWordSheet->mem_ref_no)->first();
        $claim_line = $member->CL_LINE;
        $mpdf = new \Mpdf\Mpdf(['tempDir' => base_path('resources/fonts/')]);
        $mpdf->WriteHTML(view('claim_word_sheets.pdf', compact('claimWordSheet', 'claim', 'HBS_CL_CLAIM', 'member','claim_line'))->render());
        $mpdf->SetHTMLFooter('
        <div style="text-align: right; font-weight: bold;">
            <img src="'.asset("images/footer.png").'" alt="foot">
        </div>');
        $pdf = $mpdf->Output('filename.pdf',\Mpdf\Output\Destination::STRING_RETURN);
        $count_page = count($mpdf->pages);
        $file_name =  md5(Str::random(12).time());
        Storage::put('public/cache/' . $file_name, $pdf);
        $path_file[] = storage_path("app/public/cache/$file_name") ;

        

        $filename = config('constants.url_mantic') ."plugin.php?page=DownloadFiles/file_summary_download.php&bug_id=" . $claim->barcode;
        $handle = fopen($filename, "r");
        $file_contents = stream_get_contents($handle);
        fclose($handle);
        if($file_contents != ""){
            $file_name_mantis =  md5(Str::random(11).time());
            Storage::put('public/cache/' . $file_name_mantis, $file_contents);
            $path_file[] = storage_path("app/public/cache/$file_name_mantis") ;
            if($claimWordSheet->old_number_page_send != 0){
                
                $file_name_mantis_output =  md5(Str::random(9).time());
                $FirstPage = $claimWordSheet->old_number_page_send + 1 ;
                $cm_run ="gs -sDEVICE=pdfwrite -dNOPAUSE -dQUIET -dBATCH -dFirstPage={$FirstPage} -sOutputFile=". storage_path("app/public/cache/$file_name_mantis_output") ." ".storage_path("app/public/cache/$file_name_mantis");
                exec($cm_run);
                Storage::delete(str_replace(storage_path("app")."/", "", $path_file[1]));
                $path_file[1] = storage_path("app/public/cache/$file_name_mantis_output");
            }
        }

        $file_name_combine =  md5(Str::random(10).time()) .".pdf";
        $path_file[] = storage_path("app/public/cache/$file_name_combine");
        $cm_run = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dPDFSETTINGS=/prepress -sOutputFile=".storage_path("app/public/cache/$file_name_combine"). 
        " -dBATCH " . implode(" ",$path_file);
        exec($cm_run);
        try {
            $body = [
                
                'multipart' =>[
                    [
                        'name' => 'bug_id',
                        'contents' => $claim->barcode
                    ],
                    [
                        'name' => 'p_file_name',
                        'contents' => 'sumary_'.$claim->code_claim_show.Carbon::now()->format('d-m-y').'.pdf'
                    ],
                    [
                        'name'     => 'user_email',
                        'contents' => Auth::User()->email,
                    ],
                    [
                        'name' => 'p_file',
                        'contents' => fopen(storage_path("app/public/cache/$file_name_combine"),'r')
                    ]
                ]
            ];
            
            $res = PostApiManticHasFile('api/rest/plugins/apimanagement/issues/upload_sumary/files', $body);
            $statusCode =  $res->getStatusCode();
            $mes = $res->getReasonPhrase();
        } catch (Exception $e) {
            
        }

        foreach ($path_file as $key => $value){
            $path_file[$key]  = str_replace(storage_path("app")."/", "", $value);
        }
        Storage::delete($path_file);
        $claimWordSheet->old_number_page_send = $count_page;
        $claimWordSheet->save();
        return response()->json(['status' => 'success' , 'message' => $mes]);
    }
    /**
     * Show the form for editing the specified ClaimWordSheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(ClaimWordSheet $claimWordSheet)
    {
        
        return view('claim_word_sheets.edit',  compact('claimWordSheet'));
    }

    /**
     * Update the specified ClaimWordSheet in storage.
     *
     * @param int $id
     * @param UpdateClaimWordSheetRequest $request
     *
     * @return Response
     */
    public function update(ClaimWordSheet $claimWordSheet, UpdateClaimWordSheetRequest $request)
    {
        $data = $request->except([]);
        if (isset($data["benefit"])){
            $data["benefit"] = array_values($data["benefit"]);
        }
        $userId = Auth::User()->id;
        $data['updated_user'] = $userId;
        ClaimWordSheet::updateOrCreate(['id' => $claimWordSheet->id], $data);
        if($request->status == 1){
            $arrUserId = User::whereHas("roles", function($q){ $q->where("name", "Medical"); })->pluck('id')->toArray();
            $content = Auth::User()->name . " yêu cầu hỗ trợ tư vấn Claim work sheet : <a href = '" . 
            route('claimWordSheets.show', $claimWordSheet->id) ."'>". 
            route('claimWordSheets.show',  $claimWordSheet->id)."</a>";
            notifi_system($content, $arrUserId);
        }
        if($request->status == 2){
            
            $content = Auth::User()->name . " đã trả lời yêu cầu hỗ trợ tư vấn Claim work sheet : <a href = '" . 
            route('claimWordSheets.show', $claimWordSheet->id) ."'>". 
            route('claimWordSheets.show',  $claimWordSheet->id)."</a>";
            notifi_system($content, [$claimWordSheet->created_user]);
        }
        $request->session()->flash('status', 'Claim Word Sheet updated successfully.'); 
        return redirect(route('claimWordSheets.index'));
    }

    /**
     * Remove the specified ClaimWordSheet from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(ClaimWordSheet $claimWordSheet)
    {
        $claimWordSheet->delete();
        return redirect(route('claimWordSheets.index'))->with('status', 'Claim Word Sheet deleted successfully.');
    }
}
