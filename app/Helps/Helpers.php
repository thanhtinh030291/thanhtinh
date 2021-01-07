<?php
use Illuminate\Support\Str;
use App\User;
use App\Message;
use App\Setting;
use App\ItemOfClaim;
use App\Events\Notify;
use App\Notifications\PushNotification;
use Pusher\Pusher;
use Illuminate\Support\Facades\Storage;

function getUserSign(){ // for member claim 
    $Setting = Setting::findOrFail('1');
    $user = User::findOrFail($Setting->manager_claim[0]);
    $dirStorage = config('constants.signarureStorage');
    $dataImage =  $dirStorage . $user->signarure ;
    $htm = "<span><img src='{$dataImage}' alt='face' height='120' width='140'></img><br/>
            $user->name
        </span>";
    return $htm;
}

function getUserSignThumb(){ // for provider claim
    $Setting = Setting::findOrFail('1');
    $user = User::findOrFail($Setting->manager_gop_claim[0]);
    $dirStorage = config('constants.signarureStorage');
    $dataImage =  $dirStorage . $user->signarure ;
    $htm = "<span><img src='{$dataImage}' alt='face' height='73' width='100'></img><br/>
            $user->name
        </span>";
    return $htm;
}

function saveImage($file ,$path, $thumbnail=null){
    if (!File::exists(storage_path("app".$path)))
    {
        File::makeDirectory(storage_path("app".$path), 0777, true, true);
    }
    if (!File::exists(storage_path("app".$path."thumbnail/")))
    {
        File::makeDirectory(storage_path("app".$path."thumbnail/"), 0777, true, true);
    }
    $file_name =  md5($file->getClientOriginalName().time()) . '.' . $file->getClientOriginalExtension();
        $image = Image::make($file)
            ->resize(400,null,function ($constraint) {
                $constraint->aspectRatio();
                })
            ->save(storage_path("app".$path) . $file_name);
        if($thumbnail){
            $image->resize(90, 90)
            ->save(storage_path("app".$path."thumbnail/"). $file_name);
        }
            

    return $file_name;
}

function saveFile($file ,$path ,$oldFile = null)
{
    if($oldFile){
        Storage::delete($path.$oldFile);
    }
    $fileName = time() . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
    $file->storeAs($path, $fileName);
    return $fileName;
}

function saveFileContent($file_content ,$path ,$ext,$oldFile = null)
{
    if($oldFile){
        Storage::delete($path.$oldFile);
    }
    $fileName = uniqid() . md5(microtime()) . '.' .$ext;
    Storage::put($path."/".$fileName, $file_content);
    return $fileName;
}


function GetApiMantic($url)
{
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => config('constants.token_mantic'),
    ];
    
    try {
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $request = $client->get(config('constants.url_mantic_api').$url);
        $response = $request->getBody();
    }catch (GuzzleHttp\Exception\ClientException $e) {
        $response = $e->getResponse()->getBody(true);
    }
    
    
    return json_decode($response->getContents(), true);
}

//truncate string

function truncate($string , $limit = 100){
    return Str::limit($string, $limit);
}

function PostApiMantic($url,$body) {
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => config('constants.token_mantic'),
    ];
    $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
    $response = $client->request("POST", config('constants.url_mantic_api').$url , ['form_params'=>$body]);
    return $response;
}

function PostApiManticHasFile($url,$body) {
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => config('constants.token_mantic'),
    ];
    $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
      

    $response = $client->request("POST", config('constants.url_mantic_api').$url , $body);

    return $response;
}

function sendEmail($user_send, $data , $template , $subject)
{
    if (!data_get($user_send, 'email')) {
        return false;
    }
    $app_name  = config('constants.appName');
    $app_email = config('constants.appEmail');
    Mail::send(
        $template, 
        [
            'user' => $user_send, 
            'data' => $data 
        ], function ($mail) use ($user_send, $app_name, $app_email, $subject) {
            $mail
                ->to($user_send->email, $user_send->name)
                ->subject($subject);
        }
    );
    return true;
}

