<?php

namespace App\Repositories;

use App\RoomAndBoard;
use App\Repositories\BaseRepository;

/**
 * Class RoomAndBoardRepository
 * @package App\Repositories
 * @version November 5, 2019, 11:56 pm UTC
*/

class RoomAndBoardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'code_claim',
        'time_start',
        'time_end',
        'created_user',
        'updated_user'
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
        return RoomAndBoard::class;
    }
}
