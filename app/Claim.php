<?php

namespace App;

class Claim extends BaseModel
{
    protected $guarded = ['id'];
    protected $table = 'claim';
    protected static $table_static = 'claim';
    protected $dates = ['deleted_at'];
    

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
