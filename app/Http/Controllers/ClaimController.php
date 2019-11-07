<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Config;
use Storage;
use App\Claim;
use App\ItemOfClaim;
use App\User;
use App\Product;
use App\HBS_CL_CLAIM;
use App\LetterTemplate;
use DB;
use Auth;
use App\ReasonReject;
use App\Http\Requests\formClaimRequest;
use Illuminate\Support\Facades\Log;
use SimilarText\Finder;
use Carbon\Carbon;
use Illuminate\Support\Str;
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
        ];
        $datas = Claim::where('code_claim', 'like', '%' . $finder['code_claim'] . '%')->orderBy('id', 'desc')->paginate($itemPerPage);
        return view('claimManagement.index', compact('finder', 'datas', 'admin_list'));
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
            $reason = $request->_reason;
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
        $admin_list = User::getListIncharge();
        $dirStorage = Config::get('constants.formClaimStorage');
        $dataImage =  $dirStorage . $data->url_file ;
        $listReasonReject = ReasonReject::pluck('name', 'id');
        $items = $data->item_of_claim;
        $listLetterTemplate = LetterTemplate::pluck('name', 'id');

        return view('claimManagement.show', compact(['data', 'dataImage', 'items', 'admin_list', 'listReasonReject', 'listLetterTemplate']));
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
                                'parameters' => data_get($request->table1_parameters, $key),
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


    // export letter
    public function exportLetter(Request $request){ 
        $letter = LetterTemplate::findOrFail($request->letter_template_id);
        
        $claim  = Claim::itemClaimReject()->findOrFail($request->claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);

        $IOPDiag = [];
        foreach ($HBS_CL_CLAIM->HBS_CL_LINE as $key => $value) {
            
            switch ($value->PD_BEN_HEAD->scma_oid_ben_type) {
                case 'BENEFIT_TYPE_OP':
                    $IOPDiag[] = 'quyền lợi điều trị ngoại trú cho chẩn đoán “'.$value->RT_DIAGNOSIS->diag_desc_vn .'” từ '.Carbon::parse($value->incur_date_from)->toDateString().' đến '.Carbon::parse($value->incur_date_to)->toDateString().' tại '.$value->prov_name;
                    break;
                case 'BENEFIT_TYPE_IP':
                    $IOPDiag[] = 'quyền lợi điều trị nội trú cho chẩn đoán “'.$value->RT_DIAGNOSIS->diag_desc_vn .'” từ '.Carbon::parse($value->incur_date_from)->toDateString().' đến '.Carbon::parse($value->incur_date_to)->toDateString().' tại '.$value->prov_name;
                    break;
                default:

                    break;
            }
        }
        $IOPDiag = implode(' và ', $IOPDiag);

        $police = $HBS_CL_CLAIM->Police;
        $policyHolder = $HBS_CL_CLAIM->policyHolder;
        $payMethod = '';
    
        switch ($HBS_CL_CLAIM->payMethod) {
            case 'CL_PAY_METHOD_TT':
                $payMethod = 'chuyển khoản vào tài khoản của '. $HBS_CL_CLAIM->member->bank_name .', số TK: '. $HBS_CL_CLAIM->member->cl_pay_acct_no.' tại Ngân hàng '.$HBS_CL_CLAIM->member->bank_name.
                ', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city .' (Quý khách vui lòng kiểm tra tài khoản nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán).';
                break;
            case 'CL_PAY_METHOD_CA':
                $payMethod = 'nhận tiền bằng CMND của '.$HBS_CL_CLAIM->member->cash_beneficiary_name .', số CMND: '.$HBS_CL_CLAIM->member->cash_id_passport_no.', ngày cấp:  
                '.$HBS_CL_CLAIM->member->cash_id_passport_date_of_issue.', nơi cấp: '. $HBS_CL_CLAIM->member->cash_id_passport_date_of_issue .'; tại '.$HBS_CL_CLAIM->member->cash_bank_name.', '.$HBS_CL_CLAIM->member->cash_bank_branch.', '.$HBS_CL_CLAIM->member->cash_bank_city.' (Quý khách vui lòng mang theo CMND đến Ngân hàng nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán).';
                break;
            case 'CL_PAY_METHOD_CQ':
                $payMethod ="nhận tiền mặt tại Pacific Cross Vietnam, Lầu 16, Tháp B, Tòa nhà Royal Centre, 235 Nguyễn Văn Cừ, Phường Nguyễn Cư Trinh, Quận 1, TP. HCM (Quý khách vui lòng mang theo CMND đến Văn phòng nhận tiền từ Thứ Hai đến Thứ Sáu hàng tuần sau 1 ngày làm việc kể từ ngày chấp nhận thanh toán).";
                break;
            default:
                break;
        }
        
        $CSRRemark = [];
        $TermRemark = [];
        
        $arrKeyRep = [ '[##nameItem##]' , '[##amountItem##]' , '[##Date##]' , '[##Text##]' ];
        foreach ($claim->item_of_claim as $key => $value) {
            $tempale = $value->reason_reject->template; 
            foreach ( $arrKeyRep as $key2 => $value2) {
                $tempale = str_replace($value2, '$parameter', $tempale);
            };
            $TermRemark[] = $value->reason_reject->term->fullTextTerm;
            $CSRRemark[] = Str::replaceArray('$parameter', $value->parameters, $tempale);
        }
        
        $content = $letter->template;
        $content = str_replace('[[$applicantName]]', $HBS_CL_CLAIM->applicantName, $content);
        $content = str_replace('[[$IOPDiag]]', $IOPDiag , $content);
        $content = str_replace('[[$PRefNo]]', $police->pocy_ref_no, $content);
        $content = str_replace('[[$PhName]]', $policyHolder->poho_name_1, $content);
        $content = str_replace('[[$memberNameCap]]', strtoupper($HBS_CL_CLAIM->applicantName), $content);
        $content = str_replace('[[$ltrDate]]', getVNLetterDate(), $content);
        $content = str_replace('[[$pstAmt]]', formatPrice($HBS_CL_CLAIM->sumPresAmt), $content);
        $content = str_replace('[[$apvAmt]]', formatPrice($HBS_CL_CLAIM->sumAppAmt), $content);
        $content = str_replace('[[$payMethod]]', $payMethod, $content);
        $content = str_replace('[[$deniedAmt]]', formatPrice($HBS_CL_CLAIM->sumPresAmt - $HBS_CL_CLAIM->sumAppAmt) , $content);
        $content = str_replace('[[$CSRRemark]]', implode(' ',$CSRRemark) , $content);
        $content = str_replace('[[$TermRemark]]', implode(' ',array_unique($TermRemark)) , $content);
        
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Expires: 0");//no-cache
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
        header("content-disposition: attachment;filename=sampleword.doc");
        echo "<html>";
      
        echo "<body>";
        echo $content;
        echo "</body>";
        echo "</html>";
        
    }

}
