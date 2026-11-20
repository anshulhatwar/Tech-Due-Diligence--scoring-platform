<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table            = 'documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'user_id',
        'company_id',
        'document_name',
        'document_type',
        'file_name',
        'file_path',
        'status',
        'uploaded_at',
        'updated_at',
    ];

    protected $useTimestamps = false;
}