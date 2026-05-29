<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PatchRedMembersSeeder extends Seeder
{
    public function run()
    {
        $rawMembers = [
            ['id' => 17, 'name' => 'Muadz Mufti Musyafa', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '09'],
            ['id' => 18, 'name' => 'Eriska Cahya Ramadhani', 'gender' => 'P', 'dept' => 'KKI', 'pos' => '09'],
            ['id' => 21, 'name' => 'M. Acha Ikhwanussofa', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '09'],
            ['id' => 63, 'name' => 'Haris sandy Setiawan', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['id' => 65, 'name' => 'Muhamad Rangga Pratama P.', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['id' => 66, 'name' => 'Nazril Febry Fadli', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
        ];

        $anggotaBuilder = $this->db->table('anggota');
        $strukturBuilder = $this->db->table('struktur_kepengurusan');

        $anggotaInsert = [];
        $strukturInsert = [];

        foreach ($rawMembers as $m) {
            $i = $m['id'];
            $idAnggota = sprintf("A%05d", $i);
            $idStruktur = sprintf("SK%06d", $i);
            
            // Cek apakah sudah ada
            $existing = $anggotaBuilder->where('ID_ANGGOTA', $idAnggota)->get()->getRow();
            if (!$existing) {
                $nameClean = strtolower(preg_replace('/[^a-zA-Z]/', '', $m['name']));
                $email = $nameClean . "@gmail.com";
                
                $anggotaInsert[] = [
                    'ID_ANGGOTA'    => $idAnggota,
                    'NAMA_ANGGOTA'  => $m['name'],
                    'JENIS_KELAMIN' => $m['gender'],
                    'ALAMAT'        => 'Jl. Informatika Raya No. ' . ($i * 3),
                    'TANGGAL_LAHIR' => '2004-' . sprintf("%02d", (($i % 12) + 1)) . '-' . sprintf("%02d", (($i % 28) + 1)),
                    'NO_TELPON'     => '08' . sprintf("%010d", 1234567890 + $i),
                    'EMAIL'         => $email
                ];
                
                $strukturInsert[] = [
                    'ID_STRUKTUR'   => $idStruktur,
                    'ID_ANGGOTA'    => $idAnggota,
                    'ID_DEPARTEMEN' => $m['dept'],
                    'ID_JABATAN'    => $m['pos'],
                    'ID_PERIODE'    => 'P25'
                ];
            }
        }

        if (!empty($anggotaInsert)) {
            $anggotaBuilder->insertBatch($anggotaInsert);
            $strukturBuilder->insertBatch($strukturInsert);
            echo count($anggotaInsert) . " anggota baru (berwarna merah) berhasil ditambahkan.\n";
        } else {
            echo "Data anggota sudah ada di database.\n";
        }
    }
}
