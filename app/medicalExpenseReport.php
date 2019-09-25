<?php

namespace App;
use Auth;
use Config;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class medicalExpenseReport extends Model
{
    //
    protected $guarded = ['id'];
    protected $table = 'medical_expense_report';
    protected $casts   = [
        'url_file_split' => 'array',
    ];
    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'array' && is_null($value)) {
            return [];
        }
        return parent::castAttribute($key, $value);
    }
}
