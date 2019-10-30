<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HBS_MR_POLICY_PLAN extends BaseModelDB2
{
    protected $table = 'mr_policy_plan';
    protected $primaryKey = 'popl_oid';
    public function MR_POLICY()
    {
        return $this->hasOne('App\HBS_MR_POLICY', 'pocy_oid', 'pocy_oid');
    }
}
