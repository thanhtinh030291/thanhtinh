<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AUDIT_HBS_EXISTED extends BaseModelAudit
{
    protected $table = 'dlvn_hbs_existed';
    protected $guarded = ['id'];
}
