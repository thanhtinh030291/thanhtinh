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
        $datas = Claim::where('code_claim', 'like', '%' . $finder['code_claim'] . '%')->orderBy('id', 'desc')->paginate($itemPerPage);
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
        if($file){
            $imageName = Claim::storeFile($file, $dirUpload);
            $dataNew += ['url_file'  =>  $imageName];
        }
        $dataNew += [
            'created_user' =>  $userId,
            'updated_user' =>  $userId,
        ];

        $dataItems = [];
        // get value item orc

        if( $request->_row){
            $fieldSelect =  array_flip(array_filter($request->_column));
            $rowData = $request->_row;
            array_shift_assoc($rowData);
            $rowCheck = $request->_checkbox;
            $reason = $request->_reason;
            foreach ($rowData as $key => $value) {
                $dataItems[] = new ItemOfClaim([
                    'content' => data_get($value, $fieldSelect['content'], ""),
                    'amount' => data_get($value, $fieldSelect['amount'], 0),
                    'status' =>data_get($rowCheck, $key, 0) ,
                    'list_reason_inject_id' => data_get($reason, $key),
                    'created_user' => $userId,
                    'updated_user' => $userId,
                ]);
            }
        }

        // GET value add item
        if($request->_content){
            $rowContent = $request->_content;
            $rowAmount = $request->_amount;
            $reasonInject = $request->_reasonInject;
            foreach ($rowContent as $key => $value) {
                $dataItems[] = new ItemOfClaim([
                    'content' => $value,
                    'amount' => data_get($rowAmount, $key, 0),
                    'status' => 0,
                    'list_reason_inject_id' => data_get($reasonInject, $key),
                    'created_user' => $userId,
                    'updated_user' => $userId,
                ]);
            }
        }
        

        //
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
        $data = Claim::findOrFail($id);
        $listReasonInject = ListReasonInject::pluck('name', 'id');
        $dirStorage = Config::get('constants.formClaimStorage');
        $dataImage = [];
        $previewConfig = [];
        if($data->url_file){
            $dataImage[] = "<img class='kv-preview-data file-preview-image' src='" . asset('images/csv.png') . "'>";
            $previewConfig[]['caption'] = $data->url_file;
            $previewConfig[]['width'] = "120px";
            $previewConfig[]['url'] = "/admin/tours/removeImage";
            $previewConfig[]['key'] = $data->url_file;
        }
        //dd($data->item_of_claim->pluck('content'));
        return view('formClaimManagement.edit', compact(['data', 'dataImage', 'previewConfig', 'listReasonInject']));
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
        $data = Claim::findOrFail($id);
        $userId = Auth::User()->id;
        $dataUpdate = $request;
        $dataUpdate = $dataUpdate->except([]);
        try {
            DB::beginTransaction();
            if (Claim::updateOrCreate(['id' => $id], $dataUpdate)) {
                if ($request->_content != null) {
                    $dataItemNew = [];
                    foreach ($request->_idItem as $key => $value) {
                        if ($value == null) {
                            $dataItemNew[] = [
                                'claim_id' => $id,
                                'list_reason_inject_id' => $request->_reasonInject[$key],
                                'content' => $request->_content[$key],
                                'amount' => $request->_amount[$key],
                                'created_user' => $userId,
                                'updated_user' => $userId,
                            ];
                        } else {
                            $keynew = $key - 1;
                            $data->item_of_claim[$keynew]->updated_user = $userId;
                            $data->item_of_claim[$keynew]->list_reason_inject_id = $request->_reasonInject[$key];
                            $data->item_of_claim[$keynew]->content = $request->_content[$key];
                            $data->item_of_claim[$keynew]->amount = $request->_amount[$key];
                        }
                    }
                     //delete
                    $dataDel = ItemOfClaim::whereNotIn('id', array_filter($request->_idItem))->where('claim_id', $id);
                    $dataDel->delete();
                    // update
                    $data->push();
                    // new season price
                    $data->item_of_claim()->createMany($dataItemNew);
                } else {
                    $dataDel = ItemOfClaim::where('claim_id', $id);
                    $dataDel->delete();
                } // update and create new tour_set
                DB::commit();
                $request->session()->flash('status', __('message.update_transport'));
            }
            return redirect('/admin/form_claim');
        } catch (Exception $e) {
            Log::error(generateLogMsg($e));
            DB::rollback();
            $request->session()->flash(
                'errorStatus', 
                __('message.update_fail')
            );
            return redirect('/admin/form_claim/'.$id.'/edit')->withInput();
        }
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

    public function searchFullText2(Request $request)
    {
        $res = ['status' => 'error'];
        if ($request->search != '') {
            $data = Product::FullTextSearch('name', $request->search)->pluck('name')->toArray();
            if(isset($data)){
                $res = ['status' => 'success', 'data' => $data];
            }
        }
        return response()->json($res, 200);
    }
}
