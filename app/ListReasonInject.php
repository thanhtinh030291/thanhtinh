<?php

namespace App;
use Schema;

class ListReasonInject extends BaseModel
{
    protected $table    = 'list_reason_inject';
    protected $guarded  = ['id'];
    protected static $table_static = 'list_reason_inject';
    protected $dates = ['deleted_at'];
    

    public function userUpdated()
    {
        return $this->hasOne('App\User', 'id', 'updated_user');
    }

    public function userCreated()
    {
        return $this->hasOne('App\User', 'id', 'created_user');
    }

}
