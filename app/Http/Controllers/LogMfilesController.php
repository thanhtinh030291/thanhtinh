<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\LogMfile;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use DB;


class LogMfilesController extends Controller
{
    
    //use Authorizable;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_params = [
            'name' => $request->get('name'),
            // 'created_user' => $request->get('created_user'),
            // 'created_at' => $request->get('created_at'),
            // 'updated_user' => $request->get('updated_user'),
            // 'updated_at' => $request->get('updated_at'),
        ];
        $LogMfiles = LogMfile::select(DB::raw('DISTINCT(DATE(updated_at)) AS date'))->where('updated_at',"!=",NULL)->orderBy('updated_at', 'desc')->get();
        $admin_list = User::getListIncharge();
        //pagination result
        $limit_list = config('constants.limit_list');
        $limit = $request->get('limit');
        $per_page = !empty($limit) ? $limit : Arr::first($limit_list);
        $LogMfiles  = $LogMfiles->paginate($per_page);
        
        return view('LogMfilesManagement.index', compact('search_params', 'admin_list', 'limit', 'limit_list', 'LogMfiles' ));
    }


    public function show($datereportAdmin)
    {
        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $datereportAdmin);
        $LogMfiles = LogMfile::leftJoin('claim', 'claim.id', '=', 'claim_id')->whereDate('log_mfile.updated_at', $date->toDateString())->get();
        $admin_list = User::getListIncharge();
        return view('LogMfilesManagement.show', compact('LogMfiles','admin_list'));
    }

}
