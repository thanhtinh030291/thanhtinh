<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends  BaseModelDB2
{
    protected $table = 'sales';
    protected static $table_static = 'sales';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
