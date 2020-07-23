<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HBS_MR_POLICY extends BaseModelDB2
{
    protected $table = 'mr_policy';
    protected $primaryKey = 'pocy_oid';
    public function MR_POLICY_PLAN()
    {
        return $this->hasMany('App\HBS_MR_POLICY_PLAN', 'pocy_oid', 'pocy_oid');
    }
}
