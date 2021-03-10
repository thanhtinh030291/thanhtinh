<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOfClaim extends Model {
    protected $table   = 'item_of_claim';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    public $fillable = [
        'content',
        'amount',
        'status',
        'claim_id',
        'reason_reject_id',
        'parameters',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'benefit'
    ];
    protected $casts   = [
        'parameters' => 'array',
    ];
    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'array' && is_null($value)) {
            return [];
        }
        return parent::castAttribute($key, $value);
    }
    public function reason_reject()
    {
        return $this->hasOne('App\ReasonReject', 'id', 'reason_reject_id');
    }
}