function sendEmailProvider($user_send, $to_email , $to_name, $subject, $data , $template)
{
    if (!data_get($user_send, 'email')) {
        return false;
    }
    $app_name  = config('constants.appName');
    $app_email = config('constants.appEmail');
    Mail::send(
        $template, 
        [
            'user' => $user_send, 
            'data' => isset($data) ?  $data : []
        ], function ($mail) use ($user_send, $to_email, $to_name, $subject, $app_name, $app_email, $data) {
            $mail
                ->to( $to_email)
                ->cc([$user_send->email])
                ->replyTo($user_send->email, $user_send->name)
                ->attachData(base64_decode($data['attachment']['base64']), $data['attachment']['filename'], ['mime' => $data['attachment']['filetype']])
                ->subject($subject);
        }
    );
    return true;
}
// set active value
function setActive(string $path, $class = 'active') {
    $requestPath = implode('/', array_slice(Request::segments(), 0, 2));
    return $requestPath === $path ? $class : "";
}
/**
 * Get class name base on relative_url input & now request
 *
 * @param string $relative_url [normal use route('name', [], false)]
 * @param string $class        [class name when true path & active]
 *
 * @return string [$class or '']
 */
function setActiveByRoute(string $relative_url, $class = 'active') 
{
    $request_path = '/'. implode('/', request()->segments());
    return $request_path === $relative_url ? $class : "";
}

function loadImg($imageName = null, $dir = null) {
    if (strlen(strstr($imageName, '.')) > 0) {
        return $dir . $imageName;
    } else {
        return '/images/noimage.png';
    }
}

function loadAvantarUser($avantar){
    if($avantar == 'admin.png'){
        return '/images/noimage.png';
    }else{
        return loadImg($avantar, config('constants.avantarStorage').'thumbnail/');
    }
    
}

function generateLogMsg(Exception $exception) {
    $message = $exception->getMessage();
    $trace   = $exception->getTrace();

    $first_trace = head($trace);
    $file = data_get($first_trace, 'file');
    $line = data_get($first_trace, 'line');
    return $message . ' at '. $file . ':' . $line;
}

/**
 * Format price display
 *
 * @param mixed  $number        [string|int|float need format price]
 * @param string $symbol        [symbol after price]
 * @param bool   $insert_before [true => insert symbol before, else insert after price]
 *
 * @return string
 */
function formatPrice($number, $symbol = '', $insert_before = false)
{
    if (empty($number)) {
        return $insert_before == true ? $symbol.(int)$number : (int)$number.$symbol;
    }
    $number   = removeFormatPrice((string)$number);
    $parts    = explode(".", $number);
    $pattern  = '/\B(?=(\d{3})+(?!\d))/';
    $parts[0] = preg_replace($pattern, ".", $parts[0]);
    return $insert_before == true ? $symbol.implode(".", $parts) : implode(".", $parts).$symbol;
}

function formatVN($string)
{
    $pattern  = '/[^a-z0-9A-Z_[:space:]ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂ ưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]/u';
    return preg_replace($pattern, "", $string);;
}
/**
 * Remove format price become string
 *
 * @param string $string [string for remove format price]
 *
 * @return string
 */
function removeFormatPrice($string) 
{
    if (empty($string)) {
        return $string;
    }
    $pattern = '/[^0-9|.]+/';
    $string  = preg_replace($pattern, "", $string);
    return $string;
}

/**
 * Remove format number of all element inside array
 *
 * @param array $price_list [array need remove format number price]
 * 
 * @return array
 */
function removeFormatPriceList(array $price_list)
{
    if (empty($price_list)) {
        return [];
    }

    $result = [];
    foreach ($price_list as $key => $value) {
        if (is_array($value)) {
            $result[$key] = removeFormatPriceList($value);
        } else {
            $result[$key] = removeFormatPrice($value);
        }
    }
    return $result;
}

function array_shift_assoc( &$arr ){
    $val = reset( $arr );
    unset( $arr[ key( $arr ) ] );
    return $val; 
}


function getVNLetterDate() {
    $letter =  Carbon\Carbon::now();
    $letter = $letter->addDays(2);
    if ($letter->isWeekday(6)) {
        $letter = $letter->addDays(2);
    } else if ($letter->isWeekday(0)) {
        $letter = $letter->addDays(1);
    }
    return $letter->toDateString();
}

function dateConvertToString($date = null) 
    { 
    try {
        $_s = strtotime(date("Y-m-d H:i:s")) - strtotime($date);
        if(round($_s / (60*60*24)) >= 1)
        {
            // to day
            $rs_date = round($_s / (60*60*24)) . " day ago";
        }
        else
        {
            if(round($_s / (60*60)) >= 1)
            {
                // to hours
                $rs_date = round($_s / (60*60)) . " hours ago";
            }
            else
            {
                // to minutes
                $rs_date = round($_s / 60) . " minutes ago";
            }
        }   
    } catch (\Exception $e) {
        $rs_date = null;
    }
    return $rs_date;
}

