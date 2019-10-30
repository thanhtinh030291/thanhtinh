<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HBS_CL_LINE extends BaseModelDB2
{
    protected $table = 'cl_line';
    protected $guarded = ['id'];
    public function HBS_MR_MEMBER()
    {
        return $this->hasOne('App\HBS_MR_MEMBER', 'memb_oid', 'memb_oid');
    }
    public function RT_DIAGNOSIS()
    {
        return $this->hasOne('App\HBS_RT_DIAGNOSIS', 'diag_oid', 'diag_oid');
    }
    public function PD_BEN_HEAD()
    {
        return $this->hasOne('App\HBS_PD_BEN_HEAD', 'behd_oid', 'behd_oid');
    }

    public function MR_POLICY_PLAN()
    {
        return $this->hasOne('App\HBS_MR_POLICY_PLAN', 'popl_oid', 'popl_oid');
    }
    
}
