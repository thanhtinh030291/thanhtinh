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
