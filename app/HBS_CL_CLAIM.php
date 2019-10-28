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

    public function getApplicantNameAttribute(){
        return $this->member->mbr_last_name ." " . $this->member->mbr_first_name;
    }

    public function getPayMethodAttribute(){
        $poho_oid = $this->member->poho_oid;
        return HBS_MR_POLICYHOLDER::findOrFail($poho_oid)->scma_oid_cl_pay_method;
    }
    


}
