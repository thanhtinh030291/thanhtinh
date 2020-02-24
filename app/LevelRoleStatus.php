<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LevelRoleStatus
 * @package App
 * @version February 24, 2020, 5:34 pm +07
 *
 * @property string name
 * @property integer min_amount
 * @property integer max_amount
 * @property integer begin_status
 * @property integer end_status
 * @property integer created_user
 * @property integer updated_user
 * @property integer is_deleted
 */
class LevelRoleStatus extends BaseModel
{
    use SoftDeletes;

    public $table = 'level_role_status';
    protected static $table_static = 'level_role_status';
    
    
    protected $dates = ['deleted_at'];

    
    
    public $fillable = [
        'name',
        'min_amount',
        'max_amount',
        'begin_status',
        'end_status',
        'created_user',
        'updated_user',
        'is_deleted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'min_amount' => 'integer',
        'max_amount' => 'integer',
        'begin_status' => 'integer',
        'end_status' => 'integer',
        'created_user' => 'integer',
        'updated_user' => 'integer',
        'is_deleted' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
