<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');

        // Clear tables to prevent duplicate keys
        $this->db->table('partisipan')->truncate();
        $this->db->table('struktur_kepengurusan')->truncate();
        $this->db->table('program_kerja')->truncate();
        $this->db->table('anggota')->truncate();
        $this->db->table('periode')->truncate();
        $this->db->table('departemen')->truncate();
        $this->db->table('jabatan')->truncate();

        // Enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        // 1. Insert Period
        $periode = [
            [
                'ID_PERIODE'    => 'P25',
                'TAHUN_MULAI'   => 2025,
                'TAHUN_SELESAI' => 2026,
                'STATUS_AKTIF'  => 1
            ],
            [
                'ID_PERIODE'    => 'P24',
                'TAHUN_MULAI'   => 2024,
                'TAHUN_SELESAI' => 2025,
                'STATUS_AKTIF'  => 0
            ]
        ];
        $this->db->table('periode')->insertBatch($periode);

        // 2. Insert Departments
        $departemen = [
            ['ID_DEPARTEMEN' => 'BPI', 'NAMA_DEPARTEMEN' => 'BPI'],
            ['ID_DEPARTEMEN' => 'AUD', 'NAMA_DEPARTEMEN' => 'AUDIT'],
            ['ID_DEPARTEMEN' => 'HMS', 'NAMA_DEPARTEMEN' => 'HUMAS'],
            ['ID_DEPARTEMEN' => 'MSD', 'NAMA_DEPARTEMEN' => 'MSDM'],
            ['ID_DEPARTEMEN' => 'KMF', 'NAMA_DEPARTEMEN' => 'KOMINFO'],
            ['ID_DEPARTEMEN' => 'PB',  'NAMA_DEPARTEMEN' => 'PB'],
            ['ID_DEPARTEMEN' => 'KKI', 'NAMA_DEPARTEMEN' => 'KKI'],
            ['ID_DEPARTEMEN' => 'PMD', 'NAMA_DEPARTEMEN' => 'PMDB'],
            ['ID_DEPARTEMEN' => 'PA',  'NAMA_DEPARTEMEN' => 'PA']
        ];
        $this->db->table('departemen')->insertBatch($departemen);

        // 3. Insert Positions
        $jabatan = [
            ['ID_JABATAN' => '01', 'NAMA_JABATAN' => 'Ketua'],
            ['ID_JABATAN' => '02', 'NAMA_JABATAN' => 'Wakil Ketua'],
            ['ID_JABATAN' => '03', 'NAMA_JABATAN' => 'Sekretaris I'],
            ['ID_JABATAN' => '04', 'NAMA_JABATAN' => 'Sekretaris II'],
            ['ID_JABATAN' => '05', 'NAMA_JABATAN' => 'Bendahara I'],
            ['ID_JABATAN' => '06', 'NAMA_JABATAN' => 'Bendahara II'],
            ['ID_JABATAN' => '07', 'NAMA_JABATAN' => 'Bendahara III'],
            ['ID_JABATAN' => '08', 'NAMA_JABATAN' => 'Kepala Departemen (Kadep)'],
            ['ID_JABATAN' => '09', 'NAMA_JABATAN' => 'Staff Departemen'],
            ['ID_JABATAN' => '10', 'NAMA_JABATAN' => 'Audit Internal']
        ];
        $this->db->table('jabatan')->insertBatch($jabatan);

        // 4. Insert Members (72 members from screenshots)
        $rawMembers = [
            // BPI
            ['name' => 'Hibban Aulia Mubarak', 'gender' => 'L', 'dept' => 'BPI', 'pos' => '01'],
            ['name' => 'Fadli Ramadhan Kartosuharjo', 'gender' => 'L', 'dept' => 'BPI', 'pos' => '02'],
            ['name' => 'Faiq', 'gender' => 'L', 'dept' => 'BPI', 'pos' => '03'],
            ['name' => 'Alifatuz Zubaidah', 'gender' => 'P', 'dept' => 'BPI', 'pos' => '04'],
            ['name' => 'Alvira Dwi Febriani', 'gender' => 'P', 'dept' => 'BPI', 'pos' => '05'],
            ['name' => 'Cindy Putri Andjani', 'gender' => 'P', 'dept' => 'BPI', 'pos' => '06'],
            ['name' => 'Vanti Nur Sholehah', 'gender' => 'P', 'dept' => 'BPI', 'pos' => '07'],
            
            // HUMAS
            ['name' => 'Gita Nabila Putri Bahri', 'gender' => 'P', 'dept' => 'HMS', 'pos' => '08'],
            ['name' => 'Ananda Ayu Kartika Sari', 'gender' => 'P', 'dept' => 'HMS', 'pos' => '09'],
            ['name' => 'Ima Dwi Rahmania', 'gender' => 'P', 'dept' => 'HMS', 'pos' => '09'],
            ['name' => 'Ammar Arifin', 'gender' => 'L', 'dept' => 'HMS', 'pos' => '09'],
            ['name' => 'Fitrotun Nisak', 'gender' => 'P', 'dept' => 'HMS', 'pos' => '09'],
            ['name' => 'Edinda Ayunisa Rahma', 'gender' => 'P', 'dept' => 'HMS', 'pos' => '09'],
            ['name' => 'Rayhan Akmal Azhari', 'gender' => 'L', 'dept' => 'HMS', 'pos' => '09'],
            ['name' => 'M. Brillyan Arzaq Al-habsyi', 'gender' => 'L', 'dept' => 'HMS', 'pos' => '09'],
            
            // KKI
            ['name' => 'Muhammad Ramadhan', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '08'],
            ['name' => 'Muadz Mufti Musyafa', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '09'],
            ['name' => 'Eriska Cahya Ramadhani', 'gender' => 'P', 'dept' => 'KKI', 'pos' => '09'],
            ['name' => 'Muhammad Yusuf Multazam', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '09'],
            ['name' => 'Ikta Kirani Bilqis Syifa\'ul L.', 'gender' => 'P', 'dept' => 'KKI', 'pos' => '09'],
            ['name' => 'M. Acha Ikhwanussofa', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '09'],
            ['name' => 'Rafli Hossam Athaillah', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '09'],
            ['name' => 'Rahman Hakim', 'gender' => 'L', 'dept' => 'KKI', 'pos' => '09'],
            
            // KOMINFO
            ['name' => 'Titha Auliya Khotim', 'gender' => 'P', 'dept' => 'KMF', 'pos' => '08'],
            ['name' => 'Safi i', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'M. Fadlullah Nuri Zam Zami', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'Mokh. Faisol Nahdah M.', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'Abi Salam Anshorulloh', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'Ahmad Maulana Asyrafi', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'Alfarisi', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'Ervido Suminarhadi', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'Rafifah Talitha Syahla', 'gender' => 'P', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'M. Taufiq Qurrahman', 'gender' => 'L', 'dept' => 'KMF', 'pos' => '09'],
            ['name' => 'Faradita Nuraini', 'gender' => 'P', 'dept' => 'KMF', 'pos' => '09'],
            
            // MSDM
            ['name' => 'Shofie Fadliya Rahma', 'gender' => 'P', 'dept' => 'MSD', 'pos' => '08'],
            ['name' => 'Eva Amilia', 'gender' => 'P', 'dept' => 'MSD', 'pos' => '09'],
            ['name' => 'Nizam Al-Habsyi', 'gender' => 'L', 'dept' => 'MSD', 'pos' => '09'],
            ['name' => 'Husain Asrarillah', 'gender' => 'L', 'dept' => 'MSD', 'pos' => '09'],
            ['name' => 'Ali Rohmat', 'gender' => 'L', 'dept' => 'MSD', 'pos' => '09'],
            ['name' => 'Ahmad Faiq Dzikry', 'gender' => 'L', 'dept' => 'MSD', 'pos' => '09'],
            ['name' => 'Balqis Zuhruf Muttaqin', 'gender' => 'P', 'dept' => 'MSD', 'pos' => '09'],
            ['name' => 'Lia Mesya Rahmadiani', 'gender' => 'P', 'dept' => 'MSD', 'pos' => '09'],
            ['name' => 'Rizki Ridhwan Arif S.', 'gender' => 'L', 'dept' => 'MSD', 'pos' => '09'],
            
            // PA
            ['name' => 'Nadiya Putri Intan Nur R.', 'gender' => 'P', 'dept' => 'PA', 'pos' => '08'],
            ['name' => 'Faizah Aulia Firdaus', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Frisilia Vina Ariyanto', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Yudistian Dzaky Yassar', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Ahmad Khoirur Rohman', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Ismi Septia Utami', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Luthfi Kurnia Hadi', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Nazwa Dwi Rizkya', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Sufyan Abror', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            
            // PB
            ['name' => 'Mufti Mubarok Khoiriansyah', 'gender' => 'L', 'dept' => 'PB', 'pos' => '08'],
            ['name' => 'Audina Ni\'matul Firdaus', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Muhammad Irfan Permana', 'gender' => 'L', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Riyana Isti Juwariyah', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Naurah Maulidah', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Nayla An Nasywa', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Novan Musyafatoni', 'gender' => 'L', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Aflah Mahdi Yazdi', 'gender' => 'L', 'dept' => 'PB', 'pos' => '09'],
            
            // PMDB
            ['name' => 'Salimatuz Zahwah', 'gender' => 'P', 'dept' => 'PMD', 'pos' => '08'],
            ['name' => 'Ahmad Baihaqi Hasibullah', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['name' => 'Haris sandy Setiawan', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['name' => 'Hakim Nizam', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['name' => 'Muhamad Rangga Pratama P.', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['name' => 'Nazril Febry Fadli', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['name' => 'Putra Mahardhika Surasa', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['name' => 'Rajib Faiq Musyaddad', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            ['name' => 'Tio Putra Sidarta', 'gender' => 'L', 'dept' => 'PMD', 'pos' => '09'],
            
            // AUDIT
            ['name' => 'Hilwa Ainindhiska Aisyah', 'gender' => 'P', 'dept' => 'AUD', 'pos' => '10'],
            ['name' => 'Zahwa Neida Yasmin', 'gender' => 'P', 'dept' => 'AUD', 'pos' => '10'],
            ['name' => 'Resti Kamilah Ghoyati', 'gender' => 'P', 'dept' => 'AUD', 'pos' => '10'],
        ];

        $anggota = [];
        $struktur = [];
        $i = 1;
        foreach ($rawMembers as $m) {
            $idAnggota = sprintf("A%05d", $i);
            $idStruktur = sprintf("SK%06d", $i);
            
            $nameClean = strtolower(preg_replace('/[^a-zA-Z]/', '', $m['name']));
            $email = $nameClean . "@gmail.com";
            
            $anggota[] = [
                'ID_ANGGOTA'    => $idAnggota,
                'NAMA_ANGGOTA'  => $m['name'],
                'JENIS_KELAMIN' => $m['gender'],
                'ALAMAT'        => 'Jl. Informatika Raya No. ' . ($i * 3),
                'TANGGAL_LAHIR' => '2004-' . sprintf("%02d", (($i % 12) + 1)) . '-' . sprintf("%02d", (($i % 28) + 1)),
                'NO_TELPON'     => '08' . sprintf("%010d", 1234567890 + $i),
                'EMAIL'         => $email
            ];
            
            $struktur[] = [
                'ID_STRUKTUR'   => $idStruktur,
                'ID_ANGGOTA'    => $idAnggota,
                'ID_DEPARTEMEN' => $m['dept'],
                'ID_JABATAN'    => $m['pos'],
                'ID_PERIODE'    => 'P25'
            ];
            
            $i++;
        }
        $this->db->table('anggota')->insertBatch($anggota);

        // 5. Insert Program Kerja
        $proker = [
            [
                'ID_PROKER'         => 'PK001',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'MSD',
                'NAMA_PROKER'       => 'Pelatihan Kepemimpinan Organisasi (PKO)',
                'WAKTU_PELAKSANAAN' => 'Maret 2025'
            ],
            [
                'ID_PROKER'         => 'PK002',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'MSD',
                'NAMA_PROKER'       => 'Upgrading & Gathering Pengurus',
                'WAKTU_PELAKSANAAN' => 'April 2025'
            ],
            [
                'ID_PROKER'         => 'PK003',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'KKI',
                'NAMA_PROKER'       => 'Seminar Teknologi & Pendidikan Kreatif',
                'WAKTU_PELAKSANAAN' => 'Mei 2025'
            ],
            [
                'ID_PROKER'         => 'PK004',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'KMF',
                'NAMA_PROKER'       => 'Workshop Web Development & UI/UX Design',
                'WAKTU_PELAKSANAAN' => 'Juni 2025'
            ],
            [
                'ID_PROKER'         => 'PK005',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'HMS',
                'NAMA_PROKER'       => 'Kunjungan Industri & Studi Banding Himpunan',
                'WAKTU_PELAKSANAAN' => 'Juli 2025'
            ],
            [
                'ID_PROKER'         => 'PK006',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'PB',
                'NAMA_PROKER'       => 'Bazar Kewirausahaan & Ekonomi Kreatif',
                'WAKTU_PELAKSANAAN' => 'Agustus 2025'
            ],
            [
                'ID_PROKER'         => 'PK007',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'PMD',
                'NAMA_PROKER'       => 'Informatics Esports League & Talent Show',
                'WAKTU_PELAKSANAAN' => 'September 2025'
            ],
            [
                'ID_PROKER'         => 'PK008',
                'ID_PERIODE'        => 'P25',
                'ID_DEPARTEMEN'     => 'PA',
                'NAMA_PROKER'       => 'HIMAPROSIF Peduli & Pengabdian Masyarakat',
                'WAKTU_PELAKSANAAN' => 'Oktober 2025'
            ]
        ];
        $this->db->table('program_kerja')->insertBatch($proker);

        // 6. Insert Struktur Kepengurusan
        $this->db->table('struktur_kepengurusan')->insertBatch($struktur);

        echo "Database successfully populated with modern demo data!\n";
    }
}
