<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HBS_CL_LINE extends BaseModelDB2
{
    protected $table = 'cl_line';
    protected $guarded = ['id'];
    public function HBS_MR_MEMBER()
    {
        return $this->belongsTo('App\HBS_MR_MEMBER', 'memb_oid', 'memb_oid');
    }
    public function RT_DIAGNOSIS()
    {
        return $this->hasOne('App\HBS_RT_DIAGNOSIS', 'diag_oid', 'diag_oid');
    }
    public function PD_BEN_HEAD()
    {
        return $this->belongsTo('App\HBS_PD_BEN_HEAD', 'behd_oid', 'behd_oid');
    }

    public function MR_POLICY_PLAN()
    {
        return $this->belongsTo('App\HBS_MR_POLICY_PLAN', 'popl_oid', 'popl_oid');
    }

    public function HBS_CL_LINE_REJ()
    {
        return $this->hasMany('App\HBS_CL_LINE_REJ', 'clli_oid', 'clli_oid');
    }

    public function getBankNameChangeAttribute()
    {
        $HBS_SY_SYS_CODE = HBS_SY_SYS_CODE::selectRaw("scma_oid , hbs.FN_GET_SYS_CODE_DESC(scma_oid, 'en') name")->where("scma_oid","LIKE","%MEMB_BANK_NAME_%")->pluck("name","scma_oid");
        preg_match('/(MEMB_BANK_NAME_)/', $this->bank_name, $matches, PREG_OFFSET_CAPTURE);

        return $matches ? data_get($HBS_SY_SYS_CODE ,$this->bank_name) : $this->bank_name;
    }
    
}
