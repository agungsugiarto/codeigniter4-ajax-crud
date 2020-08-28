<?php

namespace App\Models;

use App\Entities\StatusEntity;
use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $returnType = StatusEntity::class;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'status' => 'required|min_length[10]|max_length[200]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public $orderable = ['status'];
}
