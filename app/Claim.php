<?php

namespace App;

class Claim extends BaseModel
{
    protected $guarded = ['id'];
    protected $table = 'claim';
    protected static $table_static = 'claim';
    protected $dates = ['deleted_at'];
    
    
    public function export_letter()
    {
        return $this->hasMany('App\ExportLetter', 'claim_id');
    }

    public function item_of_claim()
    {
        return $this->hasMany('App\ItemOfClaim', 'claim_id');
    }


    public static function storeFile($file ,  $dirUpload){
        $imageName = time() . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $file->storeAs($dirUpload, $imageName);
        return $imageName;
    }

    public function scopeItemClaimReject($query)
    {
        $conditionTerm = function ($q) {
           
            $q->with('term');
        };
        $condition = function ($q) use ($conditionTerm) {
            $q->whereNotNull('reason_reject_id');
            $q->with(['reason_reject'=>$conditionTerm]);
        };
        return $query->with(['item_of_claim' => $condition]);
    }
}
