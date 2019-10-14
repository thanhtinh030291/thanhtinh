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
use App\Product;
use DB;
use Auth;
use App\ListReasonInject;
use App\Http\Requests\formClaimRequest;
use Illuminate\Support\Facades\Log;
use SimilarText\Finder;
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
        $dataNew = $request->except(['file','file2']);
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
        $fieldSelect =  array_flip(array_filter($request->_column));
        $rowData = $request->_row;
        array_shift_assoc($rowData);
        $rowCheck = $request->_checkbox;
        $reason = $request->_reason;
        $dataItems = [];
        foreach ($rowData as $key => $value) {
            $dataItems[] = new ItemOfClaim([
                'content' => data_get($value, $fieldSelect['content'], ""),
                'unit_price' =>  data_get($value, $fieldSelect['unit_price'], 0) ,
                'quantity' => data_get($value, $fieldSelect['quantity'], 0),
                'amount' => data_get($value, $fieldSelect['amount'], 0),
                'status' =>data_get($rowCheck, $key, 0) ,
                'list_reason_inject_id' => data_get($reason, $key),
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
        $admin_list = User::getListIncharge();
        $data = Claim::findOrFail($id);
        $dirStorage = Config::get('constants.formClaimStorage');
        $dataImage =  $dirStorage . $data->url_file ;
        $listReasonInject = ListReasonInject::pluck('name', 'id');
        $items = $data->item_of_claim;


        return view('formClaimManagement.show', compact(['data', 'dataImage', 'items', 'admin_list', 'listReasonInject']));
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

    public function searchFullText(Request $request)
    {
            $res = ['status' => 'error'];
        if ($request->search != '') {
            $list = Product::pluck('name');
            $finder = new Finder($request->search, $list);
            $nameFirst = $finder->first();
            if(isset($nameFirst)){
                similar_text($request->search , $nameFirst, $percent);
                if($percent >= Config::get('constants.percentSelect')){
                    $res = ['status' => 'success', 'data' => ['name' => $nameFirst , 'percent' => round($percent, 0) ]];
                }
            }
        }
        return response()->json($res, 200);
    }
}
