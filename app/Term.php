<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends BaseModel
{
    protected $table = 'terms';
    protected static $table_static = 'terms';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    public function userUpdated()
    {
        return $this->hasOne('App\User', 'id', 'updated_user');
    }

    public function userCreated()
    {
        return $this->hasOne('App\User', 'id', 'created_user');
    }

    public function getFullTextTermAttribute(){
        return $this->name ." : ". $this->description;
    }
}
