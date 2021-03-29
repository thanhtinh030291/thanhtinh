<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AUDIT_HBS_EXISTED_BACODE extends BaseModelAudit
{
    protected $table = 'dlvn_hbs_existed_barcode';
    protected $guarded = ['id'];
}
