<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModelCPS extends Model
{
    protected $connection = 'mysql_cps';

}
