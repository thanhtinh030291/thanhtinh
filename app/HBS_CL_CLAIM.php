<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HBS_CL_CLAIM extends  BaseModelDB2
{
    protected $table = 'CL_CLAIM';
    protected $guarded = ['id'];
    protected $primaryKey = 'clam_oid';

    public function HBS_CL_LINE()
    {
        return $this->hasMany('App\HBS_CL_LINE', 'clam_oid', 'clam_oid');
    }

    public function getMemberAttribute()
    {
        $fisrtClLine = $this->HBS_CL_LINE->first();
        if($fisrtClLine){
            $memb_oid = $fisrtClLine->memb_oid;
            return HBS_MR_MEMBER::findOrFail($memb_oid);
        }
        return null;
    }

    public function getPoliceAttribute()
    {
        $fisrtClLine = $this->HBS_CL_LINE->first();
        if($fisrtClLine){
            $popl_oid = $fisrtClLine->popl_oid;
            return HBS_MR_POLICY_PLAN::with('MR_POLICY')->findOrFail($popl_oid)->MR_POLICY;
        }
        return null;
    }

    public function getApplicantNameAttribute(){
        $dbDate = \Carbon\Carbon::parse($this->member->dob);
        $diffYears = \Carbon\Carbon::now()->diffInYears($dbDate);
        if($diffYears >= 18){
            return $this->member->mbr_last_name ." " . $this->member->mbr_first_name;
        }else{
            return $this->policyHolder->poho_name_1;
        }
        
    }

    public function getMemberNameCapAttribute(){
        return $this->member->mbr_last_name ." " . $this->member->mbr_first_name;
    }


    public function getPayMethodAttribute(){
        
        return $this->policyHolder->scma_oid_cl_pay_method;
    }

    public function getPolicyHolderAttribute(){
        $poho_oid = $this->member->poho_oid;
        return HBS_MR_POLICYHOLDER::findOrFail($poho_oid);
    }

    public function getSumPresAmtAttribute(){
        $clLines = $this->HBS_CL_LINE->toArray();
        $sum = array_sum(array_column($clLines,'pres_amt'));
        return $sum;
    }

    public function getSumAppAmtAttribute(){
        $clLines = $this->HBS_CL_LINE->toArray();
        $sum = array_sum(array_column($clLines,'app_amt'));
        return $sum;
    }

    //show RT_DIAGNOSIS
    public function scopeIOPDiag($query){
        $conditionPlanLimit = function($q){
            $q->with('PD_BEN_HEAD');
        };

        $conditionPD = function($q) use ($conditionPlanLimit){
            $q->with(['PD_PLAN_LIMIT' => $conditionPlanLimit]);
        };
        $conditionPL = function($q) use ($conditionPD){
            $q->with(['PD_PLAN' => $conditionPD]);
        };
        $condition = function ($q) use ($conditionPL){
            $q->with('RT_DIAGNOSIS');
            $q->with('PD_BEN_HEAD');
            $q->with(['MR_POLICY_PLAN'=>$conditionPL]);
            $q->where('REV_DATE', null);
        };
        return $query->with(['HBS_CL_LINE' => $condition]);
    }
    

}
