<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
