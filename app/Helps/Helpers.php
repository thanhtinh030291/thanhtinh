<?php
use Illuminate\Support\Str;
use App\User;
use App\Message;
use App\Events\Notify;
use App\Notifications\PushNotification;
use Pusher\Pusher;
function getUserSign($id){
    $user = User::findOrFail($id);
    $dirStorage = config('constants.signarureStorage');
    $dataImage =  $dirStorage . $user->signarure ;
    $htm = "
    <p><img src='{$dataImage}' alt='face' height='150' width='150'></img></p>
    <p>$user->name</p>
    ";
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
function GetApiMantic($url)
{
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => config('constants.token_mantic'),
    ];
    $client = new \GuzzleHttp\Client([
        'headers' => $headers
    ]);
    $request = $client->get(config('constants.url_mantic').$url);
    $response = $request->getBody();
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
    $response = $client->request("POST", config('constants.url_mantic').$url , ['form_params'=>$body]);

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
            $mail->from($app_email, $app_name)
                ->to($user_send->email, $user_send->name)
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
            $banking = $HBS_CL_CLAIM->member->bank_name.', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city;
            $notify = "Quý khách vui lòng kiểm tra tài khoản nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán.";
            break;
        case 'CL_PAY_METHOD_CA':
            $name_reciever = $HBS_CL_CLAIM->member->cash_beneficiary_name;
            $info_reciever = "CMND/Căn cước công dân: " .$HBS_CL_CLAIM->member->cash_id_passport_no.', ngày cấp:  
            '.Carbon\Carbon::parse($HBS_CL_CLAIM->member->cash_id_passport_date_of_issue)->format('d/m/Y').', nơi cấp: '. $HBS_CL_CLAIM->member->cash_id_passport_issue_place;
            $banking = $HBS_CL_CLAIM->member->cash_bank_name.', '.$HBS_CL_CLAIM->member->cash_bank_branch.', '.$HBS_CL_CLAIM->member->cash_bank_city ;
            $notify = "Quý khách vui lòng mang theo CMND đến Ngân hàng nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán";
            break;
        case 'CL_PAY_METHOD_CQ':
            $name_reciever = $HBS_CL_CLAIM->member->cash_beneficiary_name;
            $info_reciever = " ";
            $banking = "";
            $notify ="Nhận tiền mặt tại Pacific Cross Vietnam, Lầu 16, Tháp B, Tòa nhà Royal Centre, 235 Nguyễn Văn Cừ, Phường Nguyễn Cư Trinh, Quận 1, TP. HCM (Quý khách vui lòng mang theo CMND đến Văn phòng nhận tiền từ Thứ Hai đến Thứ Sáu hàng tuần sau 1 ngày làm việc kể từ ngày chấp nhận thanh toán)";
            break;
        default:
            $name_reciever = " ";
            $info_reciever = " ";
            $banking = "";
            $notify = "Số tiền trên được thanh toán cho quý khách bằng hình thức thanh toán đóng phí hợp đồng ". $HBS_CL_CLAIM->Police->pocy_ref_no ;
            break;
    }
    $payMethod =    '<table style=" border: 1px solid black; border-collapse: collapse;">
                        <tbody>
                        <tr>
                            <td style="border: 1px solid black; width: 350px;">
                                <p>Tên người thụ hưởng: '.$name_reciever.'</p>
                            </td>
                            <td style="border: 1px solid black; width: 350px;">
                                <p>'.$info_reciever.'</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black" colspan="2">
                                <p>Tên và địa chỉ Ngân hàng: '.$banking.'</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black" colspan="2">
                                <p>'.$notify.'</p>
                            </td>
                        </tr>
                    </tbody>
                    </table>';
    return $payMethod;
}

// print letter IOPDiag

function IOPDiag($HBS_CL_CLAIM){
    $IOPDiag = [];
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

                    break;
            }
        }
    $IOPDiag = implode('<br>', array_unique($IOPDiag));
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
    $itemOfClaim = $claim->item_of_claim->groupBy('reason_reject_id');
    $templateHaveMeger = [];
    foreach ($itemOfClaim as $key => $value) {
        $template = $value[0]->reason_reject->template;
        if(isset($value[0]->reason_reject->term->fullTextTerm)){
            $TermRemark[] = $value[0]->reason_reject->term->fullTextTerm;
            preg_match('/(3\..*)/', $value[0]->reason_reject->term->name , $matches_term3, PREG_OFFSET_CAPTURE);
            if($matches_term3){
                $hasTerm3 = true;
            }
            preg_match('/(2\..*)/', $value[0]->reason_reject->term->name , $matches_term2, PREG_OFFSET_CAPTURE);
            if($matches_term2){
                $hasTerm2 = true;
            }
            preg_match('/(1\..*)/', $value[0]->reason_reject->term->name , $matches_term1, PREG_OFFSET_CAPTURE);
            if($matches_term1){
                $hasTerm1 = true;
            }
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
    if($hasTerm3){
        array_unshift($TermRemark, "<p>Quý khách vui lòng tham khảo Điều 3_Các quy định loại trừ trách nhiệm bảo hiểm của Quy tắc và điều khoản bảo hiểm Chăm sóc sức khỏe: “Dai-ichi Life Việt Nam sẽ không thanh toán quyền lợi điều trị nội trú và điều trị ngoại trú theo quy định tại Điều 2 của Quy tắc, Điều khoản sản phẩm bổ sung này nếu việc điều trị Bệnh tật/Thương tật của Người được bảo hiểm thuộc bất kỳ trường hợp hoặc sự việc nào sau đây”: </p>");
    }
    if($hasTerm2){
        array_unshift($TermRemark, "<p>Quý khách vui lòng tham khảo Điều 2_ Quyền lợi Bảo hiểm Chăm sóc sức khỏe: “Dai-ichi Life Việt Nam sẽ không thanh toán quyền lợi điều trị nội trú và điều trị ngoại trú theo quy định tại Điều 2 của Quy tắc, Điều khoản sản phẩm bổ sung này nếu việc điều trị Bệnh tật/Thương tật của Người được bảo hiểm thuộc bất kỳ trường hợp hoặc sự việc nào sau đây”:</p>");
    }
    if($hasTerm1){
        array_unshift($TermRemark, "<p>Quý khách vui lòng tham khảo Điều 1_ Các Định nghĩa của Quy tắc và Điều khoản bảo hiểm Chăm sóc sức khỏe:</p>");
    }
    return [ 'CSRRemark' => $CSRRemark , 'TermRemark' => sort($TermRemark)];
    
}

function note_pay($export_letter){
    $htm = '<p style = "font-size: 10px; padding: 0px ;margin: 0px">Note: : Claim số [[$claimNo]] tổng thanh toán bồi thường [[$apvAmt]] đồng.</p>';
    if(!empty($export_letter->data_cps) || $export_letter->data_cps != null){
        foreach ($export_letter->data_cps as $key => $value) {
            $tf_date =  Carbon\Carbon::parse($value['tf_date'])->format('d/m/Y');
            $tf_amt = formatPrice($value['tf_amt']);
            $htm .= "<p style='font-size: 10px; padding: 0px ;margin: 0px'>Payment lần {$value['tf_times']} ngày {$tf_date} thanh toán cho khách hàng {$tf_amt} đồng.</p>";
        }
    }
    return $htm;
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
