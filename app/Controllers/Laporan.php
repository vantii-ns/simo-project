<?php

namespace App\Controllers;

use App\Models\StrukturKepengurusanModel;
use App\Models\ProgramKerjaModel;
use App\Models\AnggotaModel;
use App\Models\PartisipanModel;
use App\Models\PeriodeModel;

class Laporan extends BaseController
{
    protected $strukturModel;
    protected $prokerModel;
    protected $anggotaModel;
    protected $partisipanModel;
    protected $periodeModel;

    public function __construct()
    {
        $this->strukturModel = new StrukturKepengurusanModel();
        $this->prokerModel = new ProgramKerjaModel();
        $this->anggotaModel = new AnggotaModel();
        $this->partisipanModel = new PartisipanModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dokumen Laporan',
            'anggota' => $this->anggotaModel->findAll()
        ];
        return view('laporan/index', $data);
    }

    public function sk()
    {
        $activePeriode = $this->periodeModel->getActivePeriode();
        if (!$activePeriode) {
            return redirect()->to('/laporan')->with('message', 'Tidak ada periode aktif untuk dicetak.');
        }

        $struktur = $this->strukturModel->getStrukturWithDetails($activePeriode['ID_PERIODE']);

        // Kelompokkan per departemen untuk SK
        $strukturPerDept = [];
        foreach ($struktur as $s) {
            $strukturPerDept[$s['NAMA_DEPARTEMEN']][] = $s;
        }

        $data = [
            'periode' => $activePeriode,
            'strukturPerDept' => $strukturPerDept,
            'title' => 'SK Kepengurusan'
        ];

        return view('laporan/sk', $data);
    }

    public function katalog()
    {
        $activePeriode = $this->periodeModel->getActivePeriode();
        if (!$activePeriode) {
            return redirect()->to('/laporan')->with('message', 'Tidak ada periode aktif untuk dicetak.');
        }

        $proker = $this->prokerModel
            ->select('program_kerja.*, departemen.NAMA_DEPARTEMEN')
            ->join('departemen', 'departemen.ID_DEPARTEMEN = program_kerja.ID_DEPARTEMEN')
            ->where('program_kerja.ID_PERIODE', $activePeriode['ID_PERIODE'])
            ->findAll();

        $data = [
            'periode' => $activePeriode,
            'proker' => $proker,
            'title' => 'Katalog Program Kerja'
        ];

        return view('laporan/katalog', $data);
    }

    public function rapor()
    {
        $id_anggota = $this->request->getPost('ID_ANGGOTA');
        if (!$id_anggota) {
            return redirect()->to('/laporan');
        }

        $anggota = $this->anggotaModel->find($id_anggota);

        // Riwayat Jabatan
        $riwayatJabatan = $this->strukturModel
            ->select('struktur_kepengurusan.*, jabatan.NAMA_JABATAN, departemen.NAMA_DEPARTEMEN, periode.TAHUN_MULAI, periode.TAHUN_SELESAI')
            ->join('jabatan', 'jabatan.ID_JABATAN = struktur_kepengurusan.ID_JABATAN')
            ->join('departemen', 'departemen.ID_DEPARTEMEN = struktur_kepengurusan.ID_DEPARTEMEN')
            ->join('periode', 'periode.ID_PERIODE = struktur_kepengurusan.ID_PERIODE')
            ->where('ID_ANGGOTA', $id_anggota)
            ->orderBy('periode.TAHUN_MULAI', 'DESC')
            ->findAll();

        // Riwayat Kepanitiaan/Proker
        $riwayatKepanitiaan = $this->partisipanModel
            ->select('partisipan.*, program_kerja.NAMA_PROKER, program_kerja.WAKTU_PELAKSANAAN, periode.TAHUN_MULAI, periode.TAHUN_SELESAI')
            ->join('program_kerja', 'program_kerja.ID_PROKER = partisipan.ID_PROKER')
            ->join('periode', 'periode.ID_PERIODE = program_kerja.ID_PERIODE')
            ->where('partisipan.ID_ANGGOTA', $id_anggota)
            ->orderBy('periode.TAHUN_MULAI', 'DESC')
            ->findAll();

        $data = [
            'anggota' => $anggota,
            'riwayatJabatan' => $riwayatJabatan,
            'riwayatKepanitiaan' => $riwayatKepanitiaan,
            'title' => 'Track Record Anggota'
        ];

        return view('laporan/rapor', $data);
    }
}
