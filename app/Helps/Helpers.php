<?php
use Illuminate\Support\Str;
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
            $info_reciever = 'Số tài khoản: '.$HBS_CL_CLAIM->member->cl_pay_acct_no.' Tại ngân hàng '.$HBS_CL_CLAIM->member->bank_name.
            ', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city;
            $banking = $HBS_CL_CLAIM->member->bank_name.', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city;
            $notify = "Quý khách vui lòng kiểm tra tài khoản nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán.";
            break;
        case 'CL_PAY_METHOD_CA':
            $name_reciever = $HBS_CL_CLAIM->member->cash_beneficiary_name;
            $info_reciever = "CMND/Căn cước công dân: " .$HBS_CL_CLAIM->member->cash_id_passport_no.', ngày cấp:  
            '.$HBS_CL_CLAIM->member->cash_id_passport_date_of_issue.', nơi cấp: '. $HBS_CL_CLAIM->member->cash_id_passport_date_of_issue;
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
    $payMethod =    '<table style="height: 80px; width: 712px; border: 1px solid black; border-collapse: collapse;">
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
                    $IOPDiag[] = "- Chẩn đoán: " . $value->RT_DIAGNOSIS->diag_desc_vn ." <br>
                                Ngày khám : $from_date tại ". $value->prov_name . ".";

                    break;
                case 'BENEFIT_TYPE_IP':
                    $from_date = Carbon\Carbon::parse($value->incur_date_from)->format('d/m/Y');
                    $to_date = Carbon\Carbon::parse($value->incur_date_to)->format('d/m/Y');
                    $IOPDiag[] = "- Chẩn đoán: ". $value->RT_DIAGNOSIS->diag_desc_vn ." <br>
                            Ngày nhập viện : $from_date , ngày xuất viện :  $to_date tại ". $value->prov_name. ".";
                    break;
                default:

                    break;
            }
        }
    $IOPDiag = implode('<br>', $IOPDiag);
    return $IOPDiag;
}

// print CRRMArk AND TERM

function CSRRemark_TermRemark($claim){
    $CSRRemark = [];
    $TermRemark = [];
    
    $arrKeyRep = [ '[##nameItem##]' , '[##amountItem##]' , '[##Date##]' , '[##Text##]' ];
    $itemOfClaim = $claim->item_of_claim->groupBy('reason_reject_id');
    $templateHaveMeger = [];
    foreach ($itemOfClaim as $key => $value) {
        $template = $value[0]->reason_reject->template;
        $TermRemark[] = $value[0]->reason_reject->term->fullTextTerm;
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
                        $valueMatche = str_replace($value2, '$parameter', $valueMatche);
                    };
                    $arrMatche[$keyMatche][] =  Str::replaceArray('$parameter', $item->parameters, $valueMatche);
                }
            }
            // array to string 
            $arr_str = [];
            foreach ($arrMatche as $key => $value) {
                $arr_str[] = preg_replace('/\[Begin\]|\[End\]/', ' ', implode("; ", $value));
            }

            $CSRRemark[] = Str::replaceArray('$arrParameter', $arr_str, $template_new);
        }
        return [ 'CSRRemark' => $CSRRemark , 'TermRemark' => $TermRemark];
    }

    
}

