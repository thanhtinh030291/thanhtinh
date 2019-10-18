<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOfClaim extends Model {
    protected $table   = 'item_of_claim';
    protected $guarded = ['id'];
    public function list_reason_inject()
    {
        return $this->hasOne('App\ListReasonInject', 'id', 'list_reason_inject_id');
    }
}
