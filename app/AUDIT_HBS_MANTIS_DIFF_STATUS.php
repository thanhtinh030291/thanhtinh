<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AUDIT_HBS_MANTIS_DIFF_STATUS extends BaseModelAudit
{
    protected $table = 'dlvn_hbs_mantis_diff_status';
    protected $guarded = ['id'];
}
