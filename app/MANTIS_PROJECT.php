<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MANTIS_PROJECT extends BaseModelMantisDLVN
{
    protected $table = 'mantis_project_table';
    protected $guarded = ['id'];
}
