<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\Product;
use App\Http\Requests\reasonInjectRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $Product = Product::findByParams($data['search_params'])->orderBy('id', 'desc');
        $data['admin_list'] = User::getListIncharge();
        //pagination result
        $data['limit_list'] = config('constants.limit_list');
        $data['limit'] = $request->get('limit');
        $per_page = !empty($data['limit']) ? $data['limit'] : array_first($data['limit_list']);
        $data['data']  = $Product->paginate($per_page);
        
        return view('productManagement.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productManagement.create');
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

        Product::create($data);
        $request->session()->flash('status', __('message.reason_inject_create_success')); 
        
        return redirect('/admin/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);
        $userCreated = $data->userCreated->name;
        $userUpdated = $data->userUpdated->name;
        return view('productManagement.detail', compact('data', 'userCreated', 'userUpdated'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return view('productManagement.edit', compact('data'));
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
        Product::updateOrCreate(['id' => $id], $data);

        $request->session()->flash('status', __('message.reason_inject_update_success')); 
        return redirect('/admin/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
        return redirect('/admin/product')->with('status', __('message.reason_inject_delete_success'));
    }
}