// return start , end hours from daterangepickker

function getHourStartEnd($text){
    //24/10/2014 00:00 - 30/10/2014 23:59
    
    $start = trim(explode('-', $text)[0]);
    $end = trim(explode('-', $text)[1]);

 
    return [
        'date_start' =>  explode(' ', $start)[0],
        'hours_start' =>  explode(' ', $start)[1],
        'date_end' =>  explode(' ', $end)[0],
        'hours_end' =>  explode(' ', $end)[1],
    ];
}


// print leter payment method

function payMethod($HBS_CL_CLAIM){
    $name_reciever = "";
    $info_reciever = "";
    $banking = "";
    $notify = "";
   
    switch ($HBS_CL_CLAIM->payMethod) {
        case 'CL_PAY_METHOD_TT':
            
            $name_reciever = $HBS_CL_CLAIM->member->cl_pay_acct_name;
            $info_reciever = 'Số tài khoản: '.$HBS_CL_CLAIM->member->cl_pay_acct_no;
            //$banking = $HBS_CL_CLAIM->member->bank_name.', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city;
            $banking = $HBS_CL_CLAIM->member->BankNameChange.', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city;
            $notify = "Quý khách vui lòng kiểm tra tài khoản nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán.";
            $not_show_table = false;
            break;
        case 'CL_PAY_METHOD_CA':
            $name_reciever = $HBS_CL_CLAIM->member->cash_beneficiary_name;
            $info_reciever = "CMND/Căn cước công dân: " .$HBS_CL_CLAIM->member->cash_id_passport_no.', ngày cấp:  
            '.Carbon\Carbon::parse($HBS_CL_CLAIM->member->cash_id_passport_date_of_issue)->format('d/m/Y').', nơi cấp: '. $HBS_CL_CLAIM->member->cash_id_passport_issue_place;
            //$banking = $HBS_CL_CLAIM->member->cash_bank_name.', '.$HBS_CL_CLAIM->member->cash_bank_branch.', '.$HBS_CL_CLAIM->member->cash_bank_city ;
            $banking = $HBS_CL_CLAIM->member->CashBankNameChange.', '.$HBS_CL_CLAIM->member->cash_bank_branch.', '.$HBS_CL_CLAIM->member->cash_bank_city ;
            $notify = "Quý khách vui lòng mang theo CMND đến Ngân hàng nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán";
            $not_show_table = false;
            break;
        case 'CL_PAY_METHOD_CQ':
            $name_reciever = $HBS_CL_CLAIM->member->cash_beneficiary_name;
            $info_reciever = " ";
            $banking = "";
            $notify ="Nhận tiền mặt tại Pacific Cross Vietnam, Lầu 16, Tháp B, Tòa nhà Royal Centre, 235 Nguyễn Văn Cừ, Phường Nguyễn Cư Trinh, Quận 1, TP. HCM (Quý khách vui lòng mang theo CMND đến Văn phòng nhận tiền từ Thứ Hai đến Thứ Sáu hàng tuần sau 1 ngày làm việc kể từ ngày chấp nhận thanh toán)";
            $not_show_table = false;
            break;
        default:
            $name_reciever = " ";
            $info_reciever = " ";
            $banking = "";
            $notify = " Đóng phí bảo hiểm cho hợp đồng số ". $HBS_CL_CLAIM->Police->pocy_ref_no  ;
            $not_show_table = true;
            break;
    }
    $payMethod =    '<table style=" border: 1px solid black; border-collapse: collapse;">
                        <tbody>
                        <tr>
                            <td style="border: 1px solid black; width: 350px; font-family: arial, helvetica, sans-serif ; font-size: 11pt">
                                <p>Tên người thụ hưởng: '.$name_reciever.'</p>
                            </td>
                            <td style="border: 1px solid black; width: 350px; font-family: arial, helvetica, sans-serif ; font-size: 11pt">
                                <p>'.$info_reciever.'</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; font-family: arial, helvetica, sans-serif ; font-size: 11pt" colspan="2">
                                <p>Tên và địa chỉ Ngân hàng: '.$banking.'</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; font-family: arial, helvetica, sans-serif ; font-size: 11pt" colspan="2">
                                <p>'.$notify.'</p>
                            </td>
                        </tr>
                    </tbody>
                    </table>';
    if($not_show_table){
        $payMethod = '<span style=" font-family: arial, helvetica, sans-serif ; font-size: 11pt;"><strong>'.$notify.'</strong></span>';
    }
    
    return $payMethod;
}

