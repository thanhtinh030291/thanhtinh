<?php

namespace App;
use Schema;
use Spatie\Activitylog\Traits\LogsActivity;
use Activity;
use Spatie\Activitylog\Models\Activity as ActivityModel;
class ExportLetter extends BaseModel
{
    use LogsActivity;
    protected $table    = 'export_letter';
    protected $subject_type = 'App\ExportLetter';
    protected $guarded  = ['id'];
    protected static $table_static = 'export_letter';
    protected static $logAttributes = ['status'];
  

    protected $casts = [
        'note'  => 'array',
        'wait'  => 'array',
        'approve' => 'array',
        'info' => 'array',
    ];
    
    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'array' && is_null($value)) {
            return [];
        }
        return parent::castAttribute($key, $value);
    }
    
    protected $dates = ['deleted_at'];
    
    public function letter_template()
    {
        return $this->hasOne('App\LetterTemplate', 'id', 'letter_template_id');
    }

    public function userUpdated()
    {
        return $this->hasOne('App\User', 'id', 'updated_user');
    }

    public function userCreated()
    {
        return $this->hasOne('App\User', 'id', 'created_user');
    }

    public function getLogAttribute()
    {
        
        $log = ActivityModel::where('subject_type', $this->subject_type)->where('subject_id', $this->id)->get();
        return $log;
    }

}
