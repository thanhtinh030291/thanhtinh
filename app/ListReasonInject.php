<?php

namespace App;
use Schema;

class ListReasonInject extends BaseModel
{
    protected $table    = 'list_reason_inject';
    protected $guarded  = ['id'];
    

    public function userUpdated()
    {
        return $this->hasOne('App\User', 'id', 'updated_user');
    }

    public function userCreated()
    {
        return $this->hasOne('App\User', 'id', 'created_user');
    }

    public static function search($arr = null) {
        $table    = 'list_reason_inject';
        $listFeild = Schema::getColumnListing($table);
        $valueSearch = [];
        $data = self::where("{$table}.is_deleted", 0);
        foreach ($listFeild as $key => $value) {
            $valueSearch[$value] = isset($arr[$value]) ? $arr[$value] : null;
        }
        foreach ($valueSearch as $key => $value) {
            if ($value != null) {
                switch (Schema::getColumnType($table, $key)) {
                case 'integer':
                case 'decimal':
                    $data->where($key, $value);
                    break;
                case 'text':
                case 'string';
                    $data->where($key, 'LIKE', '%' . $value . '%');
                    break;
                default:
                    $data->where($key, 'LIKE', '%' . $value . '%');
                }
            }
        }
        return $data;
    }
}