// print letter IOPDiag

function IOPDiag($HBS_CL_CLAIM, $claim_id){
    $IOPDiag = [];
        $ClaimWordSheet = App\ClaimWordSheet::where('claim_id',$claim_id)->first();
        if(data_get($ClaimWordSheet,'type_of_visit') == null || data_get($ClaimWordSheet,'type_of_visit') == []){
            foreach ($HBS_CL_CLAIM->HBS_CL_LINE as $key => $value) {
                switch ($value->PD_BEN_HEAD->scma_oid_ben_type) {
                    case 'BENEFIT_TYPE_OP':
                        $from_date = Carbon\Carbon::parse($value->incur_date_from)->format('d/m/Y');
                        $to_date = Carbon\Carbon::parse($value->incur_date_to)->format('d/m/Y');
                        $IOPDiag[] = "Chẩn đoán: " . $value->RT_DIAGNOSIS->diag_desc_vn ." <br>
                                    Ngày khám: $from_date tại ". $value->prov_name . ".";
    
                        break;
                    case 'BENEFIT_TYPE_IP':
                        $from_date = Carbon\Carbon::parse($value->incur_date_from)->format('d/m/Y');
                        $to_date = Carbon\Carbon::parse($value->incur_date_to)->format('d/m/Y');
                        $IOPDiag[] = "Chẩn đoán: ". $value->RT_DIAGNOSIS->diag_desc_vn ." <br>
                                Ngày nhập viện: $from_date, ngày xuất viện:  $to_date tại ". $value->prov_name. ".";
                        break;
                    default:
                        $from_date = Carbon\Carbon::parse($value->incur_date_from)->format('d/m/Y');
                        $to_date = Carbon\Carbon::parse($value->incur_date_to)->format('d/m/Y');
                        $IOPDiag[] = "Chẩn đoán: " . $value->RT_DIAGNOSIS->diag_desc_vn ." <br>
                                    Ngày khám: $from_date tại ". $value->prov_name . ".";
                        break;
                }
            }
        }else{
            
            foreach(data_get($ClaimWordSheet,'type_of_visit') as $key => $value){
                if(data_get($value,'to') == null){
                    $IOPDiag[] = "Chẩn đoán: " . data_get($value,'diagnosis') ." <br>
                                Ngày khám: ".data_get($value,'from')." tại ". data_get($value,'prov_name') . ".";

                }else{
                    $IOPDiag[] = "Chẩn đoán: ".data_get($value,'diagnosis') ." <br>
                            Ngày nhập viện: ".data_get($value,'from').", ngày xuất viện:  ".data_get($value,'to')." tại ". data_get($value,'prov_name'). ".";
                }
            }
        }
    $IOPDiag = implode('<br>', array_unique($IOPDiag));
    return $IOPDiag;
}

function IOPDiagWookSheet($HBS_CL_CLAIM){
    $IOPDiag = [];
        foreach ($HBS_CL_CLAIM->HBS_CL_LINE as $key => $value) {
            switch ($value->PD_BEN_HEAD->scma_oid_ben_type) {
                case 'BENEFIT_TYPE_OP':
                    $IOPDiag[$key]['from'] = Carbon\Carbon::parse($value->incur_date_from)->format('d/m/Y');
                    $IOPDiag[$key]['to'] = null;
                    $IOPDiag[$key]['diagnosis'] = $value->RT_DIAGNOSIS->diag_desc_vn;
                    $IOPDiag[$key]['prov_name'] = $value->prov_name;
                    break;
                case 'BENEFIT_TYPE_IP':
                    $IOPDiag[$key]['from'] = Carbon\Carbon::parse($value->incur_date_from)->format('d/m/Y');
                    $IOPDiag[$key]['to'] = Carbon\Carbon::parse($value->incur_date_to)->format('d/m/Y');
                    $IOPDiag[$key]['diagnosis'] = $value->RT_DIAGNOSIS->diag_desc_vn;
                    $IOPDiag[$key]['prov_name'] = $value->prov_name;
                    break;
                default:

                    break;
            }
        }
    
    return $IOPDiag;
}
// print letter benefitOfClaim

