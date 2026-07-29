<?php

namespace App\Models;
use CodeIgniter\Model;

class AdministratorModel extends Model {

    protected $table            = 'sta_administrator';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'status',
        'name',
        'surname',
        'email',
        'password',
        'avatar',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    
}