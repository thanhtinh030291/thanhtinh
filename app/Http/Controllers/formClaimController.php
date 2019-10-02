<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Config;
use Storage;
use File;
use App\Claim;
use DB;
use Auth;
use App\Http\Requests\formClaimRequest;
class formClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemPerPage = Config::get('constants.paginator.itemPerPage');
        $id_claim =  $request->id_claim;
        $finder = [
            'id_claim' => $request->id_claim,
        ];
        $datas = Claim::where('id_claim', 'like', '%' . $finder['id_claim'] . '%')->paginate($itemPerPage);
        return view('formClaimManagement.index', compact('finder', 'datas'));
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
    public function store(formClaimRequest $request)
    {
        dd($request);
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
        $arrFileTemporary = [];
        foreach ($images as $i => $image) {
            if(in_array($i, $page)) {
                $newFileName = $i ."-". $originalName . '.tif';
                $arrFileTemporary[] = $newFileName;
                $image->setImageFormat("tif");
                if(!File::exists($dirUploadSelect)) {
                    File::makeDirectory($dirUploadSelect, 0777, true, true);
                }
                $image->writeImage($dirUploadSelect . $newFileName);
            }
        }
        
        // Merger File
        $imagenew = new \Imagick();
        
        foreach ($arrFileTemporary as $key => $value) {
        $imagenew->addImage(new \Imagick($dirUploadSelect . $value));
        }
        $mergeFileName = "Merge-". $originalName . '.tif';
        $imagenew->resetIterator();
        $combined = $imagenew->appendImages(true);
        $combined->setImageFormat("tif");
        $combined->writeImage($dirUploadSelect . $mergeFileName);

        // detele Temporary file
        $publicUploadSelect = Config::get('constants.formClaimSelect');
        foreach ($arrFileTemporary as $key => $value) {
            Storage::delete($publicUploadSelect . $value);
        }

        $fileUpload = $dirUploadSelect . $mergeFileName;
        $fileNameExport =  $originalName . '.xlsx';
        
        $dataNew += [
            'created_user' =>  $userId,
            'updated_user' =>  $userId,
            'url_file'  =>  $imageName,
            'url_file_split' => $mergeFileName,
            'url_file_export' => $fileNameExport,
        ];
        try {
            DB::beginTransaction();
            if(Claim::create($dataNew)){
                $file->storeAs($dirUpload, $imageName);
                scanORC($fileUpload  , $fileNameExport);
            };
            DB::commit();
            $request->session()->flash('status', __('message.add_claim'));
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
        
        $data = Claim::findOrFail($id);
        $dirStorage = Config::get('constants.formClaimStorage');
        $dataImage =  $dirStorage . $data->url_file ;

        $dirExportStorage = Config::get('constants.formClaimExportStorage');
        $dataExport = $dirExportStorage . $data->url_file_export ;
        return view('formClaimManagement.show', compact(['data', 'dataImage', 'dataExport']));
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
        $data = Claim::findOrFail($id);
        $dirUpload = Config::get('constants.formClaimUpload');
        Storage::delete($dirUpload . $data->url_file);

        $dirUploadSelect = Config::get('constants.formClaimSelect');
        Storage::delete($dirUploadSelect . $data->url_file_split);

        $dirUploadExport = Config::get('constants.formClaimExport');
        Storage::delete($dirUploadExport . $data->url_file_export);
        $data->delete();

        return redirect('/admin/form_claim')->with('status', __('message.delete_claim'));
    }
}
