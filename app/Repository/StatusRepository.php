<?php

namespace App\Repository;

use App\Models\StatusModel;
use Fluent\Repository\Eloquent\BaseRepository;

class StatusRepository extends BaseRepository
{
    protected $searchable = [
        'status' => 'like',
    ];

    public function entity()
    {
        return new StatusModel();
    }
}
