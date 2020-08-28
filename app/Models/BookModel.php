<?php

namespace App\Models;

use App\Entities\BookEntity;
use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $returnType = BookEntity::class;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['title', 'author', 'description', 'status_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'status_id'   => 'required|numeric',
        'title'       => 'required|min_length[10]|max_length[60]',
        'author'      => 'required',
        'description' => 'required|min_length[10]|max_length[200]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    const ORDERABLE = [
        1 => 'title',
        2 => 'author',
        3 => 'description',
        4 => 'status',
    ];

    public $orderable = ['title', 'author', 'description', 'status'];

    /**
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = '')
    {
        $builder = $this->builder()
            ->select('books.id, books.title, books.author, books.description, books.created_at, status.status')
            ->join('status', 'books.status_id = status.id');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('title', $search)
                ->orLike('author', $search)
                ->orLike('description', $search)
                ->orLike('status', $search)
            ->groupEnd();

        return $condition->where([
            'books.deleted_at'  => null,
            'status.deleted_at' => null,
        ]);
    }
}
