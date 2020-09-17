<?php

namespace App\Transformers\Book;

use App\Transformers\BaseTransformer;

class BookTransformer extends BaseTransformer
{
    /**
     * {@inheritdoc}
     */
    public function getResourceKey(): string
    {
        return 'books';
    }

    /**
     * transform.
     *
     * @param $books
     *
     * @return array
     */
    public function transform($books)
    {
        return [
            'id'          => $books->id,
            'title'       => $books->title,
            'author'      => $books->author,
            'description' => $books->description,
            'status'      => [
                'status_id'   => $books->status_id,
                'status_name' => $books->status,
            ],
            'created_at'  => $books->created_at,
            'updated_at'  => $books->updated_at,
        ];
    }
}
