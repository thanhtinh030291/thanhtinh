<?php

namespace App;
use Auth;
use Config;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $guarded = ['id'];
    protected $table = 'claim';
}
