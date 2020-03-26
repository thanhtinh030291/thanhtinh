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

        $q = [  
                'group' => explode(".", $this->name)[0],
                'num'   => explode(".", $this->name)[1],
                'name' => $this->name,
                'content' => '<p style="text-align: justify;">Điều ' .$this->name ." ". preg_replace('/(<p>)/', "", $this->description, 1)
            ];
        return $q;
    }
}
