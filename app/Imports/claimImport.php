<?php

namespace App\Imports;

use App\Transport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class claimImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Transport([
            'type'     => $row['type'],
            'option'     => $row['option'],
            'depart_place'     => $row['depart_place'],
            'arrival_place'     => $row['arrival_place'],
            'price_adult'     => $row['price_adult'],
            'price_child'     => $row['price_child'],
            'duration'     => $row['duration'],
            'status'     => $row['status'],
            'created_user' => 1,
            'updated_user' => 1,
            'name_en' => $row['name_en'],
            'name_cn' => $row['name_cn'],
            'name_tw' => $row['name_tw'],
            'name_kr' => $row['name_kr'],
            'reservable_period' => $row['reservable_period'],
            'cancel_policy_en' => $row['cancel_policy_en'],
            'cancel_policy_cn' => $row['cancel_policy_cn'],
            'cancel_policy_tw' => $row['cancel_policy_tw'],
            'cancel_policy_kr' => $row['cancel_policy_kr'],
            'fp_recommend_order' => $row['fp_recommend_order'],

        ]);
    }
}

