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

    
    
    public $fillable = [
        'claim_id',
        'mem_ref_no',
        'visit',
        'assessment',
        'medical',
        'claim_resuft',
        'note',
        'notification',
        'dischage_summary',
        'vat',
        'copy_of',
        'medical_report',
        'breakdown',
        'discharge_letter',
        'treatment_plant',
        'incident_report',
        'prescription',
        'lab_test',
        'police_report',
        'created_user',
        'updated_user',
        'deleted_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'claim_id' => 'integer',
        'mem_ref_no' => 'string',
        'claim_resuft' => 'integer',
        'note' => 'integer',
        'notification' => 'integer',
        'dischage_summary' => 'integer',
        'vat' => 'integer',
        'copy_of' => 'integer',
        'medical_report' => 'integer',
        'breakdown' => 'integer',
        'discharge_letter' => 'integer',
        'treatment_plant' => 'integer',
        'incident_report' => 'integer',
        'prescription' => 'integer',
        'lab_test' => 'integer',
        'police_report' => 'integer',
        'created_user' => 'integer',
        'updated_user' => 'integer'
    ];

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
