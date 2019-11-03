<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id'];
    public function userTo()
    {
        return $this->belongsTo(User::class,'user_to')->select('email','id','name');
    }
    public function userFrom()
    {
        return $this->belongsTo(User::class,'user_from')->select('email','id','name');
    }
}
