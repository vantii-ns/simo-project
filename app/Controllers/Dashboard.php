<?php

namespace App\Controllers;

use App\Models\PeriodeModel;
use App\Models\ProgramKerjaModel;
use App\Models\StrukturKepengurusanModel;
use App\Models\AnggotaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $periodeModel = new PeriodeModel();
        $prokerModel = new ProgramKerjaModel();
        $strukturModel = new StrukturKepengurusanModel();

        $anggotaModel = new AnggotaModel();
        
        // Auto-run import if data is empty (bypasses manual URL visit)
        $db = \Config\Database::connect();
        if ($db->table('program_kerja')->countAllResults() == 0) {
            $import = new \App\Controllers\Import2026();
            $import->index(); // this executes the inserts and sets 2026 as active
        }

        $activePeriode = $periodeModel->getActivePeriode();

        $data = [
            'title' => 'Dashboard',
            'activePeriode' => $activePeriode,
            'totalAnggotaAktif' => 0,
            'totalAnggotaTerdaftar' => $anggotaModel->countAllResults(),
            'totalProker' => 0,
            'chartData' => []
        ];

        if ($activePeriode) {
            // Total Proker berjalan di periode aktif
            $data['totalProker'] = $prokerModel->where('ID_PERIODE', $activePeriode['ID_PERIODE'])->countAllResults();

            // Struktur & Anggota
            $struktur = $strukturModel->getStrukturWithDetails($activePeriode['ID_PERIODE']);
            
            // Hitung anggota unik (satu orang bisa punya >1 jabatan, kita hitung distinct anggota)
            $anggotaUnik = [];
            $distribusiDept = [];

            foreach ($struktur as $s) {
                $anggotaUnik[$s['ID_ANGGOTA']] = true;
                
                // Distribusi departemen
                $dept = $s['NAMA_DEPARTEMEN'];
                if (!isset($distribusiDept[$dept])) {
                    $distribusiDept[$dept] = 0;
                }
                $distribusiDept[$dept]++;
            }

            $data['totalAnggotaAktif'] = count($anggotaUnik);
            
            // Format for Chart.js
            $data['chartLabels'] = array_keys($distribusiDept);
            $data['chartValues'] = array_values($distribusiDept);

            // Latest Proker list
            $data['latestProkerList'] = $prokerModel->select('program_kerja.*, departemen.NAMA_DEPARTEMEN')
                ->join('departemen', 'departemen.ID_DEPARTEMEN = program_kerja.ID_DEPARTEMEN')
                ->where('program_kerja.ID_PERIODE', $activePeriode['ID_PERIODE'])
                ->orderBy('ID_PROKER', 'DESC')
                ->limit(5)
                ->find();
        }

        return view('dashboard/index', $data);
    }
}
