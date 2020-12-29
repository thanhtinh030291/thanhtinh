<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MANTIS_BUG extends BaseModelMantisDLVN
{
    protected $table = 'mantis_bug_table';
    protected $guarded = ['id'];

    public function CUSTOM_FIELD_STRING()
    {
        return $this->hasMany('App\MANTIS_CUSTOM_FIELD_STRING', 'bug_id', 'id');
    }

    public function BUG_TEXT()
    {
        return $this->hasOne('App\MANTIS_BUG_TEXT', 'id', 'bug_text_id');
    }

    public function PROJECT(){
        return $this->hasOne('App\MANTIS_PROJECT', 'id', 'project_id');
    }

    public function handler(){
        return $this->hasOne('App\MANTIS_USER', 'id', 'handler_id');
    }

    public function history(){
        return $this->hasOne('App\MANTIS_BUG_HISTORY', 'bug_id', 'id')->where('field_name','status')->orderBy('id','DESC');
    }

    public function HBS_DATA(){
        return $this->hasOne('App\MANTIS_HBS_DATA', 'bug_id', 'id');
    }
}
