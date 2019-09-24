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

}
