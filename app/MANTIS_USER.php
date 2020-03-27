<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MANTIS_USER extends BaseModelMantis
{
    protected $table = 'mantis_user_table';
    protected $guarded = ['id'];
   
}
