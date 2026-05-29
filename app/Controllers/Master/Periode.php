<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\PeriodeModel;

class Periode extends BaseController
{
    protected $periodeModel;

    public function __construct()
    {
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Data Periode',
            'periode' => $this->periodeModel->findAll()
        ];

        return view('master/periode/index', $data);
    }

    public function save()
    {
        $this->periodeModel->insert([
            'ID_PERIODE' => $this->request->getPost('ID_PERIODE'),
            'TAHUN_MULAI' => $this->request->getPost('TAHUN_MULAI'),
            'TAHUN_SELESAI' => $this->request->getPost('TAHUN_SELESAI'),
            'STATUS_AKTIF' => 0 // default 0 when created
        ]);

        return redirect()->to('/master/periode')->with('message', 'Data berhasil ditambahkan');
    }

    public function delete($id)
    {
        try {
            $this->periodeModel->delete($id);
            return redirect()->to('/master/periode')->with('message', 'Data periode berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/master/periode')->with('error', 'Gagal menghapus: Periode ini masih digunakan di tabel lain.');
        }
    }

    public function update($id)
    {
        $this->periodeModel->update($id, [
            'TAHUN_MULAI' => $this->request->getPost('TAHUN_MULAI'),
            'TAHUN_SELESAI' => $this->request->getPost('TAHUN_SELESAI')
        ]);

        return redirect()->to('/master/periode')->with('message', 'Data berhasil diubah');
    }

    public function set_active($id)
    {
        $this->periodeModel->setActivePeriode($id);
        return redirect()->to('/master/periode')->with('message', 'Status periode berhasil diubah menjadi aktif');
    }
}