function benefitOfClaim($HBS_CL_CLAIM){
   
    $benefitOfClaim = [];
        foreach ($HBS_CL_CLAIM->HBS_CL_LINE as $key => $value) {
            switch ($value->PD_BEN_HEAD->scma_oid_ben_type) {
                case 'BENEFIT_TYPE_DT':
                    $benefitOfClaim[] = 'chăm sóc răng';
                    break;
                case 'BENEFIT_TYPE_OP':
                    $benefitOfClaim[] = 'ngoại trú';
                    break;
                default:
                    $benefitOfClaim[] = 'nội trú';
                    break;
            }
        }
    $benefitOfClaim = implode(', ', array_unique($benefitOfClaim));
    return $benefitOfClaim;
}


// print CRRMArk AND TERM

function CSRRemark_TermRemark($claim){
    $CSRRemark = [];
    $TermRemark = [];
    $hasTerm3 = null;
    $hasTerm2 = null;
    $hasTerm1 = null;
    
    $arrKeyRep = [ '[##nameItem##]' , '[##amountItem##]' , '[##Date##]' , '[##Text##]' ];
    $item = ItemOfClaim::where('claim_id', $claim->id)->where('status',1)->get();
    $itemsReject = $item->pluck('content')->toArray();
    $amountsReject = $item->pluck('amount');
    $sumAmountReject = 0;
    foreach ($amountsReject as $key => $value) {
        $sumAmountReject += removeFormatPrice($value);
    }
    $itemOfClaim = $claim->item_of_claim->groupBy('reason_reject_id');
    $templateHaveMeger = [];
    foreach ($itemOfClaim as $key => $value) {
        $template = $value[0]->reason_reject->template;
        if(isset($value[0]->reason_reject->term->fullTextTerm)){
            $TermRemark[] = $value[0]->reason_reject->term->fullTextTerm;
        }
        
        if (!preg_match('/\[Begin\].*\[End\]/U', $template)){
            foreach ($value as $keyItem => $item) {
                $template_new = $template;
                foreach ( $arrKeyRep as $key2 => $value2) {
                    $template_new = str_replace($value2, '$parameter', $template_new);
                };
                $CSRRemark[] = Str::replaceArray('$parameter', $item->parameters, $template_new);
            }
        }else{
            preg_match_all('/\[Begin\].*\[End\]/U', $template, $matches);
            $template_new = preg_replace('/\[Begin\].*\[End\]/U' , '$arrParameter' , $template );
            $arrMatche = [];
            foreach ($value as $keyItem => $item) {
                foreach ($matches[0] as $keyMatche => $valueMatche) {
                    foreach ( $arrKeyRep as $key2 => $value2) {
                        $valueMatche = str_replace( $value2, '$parameter', $valueMatche);
                    };
                    $arrMatche[$keyMatche][] =  Str::replaceArray('$parameter', preg_replace('/(,)/', '.', $item->parameters), $valueMatche);
                }
            }
            // array to string 
            $arr_str = [];
            foreach ($arrMatche as $key => $value) {
                $arr_str[] = preg_replace('/\[Begin\]|\[End\]/', '', implode(", ", $value));
            }
            $CSRRemark[] = Str::replaceArray('$arrParameter', $arr_str, $template_new);
        }
    }
    $TermRemark = collect($TermRemark)->sortBy('group')->groupBy('group');
    $show_term = [];
    foreach ($TermRemark as $key => $value) {
        switch ($key) {
            case '3':
                $show_term[] = "<p style='text-align: justify;'><span style='font-family: arial, helvetica, sans-serif ; font-size: 11pt'>Quý khách vui lòng tham khảo Điều 3_ Các quy định loại trừ trách nhiệm bảo hiểm của Quy tắc và điều khoản bảo hiểm Chăm sóc sức khỏe: “Dai-ichi Life Việt Nam sẽ không thanh toán quyền lợi điều trị nội trú và điều trị ngoại trú theo quy định tại Điều 2 của Quy tắc, Điều khoản sản phẩm bổ sung này nếu việc điều trị Bệnh tật/Thương tật của Người được bảo hiểm thuộc bất kỳ trường hợp hoặc sự việc nào sau đây”: </span></p>";
                break;
            case '2':
                $show_term[] = "<p style='text-align: justify;'><span style='font-family: arial, helvetica, sans-serif ; font-size: 11pt'>Quý khách vui lòng tham khảo Điều 2_ Các quyền lợi bảo hiểm của Quy tắc và Điều khoản bảo hiểm Chăm sóc sức khỏe:</span></p>";
                break;
            default:
                $show_term[] = "<p style='text-align: justify;'><span style='font-family: arial, helvetica, sans-serif ; font-size: 11pt'>Quý khách vui lòng tham khảo Điều 1_ Các định nghĩa của Quy tắc và Điều khoản bảo hiểm Chăm sóc sức khỏe:</span></p>";
                break;
        }
        $collect_value = collect($value)->sortBy('num');
        foreach ($collect_value as $key_c => $value_c) {
            $show_term[] = $value_c['content'];
        }
    }
    
    
    return [ 'CSRRemark' => $CSRRemark , 'TermRemark' => $show_term , 'itemsReject' => $itemsReject , 'sumAmountReject' => $sumAmountReject];
    
}

