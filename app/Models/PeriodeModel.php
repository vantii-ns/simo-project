<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeModel extends Model
{
    protected $table            = 'periode';
    protected $primaryKey       = 'ID_PERIODE';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ID_PERIODE',
        'TAHUN_MULAI',
        'TAHUN_SELESAI',
        'STATUS_AKTIF'
    ];

    public function getActivePeriode()
    {
        return $this->where('STATUS_AKTIF', 1)->first();
    }

    public function setActivePeriode($id_periode)
    {
        // Set all to 0
        $this->db->table($this->table)->update(['STATUS_AKTIF' => 0]);
        // Set the chosen one to 1
        $this->update($id_periode, ['STATUS_AKTIF' => 1]);
    }
}
