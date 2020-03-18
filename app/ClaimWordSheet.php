<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Activity;
use Spatie\Activitylog\Models\Activity as ActivityModel;


/**
 * Class ClaimWordSheet
 * @package App
 * @version March 11, 2020, 2:42 pm +07
 *
 * @property integer claim_id
 * @property string mem_ref_no
 * @property string visit
 * @property string assessment
 * @property string medical
 * @property integer claim_resuft
 * @property integer note
 * @property integer notification
 * @property integer dischage_summary
 * @property integer vat
 * @property integer copy_of
 * @property integer medical_report
 * @property integer breakdown
 * @property integer discharge_letter
 * @property integer treatment_plant
 * @property integer incident_report
 * @property integer prescription
 * @property integer lab_test
 * @property integer police_report
 * @property integer created_user
 * @property integer updated_user
 * @property integer deleted_at
 */
class ClaimWordSheet extends BaseModel
{
    use SoftDeletes;
    use LogsActivity;
    protected $guarded  = ['id'];
    public $table = 'claim_word_sheet';
    protected static $table_static = 'claim_word_sheet';
    protected static $logAttributes = ["*"];
    protected $subject_type = 'App\ClaimWordSheet';
    protected $dates = ['deleted_at'];

    

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'request_qa' => 'array',
    ];
    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'array' && is_null($value)) {
            return [];
        }
        return parent::castAttribute($key, $value);
    }
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getLogAttribute()
    {
        $log = ActivityModel::where('subject_type', $this->subject_type)->where('subject_id', $this->id)->get();
        return $log;
    }
    
}
