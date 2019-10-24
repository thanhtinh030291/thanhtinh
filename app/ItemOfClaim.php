<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOfClaim extends Model {
    protected $table   = 'item_of_claim';
    protected $guarded = ['id'];
    public function reason_reject()
    {
        return $this->hasOne('App\ReasonReject', 'id', 'reason_reject_id');
    }
}
