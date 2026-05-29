<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\ProgramKerjaModel;
use App\Models\DepartemenModel;
use App\Models\PeriodeModel;
use App\Models\PartisipanModel;
use App\Models\AnggotaModel;

class Proker extends BaseController
{
    protected $prokerModel;
    protected $departemenModel;
    protected $periodeModel;
    protected $partisipanModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->prokerModel = new ProgramKerjaModel();
        $this->departemenModel = new DepartemenModel();
        $this->periodeModel = new PeriodeModel();
        $this->partisipanModel = new PartisipanModel();
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $activePeriode = $this->periodeModel->getActivePeriode();

        // Get Proker with Departemen details
        $proker = [];
        if ($activePeriode) {
            $proker = $this->prokerModel
                ->select('program_kerja.*, departemen.NAMA_DEPARTEMEN')
                ->join('departemen', 'departemen.ID_DEPARTEMEN = program_kerja.ID_DEPARTEMEN')
                ->where('program_kerja.ID_PERIODE', $activePeriode['ID_PERIODE'])
                ->findAll();
        }

        $data = [
            'title' => 'Program Kerja',
            'activePeriode' => $activePeriode,
            'proker' => $proker,
            'departemen' => $this->departemenModel->findAll()
        ];

        return view('transaksi/proker/index', $data);
    }

    public function save()
    {
        $activePeriode = $this->periodeModel->getActivePeriode();
        if (!$activePeriode) {
            return redirect()->to('/transaksi/proker')->with('message', 'Gagal: Tidak ada periode aktif.');
        }

        $this->prokerModel->insert([
            'ID_PROKER' => $this->request->getPost('ID_PROKER'),
            'ID_PERIODE' => $activePeriode['ID_PERIODE'],
            'ID_DEPARTEMEN' => $this->request->getPost('ID_DEPARTEMEN'),
            'NAMA_PROKER' => $this->request->getPost('NAMA_PROKER'),
            'PENANGGUNG_JAWAB' => $this->request->getPost('PENANGGUNG_JAWAB'),
            'WAKTU_PELAKSANAAN' => $this->request->getPost('WAKTU_PELAKSANAAN'),
            'STATUS' => $this->request->getPost('STATUS') ?: 'Belum Terlaksana'
        ]);

        return redirect()->to('/transaksi/proker')->with('message', 'Program Kerja berhasil ditambahkan');
    }

    public function update($id)
    {
        $this->prokerModel->update($id, [
            'ID_DEPARTEMEN' => $this->request->getPost('ID_DEPARTEMEN'),
            'NAMA_PROKER' => $this->request->getPost('NAMA_PROKER'),
            'PENANGGUNG_JAWAB' => $this->request->getPost('PENANGGUNG_JAWAB'),
            'WAKTU_PELAKSANAAN' => $this->request->getPost('WAKTU_PELAKSANAAN'),
            'STATUS' => $this->request->getPost('STATUS') ?: 'Belum Terlaksana'
        ]);

        return redirect()->to('/transaksi/proker')->with('message', 'Program Kerja berhasil diubah');
    }

    public function delete($id)
    {
        // Delete related partisipan first to maintain constraints
        $this->partisipanModel->where('ID_PROKER', $id)->delete();
        $this->prokerModel->delete($id);
        
        return redirect()->to('/transaksi/proker')->with('message', 'Program Kerja berhasil dihapus');
    }

    public function detail($id_proker)
    {
        $proker = $this->prokerModel
            ->select('program_kerja.*, departemen.NAMA_DEPARTEMEN')
            ->join('departemen', 'departemen.ID_DEPARTEMEN = program_kerja.ID_DEPARTEMEN')
            ->where('ID_PROKER', $id_proker)
            ->first();

        if (!$proker) {
            return redirect()->to('/transaksi/proker');
        }

        $partisipan = $this->partisipanModel
            ->select('partisipan.*, anggota.NAMA_ANGGOTA')
            ->join('anggota', 'anggota.ID_ANGGOTA = partisipan.ID_ANGGOTA')
            ->where('ID_PROKER', $id_proker)
            ->findAll();

        $data = [
            'title' => 'Detail Proker: ' . $proker['NAMA_PROKER'],
            'proker' => $proker,
            'partisipan' => $partisipan,
            'anggota' => $this->anggotaModel->findAll()
        ];

        return view('transaksi/proker/detail', $data);
    }

    public function save_partisipan()
    {
        $id_proker = $this->request->getPost('ID_PROKER');
        
        $this->partisipanModel->insert([
            'ID_ANGGOTA' => $this->request->getPost('ID_ANGGOTA'),
            'ID_PROKER' => $id_proker,
            'ID_PARTISIPASI' => $this->partisipanModel->generateId(),
            'PERAN_PADA_PROKER' => $this->request->getPost('PERAN_PADA_PROKER')
        ]);

        return redirect()->to('/transaksi/proker/detail/' . $id_proker)->with('message', 'Partisipan berhasil ditambahkan');
    }

    public function delete_partisipan($id_partisipasi, $id_proker)
    {
        $this->partisipanModel->where('ID_PARTISIPASI', $id_partisipasi)->delete();
        return redirect()->to('/transaksi/proker/detail/' . $id_proker)->with('message', 'Partisipan berhasil dihapus');
    }
}
