<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GoogleCloudVision\GoogleCloudVision;
use GoogleCloudVision\Request\AnnotateImageRequest;
use Exception;
use Config;
use \CURLFile;
use Storage;
use File;
class formClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('formClaimManagement.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formClaimManagement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * annotate Image
     *
     * @param Request $request
     */
    public function annotateImage(Request $request)
    {
        $file = $request->file;
        $page = $request->page;
        $filename = $file->getClientOriginalName();
        $dirUpload = Config::get('constants.formClaimUpload');
        $dirStorage = Config::get('constants.formClaimStorage');
        $dirUploadSelect =  Config::get('constants.formClaimSelect');
        $file->storeAs($dirUpload, $filename);
        $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
        $path_dir = Storage::disk('public')->path("formClaim/");
        $images = new \Imagick($path_dir.$filename);
        $newFileName = $page . explode('.', $filename)[0] . '.png'; 
        foreach ($images as $i => $image) {
            if ($i == $page) {
                $image->setImageFormat("png");
                $upload_path = Storage::disk('public')->path("formClaimSelect/");
                if(!File::exists($upload_path)) {
                    // path does not exist
                    File::makeDirectory($upload_path, 0777, true, true);
                }
                $image->writeImage($upload_path . $newFileName);
            }
        }

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
        $filePath = Storage::disk('public')->path("formClaimSelect/$newFileName");
        
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
            $post_array["my_file"] = new CURLFile($filePath);
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
        Storage::put('file.xlsx', $response);
        dd($response);
        // Let user donwload rtf result
        // header('Content-type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment; filename="file.xlsx"');
        // echo $response;
    }
}
