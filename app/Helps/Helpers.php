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
                ->to($user_send->email, $user_send->company_name)
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
    $parts[0] = preg_replace($pattern, ",", $parts[0]);
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
            $name_reciever = $HBS_CL_CLAIM->member->bank_name;
            $info_reciever = 'Số tài khoản: '.$HBS_CL_CLAIM->member->cl_pay_acct_no.' Tại ngân hàng '.$HBS_CL_CLAIM->member->bank_name.
            ', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city;
            $banking = $HBS_CL_CLAIM->member->bank_name.', '.$HBS_CL_CLAIM->member->cl_pay_bank_branch.', '. $HBS_CL_CLAIM->member->cl_pay_bank_city;
            $notify = "Quý khách vui lòng kiểm tra tài khoản nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán.";
        case 'CL_PAY_METHOD_CA':
            $name_reciever = $HBS_CL_CLAIM->member->cash_beneficiary_name;
            $info_reciever = "CMND/Căn cước công dân: " .$HBS_CL_CLAIM->member->cash_id_passport_no.', ngày cấp:  
            '.$HBS_CL_CLAIM->member->cash_id_passport_date_of_issue.', nơi cấp: '. $HBS_CL_CLAIM->member->cash_id_passport_date_of_issue;
            $banking = $HBS_CL_CLAIM->member->cash_bank_name.', '.$HBS_CL_CLAIM->member->cash_bank_branch.', '.$HBS_CL_CLAIM->member->cash_bank_city ;
            $notify = "Quý khách vui lòng mang theo CMND đến Ngân hàng nhận tiền sau 3-5 ngày làm việc kể từ ngày chấp nhận thanh toán";
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
                                <p>Tên người thụ hưởng: '.$info_reciever.'</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black" colspan="2">
                                <p>Tên và địa chỉ Ngân hàng:</p>
                                <p>'.$banking.'</p>
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
                    $from_date = Carbon\Carbon::parse($value->incur_date_from)->toDateString();
                    $to_date = Carbon\Carbon::parse($value->incur_date_to)->toDateString();
                    $IOPDiag[] = "- Chẩn đoán: " . $value->RT_DIAGNOSIS->diag_desc_vn ." <br>
                                Ngày khám : $from_date tại ". $value->prov_name . ".";

                    break;
                case 'BENEFIT_TYPE_IP':
                    $from_date = Carbon\Carbon::parse($value->incur_date_from)->toDateString();
                    $to_date = Carbon\Carbon::parse($value->incur_date_to)->toDateString();
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


    function tableInfoPayment($HBS_CL_CLAIM){
      
        $html = '<table style=" border: 1px solid black; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black">Quyền lợi</th>
                            <th style="border: 1px solid black">Giới hạn thanh toán</th>
                            <th style="border: 1px solid black">Số tiền yêu cầu bồi thường (Căn cứ trên chứng từ hợp lệ) </th>
                            <th style="border: 1px solid black">Số tiền thanh toán</th>
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
                    $IP[] = $valueCL_LINE;
                    break;
            }
        }
        $html .= '<tbody>';
            // nội trú
        foreach ($IP as $key => $value) {

            $content =config('constants.content_ip.'.$value->PD_BEN_HEAD->ben_head);
            $range_pay = "";
            $limit = $this->getlimitIP($value);
            switch ($value->PD_BEN_HEAD->ben_head) {
                case 'ANES':
                case 'OPR':
                case 'SUR':
                    $range_pay = " Tối đa ".$limit['amt']." cho mỗi Bệnh tật/Thương tật, mỗi cuộc phẫu thuật";
                    break;
                case 'HSP':
                case 'HVIS':
                case 'IMIS':
                case 'PORX':
                case 'POSH':
                case 'LAMB':
                    $range_pay = " Tối đa ".$limit['amt']." cho mỗi Bệnh tật/Thương tật, mỗi năm";
                    break;
                case 'RB':
                case 'EXTB':
                case 'ICU':
                case 'HNUR':
                    $range_pay = " Tối đa ".$limit['amt']." cho mỗi Bệnh tật/Thương tật, mỗi năm";
                    break;
                default:
                    $range_pay = " Tối đa ".$limit['amt'];
                    break;
            }
            $html .=    '<tr>
                            <td style="border: 1px solid black; font-weight:bold;"><ins>Nội Trú</ins></td>
                            <td style="border: 1px solid black">Mỗi bệnh /thương tật <br> '.$value->RT_DIAGNOSIS->diag_desc_vn.'</td>
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black"></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black">'.$content.'</td>
                            <td style="border: 1px solid black">'.$range_pay.'</td>
                            <td style="border: 1px solid black">'.$value->pres_amt.'</td>
                            <td style="border: 1px solid black">'.$value->app_amt.'</td>
                        </tr>
                        ';
        }
        // ngoại trú
        foreach ($OP as $key => $value) {
            $content =config('constants.content_op.'.$value->PD_BEN_HEAD->ben_head);
            $limit = $this->getlimitOP($value);
            //dd($limit);
            $content_limit = "";
            switch ($value->PD_BEN_HEAD->ben_head) {
                case 'OVRX':
                case 'OV':
                case 'RX':
                    $content_limit = "Từ trên ".$limit['amt_from']." đến tối đa ". $limit['amt_to'] ." mỗi lần thăm khám";
                    break;
                
                default:
                    $content_limit = "Tối đa ".$limit['amt_from']." mỗi năm";
                    break;
            }
            if($key == 0){
                
                $html .= '<tr>
                            <td style="border: 1px solid black; font-weight:bold;"><ins>Ngoại Trú</ins></td>
                            <td style="border: 1px solid black">Tối đa  '.$limit['amt_yr'].' mỗi năm</td>
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black"></td>
                        </tr>';
            }
            $html .=    '<tr>
                            <td style="border: 1px solid black">'.$value->RT_DIAGNOSIS->diag_desc_vn.'<br>'.$content.'</td>
                            <td style="border: 1px solid black">'.$content_limit.'</td>
                            <td style="border: 1px solid black">'.$value->pres_amt.'</td>
                            <td style="border: 1px solid black">'.$value->app_amt.'</td>
                        </tr>';
        }

        // rang
        foreach ($DT as $key => $value) {
            $limit = $this->getlimitDT($value);
            if($key == 0){
                
                $html .= '<tr>
                            <td style="border: 1px solid black; font-weight:bold;"><ins>Răng</ins></td>
                            <td style="border: 1px solid black">Tối đa  '.$limit['amt_yr'].' mỗi năm</td>
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black"></td>
                        </tr>';
            }
            $html .=    '<tr>
                            <td style="border: 1px solid black">Chi phí điều trị nha khoa '.$value->RT_DIAGNOSIS->diag_desc_vn.'</td>
                            <td style="border: 1px solid black">Từ trên '.$limit['amt'].' mỗi lần thăm khám</td>
                            <td style="border: 1px solid black">'.$value->pres_amt.'</td>
                            <td style="border: 1px solid black">'.$value->app_amt.'</td>
                        </tr>';
        }


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

