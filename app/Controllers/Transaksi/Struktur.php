<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\StrukturKepengurusanModel;
use App\Models\AnggotaModel;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;
use App\Models\PeriodeModel;

class Struktur extends BaseController
{
    protected $strukturModel;
    protected $anggotaModel;
    protected $departemenModel;
    protected $jabatanModel;
    protected $periodeModel;

    public function __construct()
    {
        $this->strukturModel = new StrukturKepengurusanModel();
        $this->anggotaModel = new AnggotaModel();
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        $activePeriode = $this->periodeModel->getActivePeriode();

        $data = [
            'title' => 'Susunan Kepengurusan',
            'activePeriode' => $activePeriode,
            'struktur' => $activePeriode ? $this->strukturModel->getStrukturWithDetails($activePeriode['ID_PERIODE']) : [],
            'anggota' => $this->anggotaModel->findAll(),
            'departemen' => $this->departemenModel->findAll(),
            'jabatan' => $this->jabatanModel->findAll(),
        ];

        return view('transaksi/struktur/index', $data);
    }

    // AJAX Endpoint
    public function save()
    {
        $activePeriode = $this->periodeModel->getActivePeriode();
        if (!$activePeriode) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada periode aktif']);
        }

        $id_anggota = $this->request->getPost('ID_ANGGOTA');
        $id_departemen = $this->request->getPost('ID_DEPARTEMEN');
        $id_jabatan = $this->request->getPost('ID_JABATAN');
        
        $id_struktur = substr(uniqid('S'), 0, 8); // Generate 8 char ID

        try {
            $this->strukturModel->insert([
                'ID_STRUKTUR' => $id_struktur,
                'ID_ANGGOTA' => $id_anggota,
                'ID_DEPARTEMEN' => $id_departemen,
                'ID_JABATAN' => $id_jabatan,
                'ID_PERIODE' => $activePeriode['ID_PERIODE']
            ]);
            
            // Get the details back for dynamic row
            $anggota = $this->anggotaModel->find($id_anggota);
            $departemen = $this->departemenModel->find($id_departemen);
            $jabatan = $this->jabatanModel->find($id_jabatan);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Anggota berhasil diplot',
                'data' => [
                    'ID_STRUKTUR' => $id_struktur,
                    'NAMA_ANGGOTA' => $anggota['NAMA_ANGGOTA'],
                    'NAMA_DEPARTEMEN' => $departemen['NAMA_DEPARTEMEN'],
                    'NAMA_JABATAN' => $jabatan['NAMA_JABATAN']
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update($id)
    {
        $this->strukturModel->update($id, [
            'ID_ANGGOTA' => $this->request->getPost('ID_ANGGOTA'),
            'ID_DEPARTEMEN' => $this->request->getPost('ID_DEPARTEMEN'),
            'ID_JABATAN' => $this->request->getPost('ID_JABATAN')
        ]);

        return redirect()->to('/transaksi/struktur')->with('message', 'Posisi anggota berhasil diubah');
    }

    public function delete($id)
    {
        $this->strukturModel->delete($id);
        return redirect()->to('/transaksi/struktur')->with('message', 'Data berhasil dihapus');
    }
}
