<?php

namespace App\Http\Controllers;
use App\HBS_CL_CLAIM;
use App\HBS_MR_POLICY_PLAN;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Claim;

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
            $datas = HBS_CL_CLAIM::findOrFail($search);
            return response()->json(['member' => $datas->member , 'claim' =>$datas ]);
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
                $q->where('scma_oid_cl_line_status','!=','CL_LINE_STATUS_RV');
            };
            $data2 = HBS_CL_CLAIM::with(['HBS_CL_LINE' => $condition])->findOrFail($search)->HBS_CL_LINE->toArray();
            foreach ($data2 as $key => $value) {
                $incurDate = Carbon::parse($value['incur_date_from'])->format('d/m/Y') .' 00:00 - '. Carbon::parse($value['incur_date_to'])->format('d/m/Y') . " 23:59";
                $data2[$key]['incur_date'] = $incurDate;
            }
            $data['HBS_CL_CLAIM'] = $datas;
            $data['HBS_CL_LINE'] = $data2;
            return response()->json($data);
        }
        return response()->json($data);
    }

    // checkRoomBoard
    public function checkRoomBoard(Request $request){
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $conditionHasBenHead = function($q) {
                $q->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP');
                $q->where('ben_head', 'RB');
            };

            $conditionPlanLimit = function($q) use ($conditionHasBenHead){
                $q->whereHas('PD_BEN_HEAD',$conditionHasBenHead);
            };

            $condition = function($q) use ($conditionPlanLimit){
                $q->with(['PD_PLAN_LIMIT' => $conditionPlanLimit]);
            };
            $datas = HBS_MR_POLICY_PLAN::with(['PD_PLAN' => $condition])
            ->findOrFail($search);
            return response()->json($datas->PD_PLAN->PD_PLAN_LIMIT[0]);
        }
        return response()->json($data);
    }

    // getPaymentHistory mantic
    public static function getPaymentHistory($cl_no){
        $data = GetApiMantic('api/rest/plugins/apimanagement/issues/'. $cl_no);
        $claim = Claim::where('code_claim_show',  $cl_no)->first();
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $approve_amt = $HBS_CL_CLAIM->sumAppAmt;
        return response()->json([ 'data' => $data, 'approve_amt' => $approve_amt]);
    }
    // get  payment of claim  CPS

    public static function getPaymentHistoryCPS($cl_no){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'get_payment/'. $cl_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        $response_full = collect($response)->where('TF_STATUS_NAME','!=', "NEW");
        $response = collect($response)->where('TF_STATUS_NAME','!=', "NEW");
            
        $claim = Claim::where('code_claim_show',  $cl_no)->first();
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $approve_amt = $HBS_CL_CLAIM->sumAppAmt;
        $present_amt = $HBS_CL_CLAIM->sumPresAmt;
        $payment_method = str_replace("CL_PAY_METHOD_","",$HBS_CL_CLAIM->payMethod);
        $payment_method = $payment_method == 'CA' ? "CH" : $payment_method;
        $pocy_ref_no = $HBS_CL_CLAIM->Police->pocy_ref_no;
        $memb_ref_no = $HBS_CL_CLAIM->member->memb_ref_no;
        $member_name = $HBS_CL_CLAIM->memberNameCap;
        return response()->json([ 'data' => $response,
                                'data_full' => $response_full,
                                'approve_amt' => (int)$approve_amt , 
                                'present_amt' => (int)$present_amt ,
                                'payment_method' => $payment_method,
                                'pocy_ref_no' => $pocy_ref_no,
                                'memb_ref_no' => $memb_ref_no,
                                'member_name' => $member_name,
                            ]);
    }
    // get  Balance of claim  CPS 
    public static function getBalanceCPS($mem_ref_no , $cl_no){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'get_client_debit/'. $mem_ref_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        /*
            There are 4 types:
            -	1: nợ được đòi lại
            -	2: nợ nhưng đã cấn trừ qua Claim khác
            -	3: nợ nhưng khách hàng đã gửi trả lại
            -	4: nợ không được đòi lại
        */
        if (empty($response)){
            $data =[
                'PCV_EXPENSE' => 0,
                'DEBT_BALANCE' => 0
            ];
            $data_full =[];
        }else{
            $colect_data = collect($response);
            $data =[
                'PCV_EXPENSE' => $colect_data->where('DEBT_CL_NO', $cl_no)->sum('PCV_EXPENSE'),
                'DEBT_BALANCE' => $colect_data->sum('DEBT_BALANCE')
            ];
            $data_full = collect($response);
        }

        return response()->json([ 'data' => $data , 'data_full' =>  $data_full]);
    }
    
    
    public static function setPcvExpense($paym_id, $pcv_expense){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'pcv_expense' => $pcv_expense,
            'username'    => Auth::user()->name
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'set_pcv_expense/'. $paym_id , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function sendPayment($request){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'memb_name' => $request->memb_name,
            'pocy_ref_no' => $request->pocy_ref_no,
            'memb_ref_no' => $request->memb_ref_no,
            'pres_amt' => $request->pres_amt,
            'app_amt' => $request->app_amt,
            'tf_amt' => $request->tf_amt,
            'deduct_amt' => $request->deduct_amt,
            'payment_method' => $request->payment_method,
            'mantis_id' => $request->mantis_id,
            'username'    => Auth::user()->name
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'send_payment/'. $request->cl_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function setDebt($debt_id){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'username'    => Auth::user()->name
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'set_debt/'. $debt_id , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function payDebt($request , $paid_amt){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'paid_amt' => $paid_amt,
            'username'    => Auth::user()->name,
            'cl_no' => $request->cl_no,
            'memb_name' => $request->memb_name,
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'pay_debt/'. $request->memb_ref_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }
}
