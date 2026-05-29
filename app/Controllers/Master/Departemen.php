<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\DepartemenModel;

class Departemen extends BaseController
{
    protected $departemenModel;

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Data Departemen',
            'departemen' => $this->departemenModel->findAll()
        ];

        return view('master/departemen/index', $data);
    }

    public function save()
    {
        $this->departemenModel->insert([
            'ID_DEPARTEMEN' => $this->request->getPost('ID_DEPARTEMEN'),
            'NAMA_DEPARTEMEN' => $this->request->getPost('NAMA_DEPARTEMEN')
        ]);

        return redirect()->to('/master/departemen')->with('message', 'Data departemen berhasil ditambahkan');
    }

    public function update($id)
    {
        $this->departemenModel->update($id, [
            'NAMA_DEPARTEMEN' => $this->request->getPost('NAMA_DEPARTEMEN')
        ]);

        return redirect()->to('/master/departemen')->with('message', 'Data departemen berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->departemenModel->delete($id);
            return redirect()->to('/master/departemen')->with('message', 'Departemen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/master/departemen')->with('error', 'Gagal menghapus: Departemen ini masih digunakan di tabel lain.');
        }
    }
}
