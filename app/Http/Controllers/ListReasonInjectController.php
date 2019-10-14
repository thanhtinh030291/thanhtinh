<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\reasonInjectRequest;
use App\ListReasonInject;
use App\User;
use Auth;

class ListReasonInjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['search_params'] = [
            'name' => $request->get('name'),
            // 'created_user' => $request->get('created_user'),
            // 'created_at' => $request->get('created_at'),
            // 'updated_user' => $request->get('updated_user'),
            // 'updated_at' => $request->get('updated_at'),
        ];
        $listReasonInject = ListReasonInject::findByParams($data['search_params'])->orderBy('id', 'desc');
        $data['admin_list'] = User::getListIncharge();
        //pagination result
        $data['limit_list'] = config('constants.limit_list');
        $data['limit'] = $request->get('limit');
        $per_page = !empty($data['limit']) ? $data['limit'] : array_first($data['limit_list']);
        $data['listReasonInject']  = $listReasonInject->paginate($per_page);
        
        return view('listReasonInjectManagement.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('listReasonInjectManagement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(reasonInjectRequest $request)
    {
        $userId = Auth::User()->id;
        $data = $request->except([]);
        $data['created_user'] = $userId;
        $data['updated_user'] = $userId;

        ListReasonInject::create($data);
        $request->session()->flash('status', __('message.reason_inject_create_success')); 
        
        return redirect('/admin/list_reason_inject');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ListReasonInject::findOrFail($id);
        $userCreated = $data->userCreated->name;
        $userUpdated = $data->userUpdated->name;
        return view('listReasonInjectManagement.detail', compact('data', 'userCreated', 'userUpdated'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ListReasonInject::findOrFail($id);
        return view('listReasonInjectManagement.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(reasonInjectRequest $request, $id)
    {
        $data = $request->except([]);
        $userId = Auth::User()->id;
        $data['updated_user'] = $userId;
        ListReasonInject::updateOrCreate(['id' => $id], $data);

        $request->session()->flash('status', __('message.reason_inject_update_success')); 
        return redirect('/admin/list_reason_inject');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ListReasonInject::findOrFail($id);
        $data->delete();
        return redirect('/admin/list_reason_inject')->with('status', __('message.reason_inject_delete_success'));
    }
}
