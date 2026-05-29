<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramKerjaModel extends Model
{
    protected $table            = 'program_kerja';
    protected $primaryKey       = 'ID_PROKER';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ID_PROKER',
        'ID_PERIODE',
        'ID_DEPARTEMEN',
        'NAMA_PROKER',
        'PENANGGUNG_JAWAB',
        'WAKTU_PELAKSANAAN',
        'STATUS'
    ];
}
