<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class LogUnfreezed extends Model
{
    protected $table = 'log_unfreezed';
    protected static $table_static = 'log_unfreezed';
    protected $guarded = ['id'];

    public function LogMfile()
    {
        return $this->belongsTo('App\LogMfile', 'claim_id', 'claim_id')->where('reason','Close');
    }

}
