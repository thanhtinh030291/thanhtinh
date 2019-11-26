<?php

namespace App;
use Schema;

class ExportLetter extends BaseModel
{
    protected $table    = 'export_letter';
    protected $guarded  = ['id'];
    protected static $table_static = 'export_letter';
    protected $casts = [
        'note'  => 'array',
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

}