function note_pay($export_letter){
    $htm = '<p style = "font-size: 10px; padding: 0px ;margin: 0px">Note: : Claim số [[$claimNo]] tổng thanh toán bồi thường [[$apvAmt]] đồng.</p>';
    if(!empty($export_letter->data_cps) || $export_letter->data_cps != null){
        foreach ($export_letter->data_cps as $key => $value) {
            $tf_date =  Carbon\Carbon::parse($value['TF_DATE'])->format('d/m/Y');
            $tf_amt = formatPrice($value['TF_AMT']);
            if($value['TF_DATE'] != null){
                $htm .= "<p style='font-size: 10px; padding: 0px ;margin: 0px'>Payment lần {$value['PAYMENT_TIME']} ngày {$tf_date} thanh toán cho khách hàng {$tf_amt} đồng.</p>";
            }else{
                $htm .= "<p style='font-size: 10px; padding: 0px ;margin: 0px'>Payment lần {$value['PAYMENT_TIME']}  thanh toán cho khách hàng {$tf_amt} đồng.</p>";
            }
        }
    }
    if(data_get($export_letter->info,'PCV_EXPENSE', 0) != 0){
        $htm .= "<p style='font-size: 10px; padding: 0px ;margin: 0px'>TT dư " . formatPrice(data_get($export_letter->info,'PCV_EXPENSE', 0))." đồng.</p>";
    }
    return $htm;
}

function datepayment(){
    $now = Carbon\Carbon::now();
    
    switch ($now->dayOfWeek) {
        case 5:
            $now = $now->addDays(3);
            break;
        case 6:
            $now = $now->addDays(2);
            break;
        default:
            $now = $now->addDays(1);
            break;
    }
    return $now->format("d/m/Y");
}
function notifi_system($content, $arrUserID = []){
    $user = App\User::findOrFail(1);
    $options = array(
        'cluster' => config('constants.PUSHER_APP_CLUSTER'),
        'encrypted' => true
    );
    $data['title'] = $user->name . ' gửi tin cho bạn';
    $data['content'] = $content;
    $data['avantar'] = config('constants.avantarStorage').'thumbnail/'.$user->avantar;
    $pusher = new Pusher(
        config('constants.PUSHER_APP_KEY'),
        config('constants.PUSHER_APP_SECRET'),
        config('constants.PUSHER_APP_ID'),
        $options
    );
    $data_messageSent = [];
    foreach ($arrUserID as $key => $value) {
        $data_messageSent[] = [
            'user_to' => $value,
            'message' => $content
        ];
    }
    $mesage_data = $user->messagesSent()->createMany($data_messageSent);
    foreach ($arrUserID as $key => $value) {
        $pusher->trigger('NotifyUser-'.$value,'Notify' ,$data);
    }
    
    $user_to = User::whereIn('id', $arrUserID)->get();
    foreach ($user_to as $key => $value) {
        $value->notify(new PushNotification(
            $data['title'] , 
            $data['content'] , 
            $data['avantar'] , 
            url('admin/message')
        ));
    }
    
    return redirect('/admin/home/');
}


