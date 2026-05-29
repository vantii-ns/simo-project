<?php

namespace App\Models;

use CodeIgniter\Model;

class StrukturKepengurusanModel extends Model
{
    protected $table            = 'struktur_kepengurusan';
    protected $primaryKey       = 'ID_STRUKTUR';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ID_STRUKTUR',
        'ID_ANGGOTA',
        'ID_DEPARTEMEN',
        'ID_JABATAN',
        'ID_PERIODE'
    ];

    public function getStrukturWithDetails($id_periode = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('struktur_kepengurusan.*, anggota.NAMA_ANGGOTA, departemen.NAMA_DEPARTEMEN, jabatan.NAMA_JABATAN');
        $builder->join('anggota', 'anggota.ID_ANGGOTA = struktur_kepengurusan.ID_ANGGOTA');
        $builder->join('departemen', 'departemen.ID_DEPARTEMEN = struktur_kepengurusan.ID_DEPARTEMEN');
        $builder->join('jabatan', 'jabatan.ID_JABATAN = struktur_kepengurusan.ID_JABATAN');
        
        if ($id_periode) {
            $builder->where('struktur_kepengurusan.ID_PERIODE', $id_periode);
        }
        
        return $builder->get()->getResultArray();
    }
}
