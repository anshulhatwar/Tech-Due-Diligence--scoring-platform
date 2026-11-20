<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluationScoreModel extends Model
{
    protected $table = 'evaluation_scores';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'evaluation_id',
        'parameter_id',
        'score',
        'weighted_score'
    ];

    protected $useTimestamps = false;
}