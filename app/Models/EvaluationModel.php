<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluationModel extends Model
{
    protected $table = 'evaluations';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'application_id',
        'evaluator_id',
        'total_score',
        'comments',
        'status',
        'submitted_at'
    ];

    protected $useTimestamps = false;
}