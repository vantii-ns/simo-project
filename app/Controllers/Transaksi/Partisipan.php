<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\PartisipanModel;
use App\Models\AnggotaModel;
use App\Models\ProgramKerjaModel;
use App\Models\PeriodeModel;

class Partisipan extends BaseController
{
    protected $partisipanModel;
    protected $anggotaModel;
    protected $prokerModel;
    protected $periodeModel;

    public function __construct()
    {
        $this->partisipanModel = new PartisipanModel();
        $this->anggotaModel = new AnggotaModel();
        $this->prokerModel = new ProgramKerjaModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        $activePeriode = $this->periodeModel->getActivePeriode();

        // Get participants of current active period
        $partisipan = [];
        if ($activePeriode) {
            $partisipan = $this->partisipanModel
                ->select('partisipan.*, anggota.NAMA_ANGGOTA, program_kerja.NAMA_PROKER')
                ->join('anggota', 'anggota.ID_ANGGOTA = partisipan.ID_ANGGOTA')
                ->join('program_kerja', 'program_kerja.ID_PROKER = partisipan.ID_PROKER')
                ->where('program_kerja.ID_PERIODE', $activePeriode['ID_PERIODE'])
                ->findAll();
        }

        // Get all proker for the active period for the dropdown
        $proker = [];
        if ($activePeriode) {
            $proker = $this->prokerModel
                ->where('ID_PERIODE', $activePeriode['ID_PERIODE'])
                ->findAll();
        }

        $data = [
            'title' => 'Partisipan Program Kerja',
            'activePeriode' => $activePeriode,
            'partisipan' => $partisipan,
            'proker' => $proker,
            'anggota' => $this->anggotaModel->findAll()
        ];

        return view('transaksi/partisipan/index', $data);
    }

    public function save()
    {
        $id_proker = $this->request->getPost('ID_PROKER');
        
        $this->partisipanModel->insert([
            'ID_ANGGOTA' => $this->request->getPost('ID_ANGGOTA'),
            'ID_PROKER' => $id_proker,
            'ID_PARTISIPASI' => $this->partisipanModel->generateId(),
            'PERAN_PADA_PROKER' => $this->request->getPost('PERAN_PADA_PROKER')
        ]);

        return redirect()->to('/transaksi/partisipan')->with('message', 'Partisipan berhasil ditambahkan');
    }

    public function update($id)
    {
        $this->partisipanModel->where('ID_PARTISIPASI', $id)->set([
            'ID_ANGGOTA' => $this->request->getPost('ID_ANGGOTA'),
            'ID_PROKER' => $this->request->getPost('ID_PROKER'),
            'PERAN_PADA_PROKER' => $this->request->getPost('PERAN_PADA_PROKER')
        ])->update();

        return redirect()->to('/transaksi/partisipan')->with('message', 'Partisipan berhasil diubah');
    }

    public function delete($id_partisipasi)
    {
        $this->partisipanModel->where('ID_PARTISIPASI', $id_partisipasi)->delete();
        return redirect()->to('/transaksi/partisipan')->with('message', 'Partisipan berhasil dihapus');
    }
}
