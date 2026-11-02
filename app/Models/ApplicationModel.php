<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentModel extends Model
{
    protected $table = 'application_assignments';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'application_id',
        'evaluator_id',
        'assigned_by',
        'status',
        'assigned_at'
    ];

    protected $useTimestamps = false;
}