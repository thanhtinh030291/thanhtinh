<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HBS_MR_MEMBER_PLAN extends  BaseModelDB2
{
    protected $table = 'MR_MEMBER_PLAN';
    protected $guarded = ['id'];
    protected $primaryKey = 'mepl_oid';
    
    public function MR_POLICY_PLAN()
    {
        return $this->belongsTo('App\HBS_MR_POLICY_PLAN', 'popl_oid', 'popl_oid');
    }

    public function MR_MEMBER()
    {
        return $this->belongsTo('App\HBS_MR_MEMBER', 'memb_oid', 'memb_oid');
    }

    public function BF_PREMIUM_MEMBER_PLAN()
    {
        return $this->hasMany('App\HBS_BF_PREMIUM_MEMBER_PLAN', 'mepl_oid', 'mepl_oid');
    }

    public function BF_DEBIT_NOTE() {
        return $this->belongsToMany('App\HBS_BF_DEBIT_NOTE', 'BF_PREMIUM_MEMBER_PLAN', 'note_oid', 'mepl_oid');
    }

    public function PD_PLAN(){
        return $this->belongsTo('App\HBS_PD_PLAN', 'plan_oid', 'plan_oid');
    }
}
