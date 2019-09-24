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

// SDK ABBYY CLOUD
function scanORC($filePath, $fileNameStore){
     // 1. Send image to Cloud OCR SDK using processImage call
        // 2.	Get response as xml
        // 3.	Read taskId from xml

        // To create an application and obtain a password,
        // register at https://cloud.ocrsdk.com/Account/Register
        // More info on getting your application id and password at
        // https://ocrsdk.com/documentation/faq/#faq3
        // Name of application you created
        $applicationId = 'pacific-cross';
        // Password should be sent to your e-mail after application was created
        $password = 'WHNcLgqhdjvtp4s9D3vmZDhf';
        $fileName = 'myfile.jpg';
        // URL of the processing service. Change to http://cloud-westus.ocrsdk.com
        // if you created your application in US location
        $serviceUrl = 'http://cloud-eu.ocrsdk.com';

        // Get path to file that we are going to recognize
        //$local_directory=dirname(__FILE__).'/images/';
        //$filePath = $local_directory.'/'.$fileName;
        //$filePath = Storage::disk('public')->path("formClaimSelect/$newFileName");
        
        if(!file_exists($filePath))
        {
            die('File '.$filePath.' not found.');
        }
        if(!is_readable($filePath) )
        {
            die('Access to file '.$filePath.' denied.');
        }
        
        // Recognizing with English language to rtf
        // You can use combination of languages like ?language=english,russian or
        // ?language=english,french,dutch
        // For details, see API reference for processImage method
        $url = $serviceUrl.'/processImage?language=english,vietnamese&exportFormat=xlsx';
        
        // Send HTTP POST request and ret xml response
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
        curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
        $post_array = array();
        if((version_compare(PHP_VERSION, '5.5') >= 0)) {
            $post_array["my_file"] = new \CURLFile($filePath, 'image/png', 'testpic');
        } else {
            $post_array["my_file"] = "@".$filePath;
        }
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_array); 
        $response = curl_exec($curlHandle);
        if($response == FALSE) {
            $errorText = curl_error($curlHandle);
            curl_close($curlHandle);
            die($errorText);
        }
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        // Parse xml response
        $xml = simplexml_load_string($response);
        if($httpCode != 200) {
            if(property_exists($xml, "message")) {
            die($xml->message);
            }
            die("unexpected response ".$response);
        }

        $arr = $xml->task[0]->attributes();
        $taskStatus = $arr["status"];
        if($taskStatus != "Queued") {
            die("Unexpected task status ".$taskStatus);
        }
        
        // Task id
        $taskid = $arr["id"];  
        
        // 4. Get task information in a loop until task processing finishes
        // 5. If response contains "Completed" staus - extract url with result
        // 6. Download recognition result (text) and display it

        $url = $serviceUrl.'/getTaskStatus';
        // Note: a logical error in more complex surrounding code can cause
        // a situation where the code below tries to prepare for getTaskStatus request
        // while not having a valid task id. Such request would fail anyway.
        // It's highly recommended that you have an explicit task id validity check
        // right before preparing a getTaskStatus request.
        if(empty($taskid) || (strpos($taskid, "00000000-0") !== false)) {
            die("Invalid task id used when preparing getTaskStatus request");
        }
        $qry_str = "?taskid=$taskid";

        // Check task status in a loop until it is finished

        // Note: it's recommended that your application waits
        // at least 2 seconds before making the first getTaskStatus request
        // and also between such requests for the same task.
        // Making requests more often will not improve your application performance.
        // Note: if your application queues several files and waits for them
        // it's recommended that you use listFinishedTasks instead (which is described
        // at https://ocrsdk.com/documentation/apireference/listFinishedTasks/).
        while(true)
        {
            sleep(5);
            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $url.$qry_str);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
            curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
            curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            curl_close($curlHandle);
        
            // parse xml
            $xml = simplexml_load_string($response);
            if($httpCode != 200) {
            if(property_exists($xml, "message")) {
                die($xml->message);
            }
            die("Unexpected response ".$response);
            }
            $arr = $xml->task[0]->attributes();
            $taskStatus = $arr["status"];
            if($taskStatus == "Queued" || $taskStatus == "InProgress") {
            // continue waiting
            continue;
            }
            if($taskStatus == "Completed") {
            // exit this loop and proceed to handling the result
            break;
            }
            if($taskStatus == "ProcessingFailed") {
            die("Task processing failed: ".$arr["error"]);
            }
            die("Unexpected task status ".$taskStatus);
        }

        // Result is ready. Download it

        $url = $arr["resultUrl"];   
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        // Warning! This is for easier out-of-the box usage of the sample only.
        // The URL to the result has https:// prefix, so SSL is required to
        // download from it. For whatever reason PHP runtime fails to perform
        // a request unless SSL certificate verification is off.
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curlHandle);
        curl_close($curlHandle);
        $dir_save = 'public/formClaimExport/';
        Storage::put($dir_save . $fileNameStore, $response);
        // Let user donwload rtf result
        // header('Content-type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment; filename="file.xlsx"');
        // echo $response;
}
