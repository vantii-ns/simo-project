<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table            = 'departemen';
    protected $primaryKey       = 'ID_DEPARTEMEN';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ID_DEPARTEMEN',
        'NAMA_DEPARTEMEN'
    ];
}
