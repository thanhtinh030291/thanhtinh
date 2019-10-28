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
}
