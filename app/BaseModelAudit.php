<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModelAudit extends Model
{
    protected $connection = 'mysql_audit';

}
