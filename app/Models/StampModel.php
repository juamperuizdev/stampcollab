<?php

namespace App\Models;
use CodeIgniter\Model;

class StampModel extends Model {

    protected $table            = 'stamp';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'id_journal',
        'status',
        'number',
        'image',
        'ip',
        'user_agent',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created';

}