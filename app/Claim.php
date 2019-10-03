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

    public function item_of_claim()
    {
        return $this->hasMany('App\ItemOfClaim', 'claim_id');
    }


    public static function storeFile($file ,  $dirUpload){
        $imageName = time() . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $file->storeAs($dirUpload, $imageName);
        return $imageName;
    }

}
