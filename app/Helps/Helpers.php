<?php
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

function formatDate($string, $format = 'Y/m/d') {
    return date($format, strtotime($string));
}

// Return code 
function getCode($prefix = null , $id = null){
    (int)$range_code = config('constants.rangeCode');
    return $prefix . str_pad($id, $range_code, "0", STR_PAD_LEFT);
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

/**
 * Get config of element with key is code value is name display
 * 
 * @param string $key    [string link to element]
 * @param string $locale [locale value]
 * 
 * @return array [array empty if not have]
 */
function configCode2Name($key = '', $locale = '')
{
    $setting = config($key);
    $code = data_get($setting, 'code', []);
    $name = _getNameByLocale(data_get($setting, 'name', []), $locale);

    if (empty($code) || empty($name) || count($code) != count($name)) {
        return [];
    }

    $keys   = array_values($code);
    $values = array_values($name);
    $result = array_combine($keys, $values);

    return $result;
}


function _getNameByLocale($names, $locale = '')
{
    if (!empty($locale)) {
        $names = data_get($names, $locale, []);
    } else {
        $locale_default = localeNow();
        $names = data_get($names, $locale_default, $names);
    }
    return $names;
}

/**
 * Get key of $code in link
 * Require: have "code" element on link config
 *
 * @param string $link [Link go to config]
 * @param mixed  $code [code need to find key corresponding|string|int]
 *
 * @return string [key of element config]
 */
function getKeyOfCode($link, $code)
{
    $code_list = config($link.'.code');
    if (empty($code_list) || !is_array($code_list)) {
        return null;
    }
    return array_search($code, $code_list);
}

/**
 * Use code for find key => use key for find name display
 * Config from $link must have at least 2 element is 'code' & 'name'
 * NOTE: 
 *    user must identify that config link have locale or not
 *    Unless will be try to get name from default locale
 * Require: have "code" & "name" element on link config
 *
 * @param string $link   [Link go to config]
 * @param mixed  $code   [code need to find name corresponding type:string|int]
 * @param string $locale [string locale ex: ja, en, vi, ...]
 *
 * @return string [name display of code in link]
 */
function getNameByCode($link, $code, $locale = '')
{
    $setting = config($link);
    $code_list = data_get($setting, 'code');
    if (empty($code_list) || !is_array($code_list)) {
        return null;
    }
    $key = array_search($code, $code_list);
    $name_list = _getNameByLocale(data_get($setting, 'name', []), $locale);

    return data_get($name_list, $key);
}

/**
 * Use code for find key => use key for find name display
 * NOTE: 
 *    user must identify that config link have locale or not
 *    Unless will be try to get name from default locale
 * Require: have "code" & "name" element on link config
 *
 * @param string $link   [Link go to config]
 * @param array  $codes  [code need to find name corresponding type:string|int]
 * @param string $locale [string locale ex: ja, en, vi, ...]
 *
 * @return array [name display of code in link]
 */
function getNamesByCodes($link, $codes, $locale = '')
{
    if (!is_array($codes) || empty($codes)) {
        return [];
    }

    $setting   = config($link);
    $code_list = data_get($setting, 'code');
    if (empty($code_list) || !is_array($code_list)) {
        return null;
    }

    //code => key
    $keys = [];
    foreach ($codes as $code) {
        $keys[] = array_search($code, $code_list);
    }

    //search name display by key above
    $name_list = _getNameByLocale(data_get($setting, 'name', []), $locale);
    $names = [];
    foreach ($keys as $no => $key) {
        $names[] = data_get($name_list, $key);
    }

    //combine for array code => name display
    $result = array_combine($codes, $names);

    return $result;
}

/**
 * Generate day list can have of month
 * 
 * @param string $char_after_day_no [character end of day number]
 * 
 * @return array
 */
function genDayList($char_after_day_no = '') 
{
    $result = [];
    $day_of_month = 31;
    for ($i=1; $i<=$day_of_month; $i++) {
        $result[$i] = $i . $char_after_day_no;
    }
    return $result;
}

/**
 * Generate month list can have of year
 * 
 * @param string $char_after_month [character end of day number]
 * 
 * @return array
 */
function genMonthList($char_after_month = '')
{
    $result = [];
    $month_of_year = 12;
    for ($i=1; $i<=$month_of_year; $i++) {
        $result[$i] = $i . $char_after_month;
    }
    return $result;
}

/**
 * Generate year list
 * 
 * @param numeric $from            [year begin of list]
 * @param numeric $to              [year end of list]
 * @param string  $char_after_year [string after year display]
 * 
 * @return array
 */
function genYearList($from = null, $to = null, $char_after_year = '')
{
    if (is_null($from)) {
        $from = config('constants.default_year_begin');
    }
    if (is_null($to)) {
        $to = date("Y") + config('constants.disp_year_after_now');
    }
    if (!is_numeric($from) || !is_numeric($to)) {
        return [];
    }
    
    $result = [];
    for ($i = $from; $i <= $to; $i++) {
        $result[$i] = $i . $char_after_year;
    }
    return $result;
}

/**
 * Get locale of app is running
 *
 * @return string [locale ja, en, ...]
 */
function localeNow()
{
    return app()->getLocale();
}


/**
 * Get id user is login present
 *
 * @return string
 */
function getLoginId()
{
    return data_get(auth()->user(), 'id');
}

/**
 * General perpage
 *
 * @return int
 */
function generalPerPage()
{
    return config('constants.paginator.itemPerPage');
}

function checkPurchaseByStripe($amount,$stripeToken)
    {
        try {
            $charge = \Stripe\Charge::create([
                'currency' => 'JPY',
                'amount' => $amount,
                'source' => $stripeToken,
                'description' => 'charge',
            ]);
            if ($charge->status == 'succeeded') {
                return ['status' => 'success', 'data' => $charge];
            }else{
                return ['status' => 'error', 'message' => __('web.charge_error')]; 
            }

        }catch(Stripe\Error\Card $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            return ['status' => 'error', 'message' => $err['message']];
        }catch (\Stripe\Error\InvalidRequest $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            return ['status' => 'error', 'message' => $err['message']];
        } catch (\Stripe\Error\Authentication $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            return ['status' => 'error', 'message' => $err['message']];
        } catch (\Stripe\Error\ApiConnection $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            return ['status' => 'error', 'message' => $err['message']];
        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            return ['status' => 'error', 'message' => $err['message']];
        } catch (Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            return ['status' => 'error', 'message' => $err['message']];
        }
    }
