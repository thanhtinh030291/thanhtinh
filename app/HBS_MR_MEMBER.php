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
        $memb_ref_no = $this->memb_ref_no;

        $conditionBNF = function($q) {
            $q->with('PD_BEN_HEAD');
        };
        $conditionPOPL = function($q) use($conditionBNF){
            $q->with('PD_PLAN');
            $q->with(['PD_PLAN_BENEFIT' => $conditionBNF]);
            $q->with('MR_POLICY');
        };
        $conditionMEMPL = function($q) use ($conditionPOPL){
            $q->with(['MR_POLICY_PLAN' => $conditionPOPL]);
        };
        $HBS_MR_MEMBERs = HBS_MR_MEMBER::where('memb_ref_no',$memb_ref_no)->with(['MR_MEMBER_PLAN'=>$conditionMEMPL ])->get()->pluck('MR_MEMBER_PLAN.*.MR_POLICY_PLAN');
        $MR_POLICY_PLANs = collect();
        foreach ($HBS_MR_MEMBERs as $HBS_MR_MEMBER) {
            
            $MR_POLICY_PLANs = $MR_POLICY_PLANs->merge($HBS_MR_MEMBER);
        }
        $plans = [];
        foreach ($MR_POLICY_PLANs as $MR_POLICY_PLAN) {
            $eff_date = Carbon::parse($MR_POLICY_PLAN->MR_POLICY->eff_date)->format('d/m/Y');
            $plan = [];
            foreach ($MR_POLICY_PLAN->PD_PLAN_BENEFIT as $PD_PLAN_BENEFIT) {
                switch ($PD_PLAN_BENEFIT->PD_BEN_HEAD->scma_oid_ben_type) {
                    case 'BENEFIT_TYPE_IP':
                        switch ($MR_POLICY_PLAN->PD_PLAN->plan_id) {
                            case '0001':
                                $plan[] = 'IP 210M';
                                break;
                            case '0002':
                            case '0006':
                                $plan[] = 'IP 420M';
                                break;
                            case '0003':
                            case '0004':
                            case '0005':
                                $plan[] = 'IP 630M';
                                break;
                            case '0007':
                            case '0013':
                                $plan[] = 'IP 300M';
                                break;
                            case '0008':
                            case '0009':
                            case '0014':
                            case '0015':
                                $plan[] = 'IP 630M';
                                break;
                            case '0010':
                            case '0011':
                            case '0012':
                            case '0016':
                            case '0017':
                            case '0018':
                                $plan[] = 'IP 630M';
                                break;
                            default:
                                $plan[] = 'IP none';
                                break;
                        }
                        break;
                    case 'BENEFIT_TYPE_OP':
                        switch ($MR_POLICY_PLAN->PD_PLAN->plan_id) {
                            case '0001':
                            case '0005':
                            case '0006':
                                $plan[] = 'OP 2.1M';
                                break;
                            case '0002':
                            case '0004':
                                $plan[] = 'OP 4.2M';
                                break;
                            case '0003':
                                $plan[] = 'OP 6.3M';
                                break;
                            case '0007':
                            case '0009':
                            case '0012':
                            case '0013':
                            case '0015':
                            case '0018':
                                $plan[] = 'OP 5M';
                                break;
                            case '0008':
                            case '0011':
                            case '0014':
                            case '0017':
                                $plan[] = 'OP 10M';
                                break;
                            case '0010':
                            case '0016':
                                $plan[] = 'OP 15M';
                                break;
                            default:
                                $plan[] = 'OP none';
                                break;
                        }    
                        break;
                    default:
                        $plan[] = 'DT';
                        break;
                }
            }
            $plans[] = implode(", ", $plan) ." - " . "$eff_date";
        }

        // $plan = [];
        // $DLVN_MEMBER = DLVN_MEMBER::where('MEMB_REF_NO' , $this->memb_ref_no)->orderBy('pocy_eff_date', 'desc')->get();
        // foreach ($DLVN_MEMBER as $key => $value) {
        //     $plan_merge = array_map('trim', array_filter($value->only(['ip_plan','op_plan','dt_plan'])));
        //     $plan[] = implode(", ", $plan_merge) ." - ".Carbon::parse($value->pocy_eff_date)->format('d/m/Y');
        // }
        return $plans;
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
