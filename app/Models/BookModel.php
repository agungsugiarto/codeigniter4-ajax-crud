<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table      = 'books';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['title', 'author', 'description', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title' => 'required|min_length[10]|max_length[60]',
        'author' => 'required',
        'description' => 'required|min_length[10]|max_length[200]',
        'status' => 'required'
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}