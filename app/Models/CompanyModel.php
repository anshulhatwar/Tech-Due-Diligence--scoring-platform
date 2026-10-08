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
        'founder_details',
        'contact_email',
        'contact_phone',
        'website',
        'industry',
        'stage',
        'location',
        'year_established',
        'team_size',
        'company_description',
        'problem_statement',
        'product_service',
        'business_model',
        'usp',
        'technology_used',
        'intellectual_property'
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}