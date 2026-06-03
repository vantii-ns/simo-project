<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $q = $this->request->getGet('q');
        
        if ($q) {
            $anggota = $this->anggotaModel
                ->groupStart()
                    ->like('ID_ANGGOTA', $q)
                    ->orLike('NAMA_ANGGOTA', $q)
                    ->orLike('NO_TELPON', $q)
                    ->orLike('EMAIL', $q)
                ->groupEnd()
                ->findAll();
        } else {
            $anggota = $this->anggotaModel->findAll();
        }

        $data = [
            'title' => 'Kelola Data Anggota',
            'anggota' => $anggota
        ];

        return view('master/anggota/index', $data);
    }

    public function save()
    {
        $this->anggotaModel->insert([
            'ID_ANGGOTA' => $this->request->getPost('ID_ANGGOTA'),
            'NAMA_ANGGOTA' => $this->request->getPost('NAMA_ANGGOTA'),
            'JENIS_KELAMIN' => $this->request->getPost('JENIS_KELAMIN'),
            'ALAMAT' => $this->request->getPost('ALAMAT'),
            'TANGGAL_LAHIR' => $this->request->getPost('TANGGAL_LAHIR'),
            'NO_TELPON' => $this->request->getPost('NO_TELPON'),
            'EMAIL' => $this->request->getPost('EMAIL')
        ]);

        return redirect()->to('/master/anggota')->with('message', 'Data anggota berhasil ditambahkan');
    }

    public function update($id)
    {
        $this->anggotaModel->update($id, [
            'NAMA_ANGGOTA' => $this->request->getPost('NAMA_ANGGOTA'),
            'JENIS_KELAMIN' => $this->request->getPost('JENIS_KELAMIN'),
            'ALAMAT' => $this->request->getPost('ALAMAT'),
            'TANGGAL_LAHIR' => $this->request->getPost('TANGGAL_LAHIR'),
            'NO_TELPON' => $this->request->getPost('NO_TELPON'),
            'EMAIL' => $this->request->getPost('EMAIL')
        ]);

        return redirect()->to('/master/anggota')->with('message', 'Data anggota berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->anggotaModel->delete($id);
            return redirect()->to('/master/anggota')->with('message', 'Data anggota berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/master/anggota')->with('error', 'Gagal menghapus: Data ini masih digunakan di tabel lain (misal: Struktur atau Kepanitiaan).');
        }
    }
}
