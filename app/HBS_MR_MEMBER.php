<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HBS_MR_MEMBER extends  BaseModelDB2
{
    protected $table = 'MR_MEMBER';
    protected $guarded = ['id'];
    protected $primaryKey = 'memb_oid';
    public function MR_MEMBER_PLAN()
    {
        return $this->hasMany('App\HBS_MR_MEMBER_PLAN', 'memb_oid', 'memb_oid');
    }
    public function MR_MEMBER_EVENT()
    {
        return $this->hasMany('App\HBS_MR_MEMBER_EVENT', 'memb_oid', 'memb_oid');
    }
    public function CL_LINE()
    {
        return $this->hasMany('App\HBS_CL_LINE', 'memb_oid', 'memb_oid')->where('REV_DATE', null);
    }
    public function CL_MBR_EVENT()
    {
        return $this->hasMany('App\HBS_CL_MBR_EVENT', 'memb_oid', 'memb_oid');
    }
    
    public function getPocyEffdateAttribute()
    {
        $MR_MEMBER_PLAN = $this->MR_MEMBER_PLAN->first();
        if($MR_MEMBER_PLAN){
            return Carbon::parse($MR_MEMBER_PLAN->eff_date)->format('d/m/Y');
        }
        return "";
    }

    public function getOccupationAttribute()
    {
        $MR_MEMBER_PLAN = $this->MR_MEMBER_PLAN->sortByDesc('eff_date')->first();
        $occupation = [];
        if(!empty($MR_MEMBER_PLAN)){
            foreach ($MR_MEMBER_PLAN->MR_POLICY_PLAN_BENEFIT as $key => $value) {
                $pre = $value->PD_PLAN_BENEFIT->PD_BEN_HEAD->scma_oid_ben_type;
                switch ($pre) {
                    case 'BENEFIT_TYPE_IP':
                        
                            $occupation[] = "IP {$value->pivot->occuation_ldg_pct}%";
                        
                        break;
                    case 'BENEFIT_TYPE_OP':
                            if($value->pivot->occuation_ldg_pct != null)
                                $occupation[] = "OP {$value->pivot->occuation_ldg_pct}%";
                            break;
                    default:
                        break;
                }
            }
        }
        return array_unique($occupation);
    }

    public function getPlanAttribute()
    {
        //return [];
        $plan = [];
        $DLVN_MEMBER = DLVN_MEMBER::where('MEMB_REF_NO' , $this->memb_ref_no)->orderBy('pocy_eff_date', 'desc')->get();
        foreach ($DLVN_MEMBER as $key => $value) {
            $plan_merge = array_map('trim', array_filter($value->only(['ip_plan','op_plan','dt_plan'])));
            $plan[] = implode(", ", $plan_merge) ." - ".Carbon::parse($value->pocy_eff_date)->format('d/m/Y');
        }
        return $plan;
    }

    public function getStatusQueryAttribute(){
        //return " ";
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        try {
            $request = $client->get(config('constants.url_query_online').$this->memb_ref_no);
            $response = $request->getBody()->getContents();
            $response = json_decode($response,true);
            if(data_get($response, 'response_msg.msg_code') == "DLVN0"){
                $html = "";
                foreach(data_get($response, 'client_info', []) as $key => $value){
                    $html .= "<span class = 'ml-2'>" . data_get($value ,'sPlanID') . ": ".  data_get($value ,'sStatus')  . "</span>";
                }
                return $html;
            }else{
                return "";
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return "";
        }
    }

    public function getQueryOnlineAttribute(){
        //return " ";
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        try {
            $request = $client->get(config('constants.url_query_online').$this->memb_ref_no);
            $response = $request->getBody()->getContents();
            return $response;

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return "";
        }
    }

}
