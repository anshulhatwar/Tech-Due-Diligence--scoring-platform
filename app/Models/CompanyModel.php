<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'companies';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'name',
        'industry',
        'stage',
        'location'
    ];

    protected $useTimestamps = false;
}