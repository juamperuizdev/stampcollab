<?php

namespace App\Models;
use CodeIgniter\Model;

class JournalModel extends Model {

    protected $table            = 'sta_journal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'status',
        'pages',
        'stamps',
        'slug',
        'name',
        'description',
        'cover',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

}
