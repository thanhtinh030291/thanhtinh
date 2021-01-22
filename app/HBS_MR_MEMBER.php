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
    public function getClaimLineAttribute()
    {
        $memb_ref_no = $this->memb_ref_no;
        $HBS_MR_MEMBER = HBS_MR_MEMBER::where('memb_ref_no',$memb_ref_no)->pluck('memb_oid')->toArray();
        $CL_LINE = HBS_CL_LINE::whereIn('memb_oid',$HBS_MR_MEMBER)->where('REV_DATE', null)->get();
        return $CL_LINE;
    }
    public function getMrMemberEventAttribute()
    {
        $memb_ref_no = $this->memb_ref_no;
        $HBS_MR_MEMBER = HBS_MR_MEMBER::where('memb_ref_no',$memb_ref_no)->pluck('memb_oid')->toArray();
        $MR_MBR_EVENT = HBS_MR_MEMBER_EVENT::whereIn('memb_oid',$HBS_MR_MEMBER)->get();
        return $MR_MBR_EVENT;
    }

    public function getClaimMemberEventAttribute()
    {
        $memb_ref_no = $this->memb_ref_no;
        $HBS_MR_MEMBER = HBS_MR_MEMBER::where('memb_ref_no',$memb_ref_no)->pluck('memb_oid')->toArray();
        $CL_MBR_EVENT = HBS_CL_MBR_EVENT::whereIn('memb_oid',$HBS_MR_MEMBER)->get();
        return $CL_MBR_EVENT;
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

    


    public function getBankNameChangeAttribute()
    {
        $HBS_SY_SYS_CODE = HBS_SY_SYS_CODE::selectRaw("scma_oid , hbs.FN_GET_SYS_CODE_DESC(scma_oid, 'en') name")->where("scma_oid","LIKE","%MEMB_BANK_NAME_%")->pluck("name","scma_oid");
        preg_match('/(MEMB_BANK_NAME_)/', $this->bank_name, $matches, PREG_OFFSET_CAPTURE);

        return $matches ? data_get($HBS_SY_SYS_CODE ,$this->bank_name) : $this->bank_name;
    }
    
    public function getCashBankNameChangeAttribute()
    {
        $HBS_SY_SYS_CODE = HBS_SY_SYS_CODE::selectRaw("scma_oid , hbs.FN_GET_SYS_CODE_DESC(scma_oid, 'en') name")->where("scma_oid","LIKE","%MEMB_BANK_NAME_%")->pluck("name","scma_oid");
        preg_match('/(MEMB_BANK_NAME_)/', $this->cash_bank_name, $matches, PREG_OFFSET_CAPTURE);
        return $matches ? data_get($HBS_SY_SYS_CODE,$this->cash_bank_name) : $this->cash_bank_name;
    }
}
