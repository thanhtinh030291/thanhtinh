<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MANTIS_BUG extends BaseModelMantisDLVN
{
    protected $table = 'mantis_bug_table';
    protected $guarded = ['id'];
    
}
