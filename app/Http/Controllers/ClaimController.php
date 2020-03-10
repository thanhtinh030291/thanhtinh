<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Config;
use Storage;
use App\Claim;
use App\ItemOfClaim;
use App\ExportLetter;
use App\User;
use App\Product;
use App\HBS_CL_CLAIM;
use App\LetterTemplate;
use Auth;
use App\ReasonReject;
use App\Http\Requests\formClaimRequest;
use App\Http\Requests\sendEtalkRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use SimilarText\Finder;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\TransactionRoleStatus;
use App\LevelRoleStatus;
use App\RoleChangeStatus;
use PDF;

class ClaimController extends Controller
{
    //use Authorizable;
    public function __construct()
    {
        $this->authorizeResource(Claim::class);
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemPerPage = Config::get('constants.paginator.itemPerPage');
        $id_claim =  $request->code_claim;
        $admin_list = User::getListIncharge();
        $finder = [
            'code_claim' => $request->code_claim,
            'created_user' => $request->created_user,
            'created_at' => $request->created_at,
            'updated_user' => $request->updated_user,
            'updated_at' => $request->updated_at,
            'letter_status' => $request->letter_status,
        ];
        $conditionExport = function ($q){
            $q->select('id','claim_id','status', 'info');
        };
        $conditionHasExport = function ($q) use ($request){
            //$q->where('status', $request->letter_status);
        };
        $datas = Claim::findByParams($finder)
        ->with(['export_letter_last' => $conditionExport]);
        $datas = $datas->orderBy('id', 'desc');
        if($request->letter_status != null){
            $datas = $datas->whereHas('export_letter_last', $conditionHasExport)->get()->where('export_letter_last.status', $request->letter_status);
        }

        $datas = $datas->paginate($itemPerPage);
        $list_status = RoleChangeStatus::pluck('name','id');
        return view('claimManagement.index', compact('finder', 'datas', 'admin_list', 'list_status'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listReasonReject = ReasonReject::pluck('name', 'id');
        return view('claimManagement.create', compact('listReasonReject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(formClaimRequest $request)
    {
        
        $file = $request->file;
        $dataNew = $request->except(['file','file2','table2_parameters', 'table1_parameters']);
        $userId = Auth::User()->id;
        $dirUpload = Config::get('constants.formClaimUpload');
        
        // store file
        if($file){
            $imageName = Claim::storeFile($file, $dirUpload);
            $dataNew += ['url_file'  =>  $imageName];
        }
        $dataNew += [
            'created_user' =>  $userId,
            'updated_user' =>  $userId,
        ];

        $dataItems = [];
        // get value item orc

        if( $request->_row){
            $fieldSelect =  array_flip(array_filter($request->_column));
            $rowData = $request->_row;
            array_shift_assoc($rowData);
            $rowCheck = $request->_checkbox;
            $reason = $request->_selectReason;
            foreach ($rowData as $key => $value) {
                $dataItems[] = new ItemOfClaim([
                    'content' => data_get($value, $fieldSelect['content'], ""),
                    'amount' => data_get($value, $fieldSelect['amount'], 0),
                    'reason_reject_id' => data_get($reason, $key),
                    'parameters' => data_get($request->table1_parameters, $key),
                    'created_user' => $userId,
                    'updated_user' => $userId,
                ]);
            }
        }
        // GET value add item
        if($request->_content){
            $rowContent = $request->_content;
            $rowAmount = $request->_amount;
            $reasonInject = $request->_reasonInject;
            foreach ($rowContent as $key => $value) {
                $dataItems[] = new ItemOfClaim([
                    'content' => $value,
                    'amount' => data_get($rowAmount, $key, 0),
                    'reason_reject_id' => data_get($reasonInject, $key),
                    'parameters' => data_get($request->table2_parameters, $key),true,
                    'created_user' => $userId,
                    'updated_user' => $userId,
                ]);
            }
        }
        
        
        //
        try {
            DB::beginTransaction();
            
            $claim = Claim::create($dataNew);
            $claim->item_of_claim()->saveMany($dataItems);
            DB::commit();
            $request->session()->flash('status', __('message.add_claim'));
            return redirect('/admin/claim');
        } catch (Exception $e) {
            Log::error(generateLogMsg($e));
            DB::rollback();
            $request->session()->flash('errorStatus', __('message.update_fail'));
            return redirect('/admin/claim/create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Claim $claim)
    {
        $data = $claim;
        $user = Auth::user();
        
        $admin_list = User::getListIncharge();
        $dirStorage = Config::get('constants.formClaimStorage');
        $dataImage =  $dirStorage . $data->url_file ;
        $listReasonReject = ReasonReject::pluck('name', 'id');
        $items = $data->item_of_claim;
        $listLetterTemplate = LetterTemplate::pluck('name', 'id');
        
        $role_id = $user->roles[0]->id;
        $RoleChangeStatus = RoleChangeStatus::all();
        $list_status_full = TransactionRoleStatus::all();
        $list_level = LevelRoleStatus::all();
        $list_status_ad = RoleChangeStatus::pluck('name','id');
        $export_letter = $data->export_letter;
        
        foreach ($export_letter as $key => $value) {
            if($value->letter_template->level != 0){
                $level = $list_level
                ->where('id','=', $value->letter_template->level)
                ->first();
            }else{
                $level = $list_level
                ->where('min_amount','<=', data_get($value->info, 'approve_amt') )
                ->where('max_amount','>', data_get($value->info, 'approve_amt') )
                ->first();
            }
            
            if($role_id != 1){
                $curren_status = $value->status == 0 ? $level->begin_status : $value->status ;
                $list_status =  $list_status_full
                                ->where('role', $role_id)
                                ->where('level_role_status_id', $level->id)
                                ->where('current_status', $curren_status)
                                ->pluck('to_status');
                $list_status = $RoleChangeStatus->whereIn('id' , $list_status)->pluck('name','id');
                $export_letter[$key]['list_status'] = $list_status;
            }else{
                $export_letter[$key]['list_status'] = $list_status_ad;
            }
            $export_letter[$key]['end_status'] = $level->end_status;

        }

        
        return view('claimManagement.show', compact(['data', 'dataImage', 'items', 'admin_list', 'listReasonReject', 'listLetterTemplate' , 'list_status_ad', 'user']));
    }

    public function barcode_link($barcode)
    { 
        $claim = Claim::where('barcode', $barcode)->first();
        if($claim){
            return redirect("admin/claim/{$claim->id}");
        }else{
            echo 'Đường dẫn chưa hợp lệ.';
        }
        
    }

    public function addNote(Request $request){
        $dataUpdate = [ 
            'note_id' => $request->note_id
        ];
        ExportLetter::updateOrCreate(['id' => $request->id], $dataUpdate);
        $request->session()->flash('status', __('message.update_claim'));
        return redirect('/admin/claim/'.$request->claim_id)->withInput();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Claim $claim)
    {
        $data = $claim;
        $user = Auth::user();
        $listReasonReject = ReasonReject::pluck('name', 'id');
        $dirStorage = Config::get('constants.formClaimStorage');
        $dataImage = [];
        $previewConfig = [];
        if($data->url_file){
            $dataImage[] = "<img class='kv-preview-data file-preview-image' src='" . asset('images/csv.png') . "'>";
            $previewConfig[]['caption'] = $data->url_file;
            $previewConfig[]['width'] = "120px";
            $previewConfig[]['url'] = "/admin/tours/removeImage";
            $previewConfig[]['key'] = $data->url_file;
        }
        $listCodeClaim = HBS_CL_CLAIM::where('clam_oid', $data->code_claim)->limit(20)->pluck('cl_no', 'clam_oid');
        
        //dd($data->item_of_claim->pluck('content'));
        return view('claimManagement.edit', compact(['data', 'dataImage', 'previewConfig', 'listReasonReject', 'listCodeClaim']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(formClaimRequest $request, Claim $claim)
    {
        $data = $claim;
        $userId = Auth::User()->id;
        $dataUpdate = $request;
        $dataUpdate = $dataUpdate->except(['table2_parameters']);
        try {
            DB::beginTransaction();
            if (Claim::updateOrCreate(['id' => $claim->id], $dataUpdate)) {
                if ($request->_content != null) {
                    $dataItemNew = [];
                    foreach ($request->_idItem as $key => $value) {
                        if ($value == null) {
                            $dataItemNew[] = [
                                'claim_id' => $claim->id,
                                'reason_reject_id' => $request->_reasonInject[$key],
                                'content' => $request->_content[$key],
                                'amount' => $request->_amount[$key],
                                'parameters' => data_get($request->table2_parameters, $key),
                                'created_user' => $userId,
                                'updated_user' => $userId,
                            ];
                        } else {
                            $keynew = $key - 1;
                            $data->item_of_claim[$keynew]->updated_user = $userId;
                            $data->item_of_claim[$keynew]->reason_reject_id = $request->_reasonInject[$key];
                            $data->item_of_claim[$keynew]->content = $request->_content[$key];
                            $data->item_of_claim[$keynew]->parameters = data_get($request->table2_parameters, $key);
                            $data->item_of_claim[$keynew]->amount = $request->_amount[$key];
                        }
                    }
                     //delete
                    $dataDel = ItemOfClaim::whereNotIn('id', array_filter($request->_idItem))->where('claim_id', $data->id);
                    $dataDel->delete();
                    // update
                    $data->push();
                    // new season price
                    $data->item_of_claim()->createMany($dataItemNew);
                } else {
                    $dataDel = ItemOfClaim::where('claim_id', $data->id);
                    $dataDel->delete();
                } // update and create new tour_set
                DB::commit();
                $request->session()->flash('status', __('message.update_claim'));
            }
            return redirect('/admin/claim');
        } catch (Exception $e) {
            Log::error(generateLogMsg($e));
            DB::rollback();
            $request->session()->flash(
                'errorStatus', 
                __('message.update_fail')
            );
            return redirect('/admin/claim/'.$data->id.'/edit')->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Claim $claim)
    {
        $data = $claim;
        $dirUpload = Config::get('constants.formClaimUpload');
        Storage::delete($dirUpload . $data->url_file);
        $data->item_of_claim()->delete();
        $data->delete();
        return redirect('/admin/claim')->with('status', __('message.delete_claim'));
    }
    // change
    public function getLevel($export_letter, $list_level)
    {
        
        if($export_letter->letter_template->level != 0){
            $level = $list_level
            ->where('id','=', $export_letter->letter_template->level)
            ->first();
        }else{
            $level = $list_level
            ->where('min_amount','<=', data_get($export_letter->info, 'approve_amt') )
            ->where('max_amount','>', data_get($export_letter->info, 'approve_amt') )
            ->first();
        }
        return $level;
    }
    // wait for check
    public function waitCheck(Request $request)
    {
        $claim_id = $request->claim_id;
        $id = $request->id;
        $user = Auth::User();
        $export_letter = ExportLetter::findOrFail($id);
        
        $wail = [];

        if($export_letter->note == null){
            $data = [];
        }else{
            $data = $export_letter->note;
        }

        if ($request->save_letter == 'save'){
            $export_letter->wait = [  'user' => $user->id,
                'created_at' => Carbon::now()->toDateTimeString(),
                'data' => $request->template
            ];
        }else{
            $status_change = $request->status_change;
            $status_change = explode("-",$status_change);
            if($status_change[1] == 'rejected'){
                array_push($data ,
                [  'user' => $user->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'data' => $request->template
                ]);
                $export_letter->note = $data;
            }
            $export_letter->status = $status_change[0];
            $list_level = LevelRoleStatus::all();
            $level = $this->getLevel($export_letter,$list_level );
            
            if($level->signature_accepted_by == $request->status_change){
                if($export_letter->letter_template->letter_payment == null){
                    $export_letter->approve = [  'user' => $user->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'data' => data_get($export_letter->wait, "data"),
                    ];
                }else{
                   
                    $export_letter->approve = [  'user' => $user->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'data' => data_get($export_letter->wait, "data"),
                        'data_payment' => base64_encode($this->letterPayment($export_letter->letter_template->letter_payment , $request->claim_id , $id, 1)['content'])
                    ];
                    
                }
                

            }
        }
        

        $export_letter->save();        
        return redirect('/admin/claim/'.$claim_id)->with('status', __('message.update_claim'));
    }
    // send Etalk 
    public function sendEtalk(sendEtalkRequest $request){
        $claim_id = $request->claim_id;
        $barcode = $request->barcode;
        $id = $request->id;
        $export_letter = ExportLetter::findOrFail($id);
        $user = Auth::User();
        $claim  = Claim::itemClaimReject()->findOrFail($claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $namefile = Str::slug("{$export_letter->letter_template->name}_{$HBS_CL_CLAIM->memberNameCap}", '-');
        $body = [
            'user_email' => $user->email,
            'issue_id' => $barcode,
            'text_note' => "Dear DLVN, \n Đính kèm là thư : '{$export_letter->letter_template->name}' \n Thanks,",
            'files' => [
                [
                    'name' => $namefile.".doc",
                    "content" => base64_encode(data_get($export_letter->approve, 'data'))
                ]
            ]
        ];
        if(isset($export_letter->approve['data_payment']))
        {
            $body['files'][] = [
                'name' => ''.$namefile."(payment).pdf",
                'content' => $export_letter->approve['data_payment']
            ];
        }


        try {
            $res = PostApiMantic('api/rest/plugins/apimanagement/issues/add_note_reply_letter/files', $body);
            $res = json_decode($res->getBody(),true);
        } catch (Exception $e) {

            $request->session()->flash(
                'errorStatus', 
                generateLogMsg($e)
            );
            return redirect('/admin/claim/'.$claim_id)->withInput();
        }
        if(data_get($res,'status') == 'success'){
            $data = $export_letter->info;
            $export_letter->info = [
                'approve_amt' => $data['approve_amt'],
                'deduct' => data_get($data, 'deduct'),
                'note' => $res['data']['note']
            ];
            $export_letter->save();
        
        }
        return redirect('/admin/claim/'.$claim_id)->with('status', __('message.update_claim'));
    }

    public function searchFullText(Request $request)
    {
            $res = ['status' => 'error'];
        if ($request->search != '') {
            $list = Product::pluck('name');
            $finder = new Finder($request->search, $list);
            $nameFirst = $finder->first();
            if(isset($nameFirst)){
                similar_text($request->search , $nameFirst, $percent);
                if($percent >= Config::get('constants.percentSelect')){
                    $res = ['status' => 'success', 'data' => ['name' => $nameFirst , 'percent' => round($percent, 0) ]];
                }
            }
        }
        return response()->json($res, 200); 
    }

    public function searchFullText2(Request $request)
    {
        $res = ['status' => 'error'];
        if ($request->search != '') {
            $data = Product::FullTextSearch('name', $request->search)->pluck('name')->toArray();
            if(isset($data)){
                $res = ['status' => 'success', 'data' => $data];
            }
        }
        return response()->json($res, 200);
    }

    public function template(Request $request)
    {
        $res = ['status' => 'error'];
        if ($request->search != '') {
            $data = ReasonReject::findOrFail($request->search);
            if(isset($data)){
                $res = ['status' => 'success', 'data' => $data->template];
            }
        }
        return response()->json($res, 200);
    }

    //request Letter
    public function requestLetter(Request $request){
        
        $userId = Auth::User()->id;
        $claim = Claim::findOrfail($request->claim_id);
        $data_cps = json_decode(json_encode(AjaxCommonController::getPaymentHistory($claim->code_claim_show),true),true);
        
        $data = [
            'claim_id' => $request->claim_id,
            'letter_template_id' => $request->letter_template_id,
            'status' => config('constants.statusExport.new'),
            'created_user' => $userId,
            'updated_user' => $userId,
            'info' => ['approve_amt' => $request->apv_hbs , 'deduct' => $request->deduct  ],
            'data_cps' => data_get($data_cps,'original.data'),
        ] ;
        ExportLetter::create($data);
        return redirect('/admin/claim/'. $request->claim_id )->with('Status', 'Letter was successfully created');
    }

    public function exportLetter(Request $request){

        $data = $this->letter($request->letter_template_id , $request->claim_id, $request->export_letter_id);
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Expires: 0");//no-cache
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
        header("content-disposition: attachment;filename={$data['namefile']}.doc");
        echo "<html>";      
        echo "<body>";
        echo $data['content'];
        echo "</body>";
        echo "</html>";
    }

    public function exportLetterPDF(Request $request){
        $data = $this->letterPayment($request->letter_template_id , $request->claim_id , $request->export_letter_id);
        header("Content-Type: application/pdf");
        header("Expires: 0");//no-cache
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
        header("content-disposition: attachment;filename={$data['namefile']}.pdf");
        echo $data['content'];
    }

    //ajax 
    public function previewLetter(Request $request){
        
        $data = $this->letter($request->letter_template_id , $request->claim_id , $request->export_letter_id);
        return response()->json(mb_convert_encoding($data['content'], 'UTF-8', 'UTF-8'));
    }

    // leter_payment
    public function letterPayment($letter_template_id , $claim_id ,$export_letter_id, $approve = null){
        $data = $this->letter($letter_template_id , $claim_id,  $export_letter_id);
        $export_letter = ExportLetter::findOrFail($export_letter_id);
        
        $create_user_sign = getUserSign($export_letter->created_user);
        $data['content'] = str_replace('[[$per_creater_sign]]', $create_user_sign, $data['content']);

        if($approve != null){
            $user = Auth::user();
            $approve_user_sign = getUserSign($user->id);
            $data['content'] = str_replace('[[$per_approve_sign]]', $approve_user_sign, $data['content']);
        }else{
            $data['content'] = str_replace('[[$per_approve_sign]]', "", $data['content']);
        }
        

        $mpdf = new \Mpdf\Mpdf(['tempDir' => base_path('resources/fonts/')]);
        $mpdf->WriteHTML('
        <div style="text-align: right; font-weight: bold; ">
            <img src="'.asset("images/header.jpg").'" alt="head">
        </div>');
        $mpdf->SetHTMLFooter('
        <div style="text-align: right; font-weight: bold;">
            <img src="'.asset("images/footer.png").'" alt="foot">
        </div>');
        $mpdf->WriteHTML( 
            '<div style="padding-top: 20px">'
            .$data['content'].
            '</div>'
        );      
        return ['content' => $mpdf->Output('filename.pdf',\Mpdf\Output\Destination::STRING_RETURN) , 'namefile' => $data['namefile']];
    }
    // export letter
    public function letter($letter_template_id , $claim_id ,$export_letter_id = null){
        
        $letter = LetterTemplate::findOrFail($letter_template_id);
        $claim  = Claim::itemClaimReject()->findOrFail($claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $namefile = Str::slug("{$letter->name}_{$HBS_CL_CLAIM->memberNameCap}", '-');
        $IOPDiag = IOPDiag($HBS_CL_CLAIM);
        $benefitOfClaim = benefitOfClaim($HBS_CL_CLAIM);
        $police = $HBS_CL_CLAIM->Police;
        $policyHolder = $HBS_CL_CLAIM->policyHolder;

        $payMethod = payMethod($HBS_CL_CLAIM);

        $CSRRemark_TermRemark = CSRRemark_TermRemark($claim);

        $plan = $HBS_CL_CLAIM->plan;
        
        $CSRRemark = $CSRRemark_TermRemark['CSRRemark'];
        $TermRemark = $CSRRemark_TermRemark['TermRemark'];
        $sumAppAmt = $HBS_CL_CLAIM->sumAppAmt ; 
        $export_letter = ExportLetter::findOrFail($export_letter_id);
        $note_pay =  note_pay($export_letter);
        if($export_letter->data_cps == null || $export_letter->data_cps == [] ){
            $time_pay = formatPrice($sumAppAmt);
            $paymentAmt = $time_pay;
        }else{
            $time_pay = [];
            foreach ($export_letter->data_cps as $key => $value) {
                $time_pay[] = "Thanh toán lần {$value['tf_times']}: " . formatPrice($value['tf_amt']);
            };
            if(collect($export_letter->data_cps)->sum('tf_amt') != $sumAppAmt){
                $time_pay[] = 'Thanh toán bổ sung: ' . formatPrice($sumAppAmt - collect($export_letter->data_cps)->sum('tf_amt'));
            }
            $time_pay[] = 'Tổng Cộng: '.formatPrice($sumAppAmt);
            $time_pay = implode("<br>",$time_pay);
            $paymentAmt = $sumAppAmt - collect($export_letter->data_cps)->sum('tf_amt');
        }

        $tableInfo = $this->tableInfoPayment($HBS_CL_CLAIM);

        $content = $letter->template;
        $content = str_replace('[[$note_pay]]', $note_pay, $content);
        $content = str_replace('[[$applicantName]]', $HBS_CL_CLAIM->applicantName, $content);
        $content = str_replace('[[$benefitOfClaim]]', $benefitOfClaim , $content);
        $content = str_replace('[[$IOPDiag]]', $IOPDiag , $content);
        $content = str_replace('[[$PRefNo]]', $police->pocy_ref_no, $content);
        $content = str_replace('[[$PhName]]', $policyHolder->poho_name_1, $content);
        $content = str_replace('[[$memberNameCap]]', $HBS_CL_CLAIM->memberNameCap, $content);
        $content = str_replace('[[$ltrDate]]', getVNLetterDate(), $content);
        $content = str_replace('[[$pstAmt]]', formatPrice($HBS_CL_CLAIM->sumPresAmt), $content);
        $content = str_replace('[[$payMethod]]', $payMethod, $content);
        $content = str_replace('[[$deniedAmt]]', formatPrice($HBS_CL_CLAIM->sumPresAmt - $sumAppAmt) , $content);
        $content = str_replace('[[$claimNo]]', $claim->code_claim_show , $content);
        $content = str_replace('[[$memRefNo]]', $HBS_CL_CLAIM->member->memb_ref_no , $content);
        $content = str_replace('[[$DOB]]', Carbon::parse($HBS_CL_CLAIM->member->dob)->format('d/m/Y') , $content);
        $content = str_replace('[[$SEX]]', str_replace('SEX_', "",$HBS_CL_CLAIM->member->scma_oid_sex) , $content);
        $content = str_replace('[[$PoNo]]', $police->pocy_no, $content);
        $content = str_replace('[[$EffDate]]', Carbon::parse($police->eff_date)->format('d/m/Y'), $content);

        $content = str_replace('[[$invoicePatient]]', implode(" ",$HBS_CL_CLAIM->HBS_CL_LINE->pluck('inv_no')->toArray()) , $content);
        if($CSRRemark){
            $content = str_replace('[[$CSRRemark]]', implode('',$CSRRemark) , $content);
            $content = str_replace('[[$TermRemark]]', implode('<br>',array_unique($TermRemark)) , $content);
        }
        $content = str_replace('[[$tableInfoPayment]]', $tableInfo , $content);
        $content = str_replace('[[$apvAmt]]', formatPrice($sumAppAmt), $content);
        $content = str_replace('[[$time_pay]]', $time_pay, $content);
        $content = str_replace('[[$paymentAmt]]', $paymentAmt, $content);
        return ['content' => $content , 'namefile' => $namefile];
        
    }

    function tableInfoPayment($HBS_CL_CLAIM){
        $sum_pre_amt = 0;
        $sum_app_amt = 0;
        $html = '
        <style type="text/css">
            table { page-break-inside:auto ; font-size: 11pt; font-family: arial, helvetica, sans-serif;}
            tr    { page-break-inside:avoid; page-break-after:auto ; font-size: 11pt; font-family: arial, helvetica, sans-serif;}
            thead { display:table-header-group ; font-size: 11pt; font-family: arial, helvetica, sans-serif;}
            tfoot { display:table-footer-group ; font-size: 11pt; font-family: arial, helvetica, sans-serif;}
        </style>
                <table style=" border: 1px solid black; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black" rowspan="2">Quyền lợi</th>
                            <th style="border: 1px solid black">Giới hạn thanh toán</th>
                            <th style="border: 1px solid black">Số tiền yêu cầu bồi thường (Căn cứ trên chứng từ hợp lệ) </th>
                            <th style="border: 1px solid black">Số tiền thanh toán</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black">Đồng</th>
                            <th style="border: 1px solid black">Đồng</th>
                            <th style="border: 1px solid black">Đồng</th>
                        </tr>
                    <thead>';
        $IP = [];
        $OP = [];
        $DT = [];
        foreach ($HBS_CL_CLAIM->HBS_CL_LINE as $keyCL_LINE => $valueCL_LINE) {
            switch ($valueCL_LINE->PD_BEN_HEAD->scma_oid_ben_type) {
                case 'BENEFIT_TYPE_DT':
                    $DT[] = $valueCL_LINE;
                    break;
                case 'BENEFIT_TYPE_OP':
                    $OP[] = $valueCL_LINE;
                    break;
                default:
                    $dateic = Carbon::parse($valueCL_LINE->incur_date_from)->format('dmy');
                    $hopital = Str::slug($valueCL_LINE->prov_name,'-');
                    $IP["$dateic-$hopital"][] = $valueCL_LINE;
                    break;
            }
        }
        $html .= '<tbody>';
            // nội trú
        foreach ($IP as $keyIP => $valueIP) {
            $html .= '<tr>
                    <td style="border: 1px solid black; font-weight:bold;">Nội Trú</td>
                    <td style="border: 1px solid black">Mỗi bệnh /thương tật </td>
                    <td style="border: 1px solid black"></td>
                    <td style="border: 1px solid black"></td>
                </tr>';
            foreach ($valueIP as $key => $value) {
                $content =config('constants.content_ip.'.$value->PD_BEN_HEAD->ben_head);
                $range_pay = "";
                $limit = $this->getlimitIP($value);
                switch ($value->PD_BEN_HEAD->ben_head) {
                    case 'ANES':
                    case 'OPR':
                    case 'SUR':
                        $range_pay = " Tối đa ".formatPrice($limit['amt'])." cho mỗi Bệnh tật/Thương tật, mỗi cuộc phẫu thuật";
                        break;
                    case 'HSP':
                    case 'HVIS':
                    case 'IMIS':
                    case 'PORX':
                    case 'POSH':
                    case 'LAMB':
                        $range_pay = " Tối đa ".formatPrice($limit['amt'])." cho mỗi Bệnh tật/Thương tật, mỗi năm";
                        break;
                    case 'RB':
                    case 'EXTB':
                    case 'ICU':
                    case 'HNUR':
                        $range_pay = " Tối đa ".formatPrice($limit['amt'])." mỗi ngày";
                        break;
                    case 'ER':
                    case 'TDAM':
                        $range_pay = " Tối đa ".formatPrice($limit['amt'])."  cho mỗi Tai nạn, mỗi năm";
                        break;
                    default:
                        $range_pay = " Tối đa ".formatPrice($limit['amt']);
                        break;
                }
                $html .=    '
                            <tr>
                                <td style="border: 1px solid black">'.$content.'</td>
                                <td style="border: 1px solid black">'.$range_pay.'</td>
                                <td style="border: 1px solid black; text-align: center; vertical-align: middle;">'.formatPrice($value->pres_amt).'</td>
                                <td style="border: 1px solid black ; text-align: center; vertical-align: middle;">'.formatPrice($value->app_amt).'</td>
                            </tr>
                            ';
                $sum_pre_amt += $value->pres_amt;
                $sum_app_amt += $value->app_amt;
            }
        }
        // ngoại trú
        foreach ($OP as $key => $value) {
            $content =config('constants.content_op.'.$value->PD_BEN_HEAD->ben_head);
            $limit = $this->getlimitOP($value);
            
            $content_limit = "";
            switch ($value->PD_BEN_HEAD->ben_head) {
                case 'OVRX':
                case 'OV':
                case 'RX':
                    $content_limit = "Từ trên ".formatPrice($limit['amt_from'])." đến tối đa ". formatPrice($limit['amt_to']) ." mỗi lần thăm khám";
                    break;
                
                default:
                    $content_limit = "Tối đa ".formatPrice($limit['amt_from'])." mỗi năm";
                    break;
            }
            if($key == 0){
                
                $html .= '<tr>
                            <td style="border: 1px solid black; font-weight:bold;">Ngoại Trú</td>
                            <td style="border: 1px solid black">Tối đa  '.formatPrice($limit['amt_yr']).' mỗi năm</td>
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black"></td>
                        </tr>';
            }
            $html .=    '<tr>
                            <td style="border: 1px solid black">'.$content.'</td>
                            <td style="border: 1px solid black">'.$content_limit.'</td>
                            <td style="border: 1px solid black; text-align: center; vertical-align: middle;">'.formatPrice($value->pres_amt).'</td>
                            <td style="border: 1px solid black; text-align: center; vertical-align: middle;">'.formatPrice($value->app_amt).'</td>
                        </tr>';
            $sum_pre_amt += $value->pres_amt;
            $sum_app_amt += $value->app_amt;
        }

        // rang
        foreach ($DT as $key => $value) {
            $limit = $this->getlimitDT($value);
            if($key == 0){
                
                $html .= '<tr>
                            <td style="border: 1px solid black; font-weight:bold;">Răng</td>
                            <td style="border: 1px solid black">Tối đa  '.formatPrice($limit['amt_yr']).' mỗi năm</td>
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black"></td>
                        </tr>';
            }
            $html .=    '<tr>
                            <td style="border: 1px solid black">Chi phí điều trị nha khoa '.$value->RT_DIAGNOSIS->diag_desc_vn.'</td>
                            <td style="border: 1px solid black">Từ trên '.formatPrice($limit['amt']).' mỗi lần thăm khám</td>
                            <td style="border: 1px solid black; text-align: center; vertical-align: middle;">'.formatPrice($value->pres_amt).'</td>
                            <td style="border: 1px solid black; text-align: center; vertical-align: middle;">'.formatPrice($value->app_amt).'</td>
                        </tr>';
            $sum_pre_amt += $value->pres_amt;
            $sum_app_amt += $value->app_amt;
        }
            $html .=    '<tr>
                            <th style="border: 1px solid black" colspan="2">Tổng cộng:</th>
                            
                            <th style="border: 1px solid black">'.formatPrice($sum_pre_amt).'</th>
                            <th style="border: 1px solid black">[[$time_pay]]</th>
                        </tr>';

        $html .= '</tbody>';
        $html .= '</table>';
        return $html;
    }

    function getlimitOP($value){
        $ben_head = $value->PD_BEN_HEAD->ben_head;
        $data= [];
        $data['amt_from'] = 0;
        foreach ($value->MR_POLICY_PLAN->PD_PLAN->PD_PLAN_LIMIT as $keyt => $valuet) {
            if($valuet->limit_type == 'T'){
                $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_OP');
                if( $array->count() > 0){
                
                    $data['amt_yr'] = $valuet->amt_yr == null ? 0 : $valuet->amt_yr;
                }
            }
            
            if($ben_head == 'OVRX'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_OP')->where('ben_head', 'OVRX');
                    
                    if( $array->count() > 0){
                        //dd($valuet);
                        $data['amt_from'] = $valuet->deduct_amt_vis == null ? 0 :  $valuet->deduct_amt_vis;
                        $data['amt_to'] = $valuet->amt_vis == null ? 0 :  $valuet->amt_vis;
                    }
                }
            }else{
                if ($valuet->limit_type == 'CH') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_OP')->whereIn('ben_head', ['ACUP', 'BSET', 'CGP', 'CMED', 'HERB', 'HLIS', 'HMEO', 'HYNO', 'OSTE']);
                    if( $array->count() > 0){
                        
                        $data['amt_from'] = $data['amt_from'] >= $valuet->amt_yr ? $data['amt_from'] :  $valuet->amt_yr;
                    }
                }
            }
        }
    
        return $data;
    }
    
    function getlimitDT($value){
        $ben_head = $value->PD_BEN_HEAD->ben_head;
        $data= [];
        $data['amt_from'] = 0;
        foreach ($value->MR_POLICY_PLAN->PD_PLAN->PD_PLAN_LIMIT as $keyt => $valuet) {
            if($valuet->limit_type == 'T'){
                $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_DT');
                if( $array->count() > 0){
                    $data['amt_yr'] = $valuet->amt_yr == null ? 0 : $valuet->amt_yr;
                    $data['amt'] = $valuet->amt_vis == null ? 0 : $valuet->amt_vis;
                }
            }
            
        }
    
        return $data;
    }

    function getlimitIP($value){
        $ben_head = $value->PD_BEN_HEAD->ben_head;
        $data= [];
        $data['amt'] = 0;
        foreach ($value->MR_POLICY_PLAN->PD_PLAN->PD_PLAN_LIMIT as $keyt => $valuet) {
            if($ben_head == 'ANES' || $ben_head == 'OPR' || $ben_head == 'SUR'){
                if ($valuet->limit_type == 'CH') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->whereIn('ben_head', ['ANES', 'OPR', 'SUR']);
                    
                    if( $array->count() > 0){
                        $data['amt'] = $data['amt'] >= $valuet->amt_dis_vis ? $data['amt'] :  $valuet->amt_dis_vis;
                    }
                }
            }
            if($ben_head == 'HSP' || $ben_head == 'HVIS' || $ben_head == 'IMIS' || $ben_head == 'POSH' || $ben_head == 'PORX'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->where('ben_head','IMIS');
                    
                    if( $array->count() > 0){
                        $data['amt'] =  $valuet->amt_dis_yr;
                    }
                }
            }

            if($ben_head == 'RB'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->where('ben_head','RB');
                    
                    if( $array->count() > 0){
                        $data['amt'] = $valuet->amt_day;
                    }
                }
            }

            if($ben_head == 'EXTB'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->where('ben_head','EXTB');
                    
                    if( $array->count() > 0){
                        $data['amt'] = $valuet->amt_day;
                    }
                }
            }

            if($ben_head == 'HNUR'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->where('ben_head','HNUR');
                    
                    if( $array->count() > 0){
                        $data['amt'] = $valuet->amt_day;
                    }
                }
            }

            if($ben_head == 'ER'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->where('ben_head','ER');
                    
                    if( $array->count() > 0){
                        $data['amt'] = $valuet->amt_dis_yr;
                    }
                }
            }

            if($ben_head == 'LAMB'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->where('ben_head','LAMB');
                    
                    if( $array->count() > 0){
                        $data['amt'] = $valuet->amt_dis_yr;
                    }
                }
            }

            if($ben_head == 'DON' || $ben_head == 'REC'){
                if ($valuet->limit_type == 'CH') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->whereIn('ben_head',['DON', 'REC']);
                    
                    if( $array->count() > 0){
                        $data['amt'] = $data['amt'] >= $valuet->amt_life ? $data['amt'] :  $valuet->amt_life;
                    }
                }
            }

            if($ben_head == 'CHEMO' || $ben_head == 'RADIA'){
                if ($valuet->limit_type == 'CH') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->whereIn('ben_head',['CHEMO', 'RADIA']);
                    
                    if( $array->count() > 0){
                        $data['amt'] = $data['amt'] >= $valuet->amt_dis_yr ? $data['amt'] :  $valuet->amt_dis_yr;
                    }
                }
            }

            if($ben_head == 'TDAM'){
                if ($valuet->limit_type == 'H') {
                    $array  = $valuet->PD_BEN_HEAD->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP')->where('ben_head','TDAM');
                    
                    if( $array->count() > 0){
                        $data['amt'] = $valuet->amt_dis_yr;
                    }
                }
            }
        }
    
        return $data;
    }
}



