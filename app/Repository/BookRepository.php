<?php

namespace App\Repository;

use App\Models\BookModel;
use Fluent\Repository\Eloquent\BaseRepository;

class BookRepository extends BaseRepository
{
    protected $searchable = [
        'title'       => 'like',
        'author'      => 'orLike',
        'description' => 'orLike',
        'status'      => 'orLike',
    ];

    public function entity()
    {
        return new BookModel();
    }
}
