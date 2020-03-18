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
            return Carbon::parse($MR_MEMBER_PLAN->effdate)->format('d/m/Y');
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
        $plan = [];
        
        if(!empty($this->MR_MEMBER_PLAN)){
            foreach ($this->MR_MEMBER_PLAN as $key => $value) {
                $pre = $value->MR_POLICY_PLAN->PD_PLAN->PD_PLAN_LIMIT[0]->PD_BEN_HEAD[0]->scma_oid_ben_type;
                //$pre = $value->MR_POLICY_PLAN_BENEFIT[0]->PD_PLAN_BENEFIT->PD_BEN_HEAD->scma_oid_ben_type;
                $eff_date = Carbon::parse($value->eff_date)->format('d/m/Y');
                switch ($pre) {
                    case 'BENEFIT_TYPE_IP':
                        switch ($value->MR_POLICY_PLAN->PD_PLAN->plan_id) {
                            case '0001':
                                $plan[] = 'IP 210M - ' . $eff_date;
                                break;
                            case '0002':
                            case '0006':
                                $plan[] = 'IP 420M - ' . $eff_date;
                                break;
                            default:
                                $plan[] ='IP 630M - ' . $eff_date;
                                break;
                        }
                        break;
                    case 'BENEFIT_TYPE_OP':
                        switch ($value->MR_POLICY_PLAN->PD_PLAN->plan_id) {
                            case '0003':
                                $plan[] = 'OP 210M - ' . $eff_date;
                                break;
                            case '0002':
                            case '0004':
                                $plan[] = 'OP 420M - ' . $eff_date;
                                break;
                            default:
                                $plan[] ='OP 630M - ' . $eff_date;
                                break;
                        }
                    default:
                        break;
                }
            }
        }
        return $plan;
    }
}
