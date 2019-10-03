<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Config;
use Storage;
use File;
use App\Claim;
use App\ItemOfClaim;
use App\User;
use DB;
use Auth;
use App\ListReasonInject;
use App\Http\Requests\formClaimRequest;
use Illuminate\Support\Facades\Log;
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
        $id_claim =  $request->code_claim;
        $admin_list = User::getListIncharge();
        $finder = [
            'code_claim' => $request->code_claim,
        ];
        $datas = Claim::where('code_claim', 'like', '%' . $finder['code_claim'] . '%')->paginate($itemPerPage);
        return view('formClaimManagement.index', compact('finder', 'datas', 'admin_list'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listReasonInject = ListReasonInject::pluck('name', 'id');
        return view('formClaimManagement.create', compact('listReasonInject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(formClaimRequest $request)
    {
        $file = $request->file;
        $dataNew = $request->except(['file']);
        $userId = Auth::User()->id;
        $dirUpload = Config::get('constants.formClaimUpload');
        
        // store file
        $imageName = Claim::storeFile($file, $dirUpload);
        $dataNew += [
            'created_user' =>  $userId,
            'updated_user' =>  $userId,
            'url_file'  =>  $imageName,
        ];

        // get value item
        $fieldSelect =  array_flip(array_diff($request->_column, ['none']));
        $rowData = array_values($request->_row);
        $rowCheck = $request->_checkbox;
        $dataItems = [];
        foreach ($rowData as $key => $value) {
            $dataItems[] = new ItemOfClaim([
                'content' => $value[$fieldSelect['content']],
                'unit_price' => $value[$fieldSelect['unit_price']],
                'quantity' => $value[$fieldSelect['quantity']],
                'amount' => $value[$fieldSelect['amount']],
                'status' => $rowCheck[$key],
                'created_user' => $userId,
                'updated_user' => $userId,
            ]);
        }

        try {
            DB::beginTransaction();
            $claim = Claim::create($dataNew);
            $claim->item_of_claim()->saveMany($dataItems);

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
        return redirect('/admin/form_claim')->with('status', __('message.delete_claim'));
    }
}
