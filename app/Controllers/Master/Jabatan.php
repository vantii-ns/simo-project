<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\JabatanModel;

class Jabatan extends BaseController
{
    protected $jabatanModel;

    public function __construct()
    {
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Data Jabatan',
            'jabatan' => $this->jabatanModel->findAll()
        ];

        return view('master/jabatan/index', $data);
    }

    public function save()
    {
        $this->jabatanModel->insert([
            'ID_JABATAN' => $this->request->getPost('ID_JABATAN'),
            'NAMA_JABATAN' => $this->request->getPost('NAMA_JABATAN')
        ]);

        return redirect()->to('/master/jabatan')->with('message', 'Data jabatan berhasil ditambahkan');
    }

    public function update($id)
    {
        $this->jabatanModel->update($id, [
            'NAMA_JABATAN' => $this->request->getPost('NAMA_JABATAN')
        ]);

        return redirect()->to('/master/jabatan')->with('message', 'Data jabatan berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->jabatanModel->delete($id);
            return redirect()->to('/master/jabatan')->with('message', 'Data jabatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/master/jabatan')->with('error', 'Gagal menghapus: Jabatan ini masih digunakan di tabel lain.');
        }
    }
}
