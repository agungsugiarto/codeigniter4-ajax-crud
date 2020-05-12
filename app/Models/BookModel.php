<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
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

    /**
     * Find with paginate data.
     *
     * @param int $length
     * @param int $start
     * @param string $order 
     * @param string $dir
     * @param string $keyword
     *
     * @return array
     */
    public function findPaginatedData(string $order, string $dir, int $length, int $start, string $keyword = ''): array
    {
        return $this->builder()
            ->select('books.id, books.title, books.author, books.description, books.created_at, status.status')
            ->join('status', 'books.status_id = status.id')
            ->groupStart()
                ->like('title', $keyword)
                ->orLike('author', $keyword)
                ->orLike('description', $keyword)
                ->orLike('status', $keyword)
            ->groupEnd()
            ->where([
                'books.deleted_at'  => null,
                'status.deleted_at' => null,
            ])
            ->orderBy($order, $dir)
            ->limit($length, $start)
            ->get()
            ->getResultObject();
    }
    
    /**
     * Find with count all data.
     *
     * @param string $keyword
     *
     * @return int
     */
    public function countFindData(string $keyword = ''): int
    {
        return $this->builder()
            ->select('books.id, books.title, books.author, books.description, books.created_at, status.status')
            ->join('status', 'books.status_id = status.id')
            ->groupStart()
                ->like('title', $keyword)
                ->orLike('author', $keyword)
                ->orLike('description', $keyword)
                ->orLike('status', $keyword)
            ->groupEnd()
            ->where([
                'books.deleted_at'  => null,
                'status.deleted_at' => null,
            ])
            ->countAllResults();
    }

        
    /**
     * Total all.
     *
     * @return int
     */
    public function totalAll(): int
    {
        return $this->builder()
            ->select('books.id, books.title, books.author, books.description, books.created_at, status.status')
            ->join('status', 'books.status_id = status.id')
            ->where([
                'books.deleted_at'  => null,
                'status.deleted_at' => null,
            ])
            ->countAllResults();
    }
}
