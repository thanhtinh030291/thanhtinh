<?php

namespace App\Repositories;

use App\ReportAdmin;
use App\Repositories\BaseRepository;

/**
 * Class ReportAdminRepository
 * @package App\Repositories
 * @version October 23, 2020, 9:26 am +07
*/

class ReportAdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'MEMB_NAME',
        'POCY_REF_NO',
        'MEMB_REF_NO',
        'PRES_AMT',
        'INV_NO',
        'PROV_NAME',
        'RECEIVE_DATE',
        'REQUEST_SEND',
        'SEND_DLVN_DATE',
        'CL_NO'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ReportAdmin::class;
    }
}
