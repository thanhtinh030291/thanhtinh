<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HBS_PD_BEN_HEAD extends BaseModelDB2
{
    protected $table = 'pd_ben_head';
    protected $guarded = ['behd_oid'];
    protected $primaryKey = 'behd_oid';

    public function PD_PLAN_LIMIT()
    {
        return $this->belongsToMany('App\HBS_PD_PLAN_LIMIT');
    }
    
}
