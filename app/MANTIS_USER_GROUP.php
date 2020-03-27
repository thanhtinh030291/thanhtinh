<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MANTIS_USER_GROUP extends BaseModelMantis
{
    protected $table = 'mantis_plugin_advancedgroup_user_group_table';
    protected $guarded = ['id'];
    public function USER()
    {
        return $this->belongsTo('App\MANTIS_USER', 'id', 'memb_oid');
    }
}
