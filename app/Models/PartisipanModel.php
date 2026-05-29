<?php

namespace App\Models;

use CodeIgniter\Model;

class PartisipanModel extends Model
{
    protected $table            = 'partisipan';
    // Partisipan has composite primary key (ID_ANGGOTA, ID_PROKER, ID_PARTISIPASI).
    // CI4 Model doesn't fully support composite PKs in all its magic methods.
    // We will use standard Query Builder methods for complex operations.
    protected $primaryKey       = 'ID_PARTISIPASI'; // Just picking one to avoid errors, we'll mostly use custom queries
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ID_ANGGOTA',
        'ID_PROKER',
        'ID_PARTISIPASI',
        'PERAN_PADA_PROKER'
    ];

    public function generateId()
    {
        $last = $this->orderBy('ID_PARTISIPASI', 'DESC')->first();
        if (!$last) {
            return 'P001';
        }
        $lastId = $last['ID_PARTISIPASI'];
        $num = (int)substr($lastId, 1);
        return 'P' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
    }
}
