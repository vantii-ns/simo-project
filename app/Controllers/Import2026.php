<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Import2026 extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Pastikan kolom PENANGGUNG_JAWAB dan STATUS ada di tabel program_kerja
        if (!$db->fieldExists('PENANGGUNG_JAWAB', 'program_kerja')) {
            $db->query("ALTER TABLE program_kerja ADD COLUMN PENANGGUNG_JAWAB VARCHAR(100) NULL");
        }
        if (!$db->fieldExists('STATUS', 'program_kerja')) {
            $db->query("ALTER TABLE program_kerja ADD COLUMN STATUS VARCHAR(20) NOT NULL DEFAULT 'Belum Terlaksana'");
        }
        
        // 1. Cari Periode 2026
        $periode = $db->table('periode')
                      ->like('TAHUN_MULAI', '2026')
                      ->orLike('TAHUN_SELESAI', '2026')
                      ->orderBy('ID_PERIODE', 'DESC')
                      ->get()->getRow();
                      
        if (!$periode) {
            // Jika belum ada, buatkan P26
            $db->table('periode')->insert([
                'ID_PERIODE'    => 'P26',
                'TAHUN_MULAI'   => 2026,
                'TAHUN_SELESAI' => 2027,
                'STATUS_AKTIF'  => 1
            ]);
            $idPeriode = 'P26';
        } else {
            $idPeriode = $periode->ID_PERIODE;
            // Pastikan periode yang ditemukan menjadi AKTIF
            $db->table('periode')->update(['STATUS_AKTIF' => 0]); // nonaktifkan semua
            $db->table('periode')->where('ID_PERIODE', $idPeriode)->update(['STATUS_AKTIF' => 1]);
        }

        // 2. Pastikan Departemen ada (Maks 2 Karakter)
        $departemen = [
            ['ID_DEPARTEMEN' => 'BP', 'NAMA_DEPARTEMEN' => 'BPI'],
            ['ID_DEPARTEMEN' => 'AU', 'NAMA_DEPARTEMEN' => 'AUDIT'],
            ['ID_DEPARTEMEN' => 'HM', 'NAMA_DEPARTEMEN' => 'HUMAS'],
            ['ID_DEPARTEMEN' => 'MS', 'NAMA_DEPARTEMEN' => 'MSDM'],
            ['ID_DEPARTEMEN' => 'KM', 'NAMA_DEPARTEMEN' => 'KOMINFO'],
            ['ID_DEPARTEMEN' => 'PB', 'NAMA_DEPARTEMEN' => 'PB'],
            ['ID_DEPARTEMEN' => 'KK', 'NAMA_DEPARTEMEN' => 'KKI'],
            ['ID_DEPARTEMEN' => 'PM', 'NAMA_DEPARTEMEN' => 'PMDB'],
            ['ID_DEPARTEMEN' => 'PA', 'NAMA_DEPARTEMEN' => 'PA']
        ];
        foreach ($departemen as $d) {
            if (!$db->table('departemen')->where('ID_DEPARTEMEN', $d['ID_DEPARTEMEN'])->get()->getRow()) {
                $db->table('departemen')->insert($d);
            }
        }

        // 3. Pastikan Jabatan ada
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
        foreach ($jabatan as $j) {
            if (!$db->table('jabatan')->where('ID_JABATAN', $j['ID_JABATAN'])->get()->getRow()) {
                $db->table('jabatan')->insert($j);
            }
        }

        // 4. Data Anggota 72 orang
        $rawMembers = [
            ['name' => 'Hibban Aulia Mubarak', 'gender' => 'L', 'dept' => 'BP', 'pos' => '01'],
            ['name' => 'Fadli Ramadhan Kartosuharjo', 'gender' => 'L', 'dept' => 'BP', 'pos' => '02'],
            ['name' => 'Faiq', 'gender' => 'L', 'dept' => 'BP', 'pos' => '03'],
            ['name' => 'Alifatuz Zubaidah', 'gender' => 'P', 'dept' => 'BP', 'pos' => '04'],
            ['name' => 'Alvira Dwi Febriani', 'gender' => 'P', 'dept' => 'BP', 'pos' => '05'],
            ['name' => 'Cindy Putri Andjani', 'gender' => 'P', 'dept' => 'BP', 'pos' => '06'],
            ['name' => 'Vanti Nur Sholehah', 'gender' => 'P', 'dept' => 'BP', 'pos' => '07'],
            ['name' => 'Gita Nabila Putri Bahri', 'gender' => 'P', 'dept' => 'HM', 'pos' => '08'],
            ['name' => 'Ananda Ayu Kartika Sari', 'gender' => 'P', 'dept' => 'HM', 'pos' => '09'],
            ['name' => 'Ima Dwi Rahmania', 'gender' => 'P', 'dept' => 'HM', 'pos' => '09'],
            ['name' => 'Ammar Arifin', 'gender' => 'L', 'dept' => 'HM', 'pos' => '09'],
            ['name' => 'Fitrotun Nisak', 'gender' => 'P', 'dept' => 'HM', 'pos' => '09'],
            ['name' => 'Edinda Ayunisa Rahma', 'gender' => 'P', 'dept' => 'HM', 'pos' => '09'],
            ['name' => 'Rayhan Akmal Azhari', 'gender' => 'L', 'dept' => 'HM', 'pos' => '09'],
            ['name' => 'M. Brillyan Arzaq Al-habsyi', 'gender' => 'L', 'dept' => 'HM', 'pos' => '09'],
            ['name' => 'Muhammad Ramadhan', 'gender' => 'L', 'dept' => 'KK', 'pos' => '08'],
            ['name' => 'Muadz Mufti Musyafa', 'gender' => 'L', 'dept' => 'KK', 'pos' => '09'],
            ['name' => 'Eriska Cahya Ramadhani', 'gender' => 'P', 'dept' => 'KK', 'pos' => '09'],
            ['name' => 'Muhammad Yusuf Multazam', 'gender' => 'L', 'dept' => 'KK', 'pos' => '09'],
            ['name' => 'Ikta Kirani Bilqis Syifa\'ul L.', 'gender' => 'P', 'dept' => 'KK', 'pos' => '09'],
            ['name' => 'M. Acha Ikhwanussofa', 'gender' => 'L', 'dept' => 'KK', 'pos' => '09'],
            ['name' => 'Rafli Hossam Athaillah', 'gender' => 'L', 'dept' => 'KK', 'pos' => '09'],
            ['name' => 'Rahman Hakim', 'gender' => 'L', 'dept' => 'KK', 'pos' => '09'],
            ['name' => 'Titha Auliya Khotim', 'gender' => 'P', 'dept' => 'KM', 'pos' => '08'],
            ['name' => 'Safi i', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'M. Fadlullah Nuri Zam Zami', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Mokh. Faisol Nahdah M.', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Abi Salam Anshorulloh', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Ahmad Maulana Asyrafi', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Alfarisi', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Ervido Suminarhadi', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Rafifah Talitha Syahla', 'gender' => 'P', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'M. Taufiq Qurrahman', 'gender' => 'L', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Faradita Nuraini', 'gender' => 'P', 'dept' => 'KM', 'pos' => '09'],
            ['name' => 'Shofie Fadliya Rahma', 'gender' => 'P', 'dept' => 'MS', 'pos' => '08'],
            ['name' => 'Eva Amilia', 'gender' => 'P', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Nizam Al-Habsyi', 'gender' => 'L', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Husain Asrarillah', 'gender' => 'L', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Ali Rohmat', 'gender' => 'L', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Ahmad Faiq Dzikry', 'gender' => 'L', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Balqis Zuhruf Muttaqin', 'gender' => 'P', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Lia Mesya Rahmadiani', 'gender' => 'P', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Rizki Ridhwan Arif S.', 'gender' => 'L', 'dept' => 'MS', 'pos' => '09'],
            ['name' => 'Nadiya Putri Intan Nur R.', 'gender' => 'P', 'dept' => 'PA', 'pos' => '08'],
            ['name' => 'Faizah Aulia Firdaus', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Frisilia Vina Ariyanto', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Yudistian Dzaky Yassar', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Ahmad Khoirur Rohman', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Ismi Septia Utami', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Luthfi Kurnia Hadi', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Nazwa Dwi Rizkya', 'gender' => 'P', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Sufyan Abror', 'gender' => 'L', 'dept' => 'PA', 'pos' => '09'],
            ['name' => 'Mufti Mubarok Khoiriansyah', 'gender' => 'L', 'dept' => 'PB', 'pos' => '08'],
            ['name' => 'Audina Ni\'matul Firdaus', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Muhammad Irfan Permana', 'gender' => 'L', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Riyana Isti Juwariyah', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Naurah Maulidah', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Nayla An Nasywa', 'gender' => 'P', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Novan Musyafatoni', 'gender' => 'L', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Aflah Mahdi Yazdi', 'gender' => 'L', 'dept' => 'PB', 'pos' => '09'],
            ['name' => 'Salimatuz Zahwah', 'gender' => 'P', 'dept' => 'PM', 'pos' => '08'],
            ['name' => 'Ahmad Baihaqi Hasibullah', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Haris sandy Setiawan', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Hakim Nizam', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Muhamad Rangga Pratama P.', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Nazril Febry Fadli', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Putra Mahardhika Surasa', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Rajib Faiq Musyaddad', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Tio Putra Sidarta', 'gender' => 'L', 'dept' => 'PM', 'pos' => '09'],
            ['name' => 'Hilwa Ainindhiska Aisyah', 'gender' => 'P', 'dept' => 'AU', 'pos' => '10'],
            ['name' => 'Zahwa Neida Yasmin', 'gender' => 'P', 'dept' => 'AU', 'pos' => '10'],
            ['name' => 'Resti Kamilah Ghoyati', 'gender' => 'P', 'dept' => 'AU', 'pos' => '10'],
        ];

        $anggotaBuilder = $db->table('anggota');
        $strukturBuilder = $db->table('struktur_kepengurusan');
        $addedAnggota = 0;

        $i = 1;
        foreach ($rawMembers as $m) {
            $idAnggota = sprintf("A%05d", $i);
            $idStruktur = "S26" . sprintf("%05d", $i); // SK000001 (8 chars limit!)
            
            if (!$anggotaBuilder->where('ID_ANGGOTA', $idAnggota)->get()->getRow()) {
                $nameClean = strtolower(preg_replace('/[^a-zA-Z]/', '', $m['name']));
                $email = $nameClean . "@gmail.com";
                
                $anggotaBuilder->insert([
                    'ID_ANGGOTA'    => $idAnggota,
                    'NAMA_ANGGOTA'  => $m['name'],
                    'JENIS_KELAMIN' => $m['gender'],
                    'ALAMAT'        => 'Jl. Informatika Raya No. ' . ($i * 3),
                    'TANGGAL_LAHIR' => '2004-' . sprintf("%02d", (($i % 12) + 1)) . '-' . sprintf("%02d", (($i % 28) + 1)),
                    'NO_TELPON'     => '08' . sprintf("%010d", 1234567890 + $i),
                    'EMAIL'         => $email
                ]);
                $addedAnggota++;
            }

            // Selalu tambahkan struktur untuk periode ini jika belum ada
            if (!$strukturBuilder->where(['ID_ANGGOTA' => $idAnggota, 'ID_PERIODE' => $idPeriode])->get()->getRow()) {
                $strukturBuilder->insert([
                    'ID_STRUKTUR'   => $idStruktur, // 8 karakter char(8)
                    'ID_ANGGOTA'    => $idAnggota,
                    'ID_DEPARTEMEN' => $m['dept'],
                    'ID_JABATAN'    => $m['pos'],
                    'ID_PERIODE'    => $idPeriode
                ]);
            }
            $i++;
        }

        // 5. Data Program Kerja
        $prokerRaw = [
            ['dept' => 'HM', 'nama' => 'Studi Banding', 'waktu' => 'Akhir Bulan Mei', 'pj' => 'Ima'],
            ['dept' => 'HM', 'nama' => 'Kunjungan Perusahaan', 'waktu' => 'Minggu ke-4 Juni/Minggu ke-1 Juli', 'pj' => 'Ammar'],
            ['dept' => 'HM', 'nama' => 'Jumat Amal', 'waktu' => 'Awal Periode - Minggu pertama November', 'pj' => 'Dinda'],
            ['dept' => 'HM', 'nama' => 'Bagi Takjil', 'waktu' => '5 Maret 2026', 'pj' => 'Dinda'],
            ['dept' => 'HM', 'nama' => 'Kunjungan Panti', 'waktu' => '15 November', 'pj' => 'Dinda'],
            ['dept' => 'HM', 'nama' => 'SI Aksi', 'waktu' => 'Minggu ke-2/3 Bulan September (Sabtu & Minggu)', 'pj' => 'Nanda'],
            ['dept' => 'HM', 'nama' => 'SI Blusukan', 'waktu' => 'Minggu ke-3dan4 Bulan April (Sabtu)', 'pj' => 'Nanda'],
            ['dept' => 'HM', 'nama' => 'Media Partner', 'waktu' => 'Dimulai awal periode', 'pj' => 'Reyhan'],
            ['dept' => 'HM', 'nama' => 'Sobat Info', 'waktu' => 'Dimulai awal periode', 'pj' => 'Reyhan'],
            ['dept' => 'HM', 'nama' => 'Data Alumni', 'waktu' => 'Dimulai awal periode', 'pj' => 'Gita'],
            ['dept' => 'MS', 'nama' => 'Himaprosif Recruitment', 'waktu' => '20 Januari - 8 Februari 2026', 'pj' => 'Shofi'],
            ['dept' => 'MS', 'nama' => 'Buka Bersama', 'waktu' => '5 Maret', 'pj' => 'Husain & Faiq'],
            ['dept' => 'MS', 'nama' => 'Family Gathering', 'waktu' => 'Menyesuaikan UAS', 'pj' => 'Riski & Nizam'],
            ['dept' => 'MS', 'nama' => 'Road to PROKSI', 'waktu' => 'Agustus', 'pj' => 'Ali & Nizam'],
            ['dept' => 'MS', 'nama' => 'PROKSI', 'waktu' => 'September - Oktober', 'pj' => 'Shofi'],
            ['dept' => 'MS', 'nama' => 'MHRR', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Balqis & Meysa'],
            ['dept' => 'MS', 'nama' => 'SeraSI', 'waktu' => 'Setiap tanggal 27', 'pj' => 'Meysa'],
            ['dept' => 'MS', 'nama' => 'Meet Up Maba', 'waktu' => 'Setelah pengumuman SNBP, SNBT & Mandiri (2x)', 'pj' => 'Faiq & Lia'],
            ['dept' => 'MS', 'nama' => 'Ruang Suara', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Riski & Shofi'],
            ['dept' => 'KM', 'nama' => 'Foto Departemen', 'waktu' => 'Tanggal 8 Februari', 'pj' => 'Tim Media'],
            ['dept' => 'KM', 'nama' => 'Video Profil', 'waktu' => 'Maret - April (Sebelum Studi Banding)', 'pj' => 'Tim Media dan zami'],
            ['dept' => 'KM', 'nama' => 'Project Web', 'waktu' => 'Maret - akhir periode', 'pj' => 'safii dan alfarisi'],
            ['dept' => 'KM', 'nama' => 'SOP Request', 'waktu' => 'Selama kepengurusan', 'pj' => 'Sekretaris'],
            ['dept' => 'KM', 'nama' => 'Project Majalah', 'waktu' => 'Akhir Kepengurusan', 'pj' => 'Faisol'],
            ['dept' => 'KM', 'nama' => 'Kolaborasi Media Prodi', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Tim Media dan Web'],
            ['dept' => 'KM', 'nama' => 'ApresiaSI', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Titha'],
            ['dept' => 'KM', 'nama' => 'Kritik & Saran', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Tim sosial media'],
            ['dept' => 'KM', 'nama' => 'Sosial Media HIMAPROSIF', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Tim Media & Sosial Media'],
            ['dept' => 'KM', 'nama' => 'Cloud Documentary', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Titha'],
            ['dept' => 'KM', 'nama' => 'Saluran WhatsApp', 'waktu' => 'Selama Kepengurusan', 'pj' => 'Tim Sosial Media'],
            ['dept' => 'PB', 'nama' => 'PDH Paket', 'waktu' => 'Akhir Februari', 'pj' => 'Mufti'],
            ['dept' => 'PB', 'nama' => 'Merchandise', 'waktu' => 'Road To Proksi - Agustus Awal', 'pj' => 'Irfan + 25'],
            ['dept' => 'PB', 'nama' => 'Kemeja SI', 'waktu' => 'Akhir April', 'pj' => 'Irfan + 25'],
            ['dept' => 'PB', 'nama' => 'Jasa Titip & Dana Usaha', 'waktu' => 'April', 'pj' => 'Riyana + 25'],
            ['dept' => 'PB', 'nama' => 'Paid Promote & Kuesioner', 'waktu' => 'Februari', 'pj' => 'Audina + 25'],
            ['dept' => 'PB', 'nama' => 'Jersey', 'waktu' => 'Mei Awal', 'pj' => '25'],
            ['dept' => 'PB', 'nama' => 'Jaket Warga (Opsional)', 'waktu' => 'Akhir Periode', 'pj' => ''],
            ['dept' => 'KK', 'nama' => 'Konten Islami', 'waktu' => '1 x per bulan', 'pj' => 'Yusuf'],
            ['dept' => 'KK', 'nama' => 'Istighosah & Tahlil', 'waktu' => '2 x per periode : 16 April & 10 September', 'pj' => 'Rahman \'25'],
            ['dept' => 'KK', 'nama' => 'Kajian Islami', 'waktu' => '2 x per periode : 19 Mei & 27 Agustus', 'pj' => 'Muadz'],
            ['dept' => 'KK', 'nama' => 'T2Q - SI', 'waktu' => '1 bulan sekali', 'pj' => 'Rama'],
            ['dept' => 'KK', 'nama' => 'Khataman', 'waktu' => '5 Maret', 'pj' => 'Eriska'],
            ['dept' => 'KK', 'nama' => 'Ziarah Wali', 'waktu' => '31 Oktober', 'pj' => 'Hossam \'25'],
            ['dept' => 'KK', 'nama' => 'Diba\'', 'waktu' => '15 November', 'pj' => 'Ikhwan \'25'],
            ['dept' => 'PM', 'nama' => 'Futsal', 'waktu' => '1 x per bulan', 'pj' => ''],
            ['dept' => 'PM', 'nama' => 'Hiking', 'waktu' => 'Awal Mei (opsi ke2 setelah pbak)', 'pj' => 'Baihaqi'],
            ['dept' => 'PM', 'nama' => 'Camp Ceria', 'waktu' => 'Akhir November', 'pj' => ''],
            ['dept' => 'PM', 'nama' => 'Basket', 'waktu' => 'Satu Bulan Sekali', 'pj' => ''],
            ['dept' => 'PM', 'nama' => 'Badminton', 'waktu' => 'Satu Bulan Sekali', 'pj' => 'Hakim'],
            ['dept' => 'PM', 'nama' => 'Mobile Legends', 'waktu' => '-', 'pj' => ''],
            ['dept' => 'PM', 'nama' => 'PES', 'waktu' => 'Februari Minggu Ketiga-Maret Minggu Kedua', 'pj' => 'Rangga'],
            ['dept' => 'PM', 'nama' => 'Suporter', 'waktu' => 'Arak - arakan & Kompetisi Futsal', 'pj' => ''],
            ['dept' => 'PA', 'nama' => 'SPRINTER', 'waktu' => '1 x per bulan selama kepengurusan', 'pj' => 'Nazwa'],
            ['dept' => 'PA', 'nama' => 'Peringatan Hari Besar Nasional', 'waktu' => 'Selama kepengurusan', 'pj' => 'Ismi'],
            ['dept' => 'PA', 'nama' => 'Dewan Pengawasan SPARK', 'waktu' => 'Selama kepengurusan', 'pj' => 'Yudis & Luthfi'],
            ['dept' => 'PA', 'nama' => 'Penjaringan minat bakat (Collab PMDB)', 'waktu' => 'Selama kepengurusan', 'pj' => 'Sufyan'],
            ['dept' => 'PA', 'nama' => 'SI TALK', 'waktu' => '1 x setiap 2 bulan (minggu ke-2 bulan ke-2)', 'pj' => 'Vina & Ismi'],
            ['dept' => 'PA', 'nama' => 'Mini Bootcamp', 'waktu' => 'Saat PROKSI (manut acara e PROKSI)', 'pj' => 'Faizah & Irur'],
            ['dept' => 'PA', 'nama' => 'Sharing Session', 'waktu' => '1 x per periode (19 April 2026)', 'pj' => 'Nadiya & Nazwa'],
            ['dept' => 'PA', 'nama' => 'Workshop', 'waktu' => '1 x per periode (bulan Agustus beberapa hari setelah PBAK)', 'pj' => 'Yudis & Sufyan']
        ];

        $prokerBuilder = $db->table('program_kerja');
        $addedProker = 0;
        $pi = 1;

        foreach ($prokerRaw as $pr) {
            $idProker = sprintf("PK%03d", $pi);
            
            if (!$prokerBuilder->where('ID_PROKER', $idProker)->get()->getRow()) {
                $prokerBuilder->insert([
                    'ID_PROKER'         => $idProker,
                    'ID_PERIODE'        => $idPeriode,
                    'ID_DEPARTEMEN'     => $pr['dept'],
                    'NAMA_PROKER'       => $pr['nama'],
                    'PENANGGUNG_JAWAB'  => $pr['pj'],
                    'WAKTU_PELAKSANAAN' => $pr['waktu']
                ]);
                $addedProker++;
            }
            $pi++;
        }

        return "<h1>Import Berhasil!</h1>
                <p>Data berhasil disesuaikan dengan periode: <strong>{$idPeriode}</strong></p>
                <ul>
                    <li>Anggota Baru Ditambahkan: <strong>{$addedAnggota}</strong> dari 72 total.</li>
                    <li>Struktur Kepengurusan: Telah di-generate untuk semua 72 anggota.</li>
                    <li>Program Kerja Baru: <strong>{$addedProker}</strong> ditambahkan.</li>
                </ul>
                <a href='".base_url('master/anggota')."'>Kembali ke Daftar Anggota</a>";
    }
}
