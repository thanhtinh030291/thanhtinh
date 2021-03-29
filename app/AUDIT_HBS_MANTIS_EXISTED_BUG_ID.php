<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AUDIT_HBS_MANTIS_EXISTED_BUG_ID extends BaseModelAudit
{
    protected $table = 'dlvn_mantis_existed_bug_id';
    protected $guarded = ['id'];
}
