<?php

namespace App\Http\Controllers;
use App\HBS_CL_CLAIM;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class AjaxCommonController extends Controller
{
    //ajax load ID claim auto complate 
    public function dataAjaxHBSClaim(Request $request)
    {
        
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }

    // jax load info of claim
    public function loadInfoAjaxHBSClaim(Request $request)
    {  
        
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $datas = HBS_CL_CLAIM::findOrFail($search)->member;
            return response()->json($datas);
        }
        return response()->json($data);
    }
}
