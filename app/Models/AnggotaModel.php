<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'ID_ANGGOTA';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ID_ANGGOTA',
        'NAMA_ANGGOTA',
        'JENIS_KELAMIN',
        'ALAMAT',
        'TANGGAL_LAHIR',
        'NO_TELPON',
        'EMAIL'
    ];
}
