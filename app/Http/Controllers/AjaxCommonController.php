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

    //ajax load ID claim auto complate HAVE benhead is RB
    public function dataAjaxHBSClaimRB(Request $request)
    {
        
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $conditionBenHead = function($q) {
                $q->where('BEN_HEAD', 'RB');
            };
            $condition = function($q) use ($conditionBenHead){
                $q->whereHas('PD_BEN_HEAD', $conditionBenHead);
            };
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->whereHas("HBS_CL_LINE", $condition)
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }
    // jax load info of claim RB
    public function loadInfoAjaxHBSClaimRB(Request $request)
    {  
        
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $datas = HBS_CL_CLAIM::findOrFail($search)->member;
            
            $conditionBenHead = function($q) {
                $q->where('BEN_HEAD', 'RB');
            };
            $condition = function($q) use ($conditionBenHead){
                $q->whereHas('PD_BEN_HEAD', $conditionBenHead);
            };
            $data2 = HBS_CL_CLAIM::with(['HBS_CL_LINE' => $condition])->findOrFail($search)->HBS_CL_LINE;
            $data['HBS_CL_CLAIM'] = $datas;
            $data['HBS_CL_LINE'] = $data2;
            
            return response()->json($data);
        }
        return response()->json($data);
    }
}
