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
        'title'       => 'required|min_length[10]|max_length[60]',
        'author'      => 'required',
        'description' => 'required|min_length[10]|max_length[200]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function listAll($order, $dir, $limit, $start)
    {
        return $this->db->table('books as b')
                    ->select('b.id, b.title, b.author, b.description, s.status')
                    ->join('status as s', 'b.status_id = s.id')
                    ->where('b.deleted_at =', NULL)
                    ->where('s.deleted_at =', NULL)
                    ->limit($limit, $start)
                    ->orderBy($order, $dir)
                    ->get()
                    ->getResult($this->returnType);
    }

    public function listSearchBook($order, $dir, $limit, $start, $search)
    {
        return $this->db->table('books as b')
                    ->select('b.id, b.title, b.author, b.description, s.status')
                    ->join('status as s', 'b.status_id = s.id')
                    ->where('b.deleted_at =', NULL)
                    ->where('s.deleted_at =', NULL)
                    ->like('b.title', $search)
                    ->orLike('b.author', $search)
                    ->orLike('b.description', $search)
                    ->orLike('s.status', $search)
                    ->limit($limit, $start)
                    ->orderBy($order, $dir)
                    ->get()
                    ->getResult($this->returnType);
    }

    public function countSearchBook($search)
    {
        return $this->db->table('books as b')
                    ->select('b.id, b.title, b.author, b.description, s.status')
                    ->join('status as s', 'b.status_id = s.id')
                    ->where('b.deleted_at =', NULL)
                    ->where('s.deleted_at =', NULL)
                    ->like('b.title', $search)
                    ->orLike('b.author', $search)
                    ->orLike('b.description', $search)
                    ->orLike('s.status', $search)
                    ->countAll();
    }
}