// Get token CPS
function getTokenCPS(){
    $headers = [
        'Content-Type' => 'application/json',
    ];
    $body = [
        'client_id' => config('constants.client_id'),
        'client_secret' => config('constants.client_secret'),
        'grant_type' => config('constants.grant_type'),
    ];
    $setting = Setting::where('id', 1)->first();
    if($setting === null){
        $setting = Setting::create([]);
    }
    $startTime = Carbon\Carbon::parse($setting->updated_at);
    $now = Carbon\Carbon::now();
    $totalDuration = $startTime->diffInSeconds($now);
    if($setting->token_cps == null || $totalDuration >= 3500){
        // $client = new \GuzzleHttp\Client([
        //     'headers' => $headers
        // ]);
        // $response = $client->request("POST", config('constants.api_cps').'get_token' , ['form_params'=>$body]);
        // $response =  json_decode($response->getBody()->getContents());
        //$setting->token_cps = data_get($response , 'access_token');
        $setting->token_cps = "47b34f9f1507e72b0711e7c7be684dcb189b0f62";
        $setting->save();
    }
    return  $setting->token_cps;
}

function typeGop($value){
    $rp = "";
    foreach (config('constants.gop_type') as $key_type => $value_type) {
        $checked = $value == $key_type ? 'checked' : '';
        $rp .=   "<input type='radio' {$checked}>
                <span style='font-family: serif; font-size: 10pt;'>{$value_type}</span><br>";
    }
    return $rp;
}

function MessageComfirmConract($memb_ref_no){
    $headers = [
        'Content-Type' => 'application/json',
    ];
    $client = new \GuzzleHttp\Client([
        'headers' => $headers
    ]);
    
    try {
        $request = $client->request('GET', config('constants.url_query_online').$memb_ref_no, ['connect_timeout' => 3]);
        $response = $request->getBody()->getContents();
        $response = json_decode($response,true);
        if(data_get($response, 'response_msg.msg_code') == "DLVN0"){
            $client_info = collect($response['client_info'])->whereNotIn('sStatus', ['Not-Taken']);
            $all_lapse_process_date = collect($response['all_lapse_process_date']);
            $all_lapse_effective_date = collect($response['all_lapse_effective_date']);
            $all_reinstate_date = collect($response['all_reinstate_date']);
            $map_ql = $client_info->map(function ($item, $key) {
                $t = "";
                switch (substr(trim(data_get($item,'sPlanID')), 3,1)) {
                    case 'O':
                        $t = "OP";
                        break;
                    case 'I':
                        $t = "IP";   
                        break;
                    default:
                        $t = "DT";
                        break;
                }
                return  $t ."-" . (int)trim(data_get($item,'dFaceAmount')) / 1000000;
            });
            
            $html = 'Dear DLVN ' . "\n". "\n";
            $html .= 'Vui lòng xác nhận tình trạng hợp đồng.' . "\n";
            $html .= "Quyền lợi: " .implode(", ",$map_ql->toArray()) . "\n";
            $html .= "Hiệu lực: " . Carbon\Carbon::parse($client_info->first()['sCoverageIssueDate'])->format('d/m/Y') . "\n";
            $html .= "Tình trạng: ". $client_info->first()['sStatus'] . "\n". "\n";
            if($all_lapse_effective_date->count() > 0 ){
                $html .=  "Lapse effective: ". Carbon\Carbon::parse($all_lapse_effective_date->first()['sDate'])->format('d/m/Y') . "\n";
            }
            if($all_lapse_process_date->count() > 0 ){
                $html .=  "Lapse process: ". Carbon\Carbon::parse($all_lapse_process_date->first()['sDate'])->format('d/m/Y') . "\n";
            }
            if($all_reinstate_date->count() > 0 ){
                $html .=  "Reinstate: ". Carbon\Carbon::parse($all_reinstate_date->first()['sDate'])->format('d/m/Y') . "\n";
            }
            $html .=  "\n"."Thanks." . "\n";
            return $html;
        }else{
            return "";
        }
    } catch ( Exception $e) {
        return "";
    }
    
}

function QueryOnline($memb_ref_no){
        
    $headers = [
        'Content-Type' => 'application/json',
    ];
    $client = new \GuzzleHttp\Client([
        'headers' => $headers
    ]);
    try {
        $request = $client->get(config('constants.url_query_online').$memb_ref_no);
        $response = $request->getBody()->getContents();
        return $response;

    } catch (Exception $e) {
        return "";
    }
}


