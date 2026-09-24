<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'ID';

    protected $allowedFields = [
        'Name',
        'Email',
        'Password',
        'Phone',
        'Address',
        'Role',
        'created_at'
    ];

    protected $useTimestamps = false;
}