<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GoogleCloudVision\GoogleCloudVision;
use GoogleCloudVision\Request\AnnotateImageRequest;
use Exception;
use Config;

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
        $googleCloudKey =  Config::get('services.google.google_cloud_key');
        try {
            if ($request->file('image')) {
                $image = base64_encode(file_get_contents($request->file('image')));
                $request = new AnnotateImageRequest();
                $request->setImage($image);
                $request->setFeature("TEXT_DETECTION");
                $gcvRequest = new GoogleCloudVision([$request], $googleCloudKey);
                $response = $gcvRequest->annotate();
                echo json_encode(["description" => $response->responses[0]->textAnnotations[0]->description]);
            }
        } catch (Exception $e) {
            echo json_encode(["code" => $e->getCode(), "errors" => $e->getMessage()]);
        }
    }
}
