<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'assessment_applications';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'company_id',
        'application_number',
        'assessment_type',
        'status',
        'payment_status',
        'submitted_at'
    ];

    protected $useTimestamps = false;
}