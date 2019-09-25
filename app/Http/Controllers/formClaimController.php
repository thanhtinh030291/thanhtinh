<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GoogleCloudVision\GoogleCloudVision;
use GoogleCloudVision\Request\AnnotateImageRequest;
use Exception;
use Config;
use Storage;
use File;
use App\medicalExpenseReport;
use DB;
use Auth;
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
        $file = $request->file;
        $page = $request->_page;
        $dataNew = $request->except(['file']);
        $userId = Auth::User()->id;
        $filename = $file->getClientOriginalName();
        $dirUpload = Config::get('constants.formClaimUpload');
        $dirUploadSelect = storage_path('app/public/formClaimSelect/');
        // store file
        $originalName = time() . md5($filename);
        $imageName = $originalName . '.' . $file->getClientOriginalExtension();
        $file->storeAs($dirUpload, $imageName);

        $path_dir = storage_path('app/public/formClaim/');
        $images = new \Imagick($path_dir.$imageName);
        // Temporary file
        foreach ($images as $i => $image) {
            if(in_array($i, $page)) {
                $newFileName = $i ."-". $originalName . '.png';
                $image->setImageFormat("png");
                if(!File::exists($dirUploadSelect)) {
                    File::makeDirectory($dirUploadSelect, 0777, true, true);
                }
                $image->writeImage($dirUploadSelect . $newFileName);
            }
        }
        // Merger File
        $imagenew = new \Imagick();
        $imagenew->setImageFormat("tif");
        foreach ($page as $key => $value) {
            $fileUpload = $dirUploadSelect . $value ."-". $originalName . '.png';
            $imagenew->addImage(new \Imagick($fileUpload));
        }
        $imagenew-> 
        foreach ($page as $key => $value) {
            $fileUpload = $dirUploadSelect . $value ."-". $originalName . '.png';
            $fileNameExport = $value ."-". $originalName . '.xlsx';
            $dataNew['url_file_split'][] = $fileNameExport;
            scanORC($fileUpload  , $fileNameExport);
        }

        $dataNew += [
            'created_user' =>  $userId,
            'updated_user' =>  $userId,
            'url_file'  =>  $imageName,
        ];
       
        try {
            DB::beginTransaction();
            if(Tours::create($dataNew)){
                $file->storeAs($dirUpload, $imageName);
                
            };
            DB::commit();
            $request->session()->flash('status', __('message.add_tour'));
            return redirect('/admin/form_claim');
        } catch (Exception $e) {
            Log::error(generateLogMsg($e));
            DB::rollback();
            $request->session()->flash('errorStatus', __('message.update_fail'));
            return redirect('/admin/form_claim/create')->withInput();
        }
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

   
}
