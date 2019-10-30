<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\reasonInjectRequest;
use App\LetterTemplate;
use App\User;
use App\Term;
use Auth;
use Illuminate\Support\Arr;

class LetterTemplateController extends Controller
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
        $listData = LetterTemplate::findByParams($data['search_params'])->orderBy('id', 'desc');
        $data['admin_list'] = User::getListIncharge();
        //pagination result
        $data['limit_list'] = config('constants.limit_list');
        $data['limit'] = $request->get('limit');
        $per_page = !empty($data['limit']) ? $data['limit'] : Arr::first($data['limit_list']);
        $data['data']  = $listData->paginate($per_page);
        
        return view('letterTemplateManagement.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listTerm = Term::pluck('name','id');
        return view('letterTemplateManagement.create', compact('listTerm'));
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

        LetterTemplate::create($data);
        $request->session()->flash('status', __('message.reason_inject_create_success')); 
        
        return redirect('/admin/reason_reject');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LetterTemplate $letterTemplate)
    {
        $data = $letterTemplate;
        $userCreated = $data->userCreated->name;
        $userUpdated = $data->userUpdated->name;
        return view('letterTemplateManagement.detail', compact('data', 'userCreated', 'userUpdated'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LetterTemplate $letterTemplate)
    {
        $data = $letterTemplate;
        $listTerm = Term::pluck('name','id');
        return view('letterTemplateManagement.edit', compact('data', 'listTerm'));
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
        LetterTemplate::updateOrCreate(['id' => $id], $data);

        $request->session()->flash('status', __('message.reason_inject_update_success')); 
        return redirect('/admin/reason_reject');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = LetterTemplate::findOrFail($id);
        $data->delete();
        return redirect('/admin/reason_reject')->with('status', __('message.reason_inject_delete_success'));
    }
}