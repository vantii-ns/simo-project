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
        if (!$db->fieldExists('TANGGAL_MULAI', 'program_kerja')) {
            $db->query("ALTER TABLE program_kerja ADD COLUMN TANGGAL_MULAI DATE NULL");
        }
        if (!$db->fieldExists('TANGGAL_SELESAI', 'program_kerja')) {
            $db->query("ALTER TABLE program_kerja ADD COLUMN TANGGAL_SELESAI DATE NULL");
        }
        if (!$db->fieldExists('TUGAS', 'partisipan')) {
            $db->query("ALTER TABLE partisipan ADD COLUMN TUGAS VARCHAR(150) NULL");
        }
        $db->query("ALTER TABLE partisipan MODIFY COLUMN PERAN_PADA_PROKER VARCHAR(50) NULL");
        
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
        ];

        // Truncate/clean old P26 proker and partisipan before re-seeding
        $db->query("DELETE FROM partisipan WHERE ID_PROKER IN (SELECT ID_PROKER FROM program_kerja WHERE ID_PERIODE = ?)", [$idPeriode]);
        $db->table('program_kerja')->where('ID_PERIODE', $idPeriode)->delete();

        $prokerBuilder = $db->table('program_kerja');
        $addedProker = 0;
        $pi = 1;

        // Initialize participant counter – supports rolling letter prefix P→Q→R...
        $lastP  = $db->table('partisipan')->orderBy('ID_PARTISIPASI', 'DESC')->limit(1)->get()->getRowArray();
        // pCount = absolute sequential number (1-based). Letter & digits derived in makePid().
        if ($lastP) {
            $pid    = $lastP['ID_PARTISIPASI'];
            $letter = $pid[0];                              // e.g. 'P', 'Q', ...
            $num    = (int)substr($pid, 1);                 // e.g. 99999
            $letterOrd  = ord($letter) - ord('P');          // 0 for P, 1 for Q, ...
            $pCount = $letterOrd * 99999 + $num + 1;        // absolute counter
        } else {
            $pCount = 1;
        }

        // Helper: generate rolling ID – P00001..P99999, Q00001..Q99999, R...
        $makePid = function() use (&$pCount) {
            $maxPerLetter = 99999;
            $letterIdx    = (int)floor(($pCount - 1) / $maxPerLetter);
            $numPart      = (($pCount - 1) % $maxPerLetter) + 1;
            $letter       = chr(ord('P') + $letterIdx);
            $pCount++;
            return $letter . str_pad($numPart, 5, '0', STR_PAD_LEFT);
        };

        foreach ($prokerRaw as $pr) {
            $idProker = sprintf("PK%03d", $pi);
            
            // Resolve full PJ Name
            $fullPj = $this->getFullPjName($pr['pj'], $pr['dept']);
            
            // Resolve exact dates
            list($tanggalMulai, $tanggalSelesai) = $this->getProkerDates($pi, $pr['waktu']);
            
            // Set status based on tanggalSelesai vs '2026-06-03'
            $status = 'Belum Terlaksana';
            if ($tanggalSelesai < '2026-06-03') {
                $status = (($pi % 10) == 0) ? 'Tidak Terlaksana' : 'Terlaksana';
            }
            
            $prokerBuilder->insert([
                'ID_PROKER'         => $idProker,
                'ID_PERIODE'        => $idPeriode,
                'ID_DEPARTEMEN'     => $pr['dept'],
                'NAMA_PROKER'       => $pr['nama'],
                'PENANGGUNG_JAWAB'  => $fullPj,
                'WAKTU_PELAKSANAAN' => $pr['waktu'],
                'TANGGAL_MULAI'     => $tanggalMulai,
                'TANGGAL_SELESAI'   => $tanggalSelesai,
                'STATUS'            => $status
            ]);
            $addedProker++;

            $deptMembers = $db->table('struktur_kepengurusan')
                              ->select('struktur_kepengurusan.ID_ANGGOTA, anggota.NAMA_ANGGOTA, struktur_kepengurusan.ID_JABATAN')
                              ->join('anggota', 'anggota.ID_ANGGOTA = struktur_kepengurusan.ID_ANGGOTA')
                              ->where('struktur_kepengurusan.ID_DEPARTEMEN', $pr['dept'])
                              ->where('struktur_kepengurusan.ID_PERIODE', $idPeriode)
                              ->get()->getResultArray();

            $kominfoMembers = $db->table('struktur_kepengurusan')
                                 ->select('struktur_kepengurusan.ID_ANGGOTA, anggota.NAMA_ANGGOTA, struktur_kepengurusan.ID_JABATAN')
                                 ->join('anggota', 'anggota.ID_ANGGOTA = struktur_kepengurusan.ID_ANGGOTA')
                                 ->where('struktur_kepengurusan.ID_DEPARTEMEN', 'KM')
                                 ->where('struktur_kepengurusan.ID_PERIODE', $idPeriode)
                                 ->get()->getResultArray();

            // Anggota departemen lain (selain penyelenggara) untuk tambahan
            $allOtherMembers = $db->table('struktur_kepengurusan')
                                  ->select('struktur_kepengurusan.ID_ANGGOTA, anggota.NAMA_ANGGOTA, struktur_kepengurusan.ID_DEPARTEMEN, struktur_kepengurusan.ID_JABATAN')
                                  ->join('anggota', 'anggota.ID_ANGGOTA = struktur_kepengurusan.ID_ANGGOTA')
                                  ->where('struktur_kepengurusan.ID_PERIODE', $idPeriode)
                                  ->whereNotIn('struktur_kepengurusan.ID_DEPARTEMEN', [$pr['dept']])
                                  ->get()->getResultArray();

            $assignedMembers = [];

            // insertPart menggunakan $makePid dari outer scope
            $insertPart = function($idAnggota, $peran, $tugas) use ($db, $idProker, $makePid, &$assignedMembers) {
                if (in_array($idAnggota, $assignedMembers)) return false;
                $db->table('partisipan')->insert([
                    'ID_ANGGOTA'        => $idAnggota,
                    'ID_PROKER'         => $idProker,
                    'ID_PARTISIPASI'    => $makePid(),
                    'PERAN_PADA_PROKER' => $peran,
                    'TUGAS'             => $tugas,
                ]);
                $assignedMembers[] = $idAnggota;
                return true;
            };

            // Kocok dengan seed deterministik berdasar index proker
            srand($pi * 7 + 31);
            shuffle($deptMembers);
            shuffle($kominfoMembers);
            shuffle($allOtherMembers);

            // ── 1. PENANGGUNG JAWAB ── Kadep departemen penyelenggara ──────────────
            $pjInserted = false;
            foreach ($deptMembers as $dm) {
                if ($dm['ID_JABATAN'] === '08') {
                    if ($insertPart($dm['ID_ANGGOTA'], 'Penanggung Jawab',
                        'Bertanggung jawab penuh atas perencanaan, pelaksanaan, dan evaluasi program kerja.')) {
                        $pjInserted = true; break;
                    }
                }
            }
            // Fallback: cari dari nama PJ field
            if (!$pjInserted && !empty($fullPj)) {
                foreach (preg_split('/\s+(&|dan|,)\s+/', $fullPj) as $pjName) {
                    $pjName = trim($pjName);
                    $found  = null;
                    foreach ($deptMembers as $dm) {
                        if (strcasecmp($dm['NAMA_ANGGOTA'], $pjName) === 0 ||
                            stripos($dm['NAMA_ANGGOTA'], $pjName) !== false) {
                            $found = $dm; break;
                        }
                    }
                    if (!$found) {
                        $row = $db->table('anggota')->like('NAMA_ANGGOTA', $pjName)->get()->getRowArray();
                        if ($row) $found = ['ID_ANGGOTA' => $row['ID_ANGGOTA'], 'NAMA_ANGGOTA' => $row['NAMA_ANGGOTA'], 'ID_JABATAN' => '09'];
                    }
                    if ($found) {
                        $insertPart($found['ID_ANGGOTA'], 'Penanggung Jawab',
                            'Bertanggung jawab penuh atas perencanaan, pelaksanaan, dan evaluasi program kerja.');
                    }
                }
            }

            // ── 2. KETUA PELAKSANA (dari dept) ────────────────────────────────────
            foreach ($deptMembers as $dm) {
                if ($insertPart($dm['ID_ANGGOTA'], 'Ketua Pelaksana',
                    'Memimpin, mengarahkan, dan mengkoordinasikan seluruh kepanitiaan program kerja.')) break;
            }

            // ── 3. SEKRETARIS (dari dept) ──────────────────────────────────────────
            foreach ($deptMembers as $dm) {
                if ($insertPart($dm['ID_ANGGOTA'], 'Sekretaris',
                    'Mengurus administrasi, notulensi rapat, surat-menyurat, dan proposal kegiatan.')) break;
            }

            // ── 4. BENDAHARA (dari dept) ───────────────────────────────────────────
            foreach ($deptMembers as $dm) {
                if ($insertPart($dm['ID_ANGGOTA'], 'Bendahara',
                    'Mengelola anggaran, mencatat pengeluaran, dan menyusun laporan keuangan kegiatan.')) break;
            }

            // ── 5. KOORDINATOR ACARA (dari dept) ──────────────────────────────────
            foreach ($deptMembers as $dm) {
                if ($insertPart($dm['ID_ANGGOTA'], 'Koordinator Acara',
                    'Menyusun konsep, rundown acara, dan memastikan kelancaran jalannya kegiatan.')) break;
            }

            // ── 6. KOORDINATOR LOGISTIK (dari dept) ───────────────────────────────
            foreach ($deptMembers as $dm) {
                if ($insertPart($dm['ID_ANGGOTA'], 'Koordinator Logistik',
                    'Mengatur kebutuhan perlengkapan, tempat, dan fasilitas pendukung kegiatan.')) break;
            }

            // ── 7. DIVISI PDD ── SELALU DARI KOMINFO ──────────────────────────────
            $kominfoOffset  = ($pi * 3) % max(1, count($kominfoMembers));
            $kominfoRotated = $kominfoMembers;
            for ($r = 0; $r < $kominfoOffset; $r++) {
                $kominfoRotated[] = array_shift($kominfoRotated);
            }
            // Kadep KOMINFO (jabatan 08) → Koordinator PDD
            $koorPddDone = false;
            foreach ($kominfoRotated as $km) {
                if ($km['ID_JABATAN'] === '08') {
                    if ($insertPart($km['ID_ANGGOTA'], 'Koordinator PDD',
                        'Mengkoordinasikan tim publikasi, dokumentasi, dan dekorasi acara.')) {
                        $koorPddDone = true; break;
                    }
                }
            }
            if (!$koorPddDone) {
                foreach ($kominfoRotated as $km) {
                    if ($insertPart($km['ID_ANGGOTA'], 'Koordinator PDD',
                        'Mengkoordinasikan tim publikasi, dokumentasi, dan dekorasi acara.')) break;
                }
            }
            // 2 Anggota PDD dari KOMINFO
            $pddCount = 0;
            foreach ($kominfoRotated as $km) {
                if ($pddCount >= 2) break;
                $pddTugas = ($pddCount === 0)
                    ? 'Mendokumentasikan kegiatan melalui foto/video dan mengelola konten media sosial.'
                    : 'Membuat desain grafis, materi visual, dan publikasi kegiatan di berbagai platform.';
                if ($insertPart($km['ID_ANGGOTA'], 'Anggota PDD', $pddTugas)) $pddCount++;
            }

            // ── 8. Sisa anggota dept → panitia inti ───────────────────────────────
            $deptSideRoles = [
                ['Koordinator Konsumsi',   'Mengatur kebutuhan konsumsi, distribusi makanan dan minuman untuk peserta.'],
                ['Anggota Divisi Acara',   'Membantu menyiapkan dan melaksanakan seluruh rangkaian acara kegiatan.'],
                ['Anggota Divisi Logistik','Membantu pengadaan, penataan, dan pengembalian perlengkapan kegiatan.'],
                ['Anggota Divisi Konsumsi','Membantu pengelolaan dan distribusi konsumsi kepada peserta kegiatan.'],
                ['Anggota Panitia',        'Membantu kelancaran pelaksanaan program kerja secara menyeluruh.'],
            ];
            foreach ($deptSideRoles as $sRole) {
                foreach ($deptMembers as $dm) {
                    if ($insertPart($dm['ID_ANGGOTA'], $sRole[0], $sRole[1])) break;
                }
            }

            // ── 9. Anggota dept lain → minimal 10 panitia (round-robin per dept) ──
            $otherOffset  = ($pi * 13) % max(1, count($allOtherMembers));
            $otherRotated = $allOtherMembers;
            for ($r = 0; $r < $otherOffset; $r++) {
                $otherRotated[] = array_shift($otherRotated);
            }
            $otherByDept = [];
            foreach ($otherRotated as $am) {
                if ($am['ID_DEPARTEMEN'] === 'KM') continue; // KOMINFO sudah di PDD
                $otherByDept[$am['ID_DEPARTEMEN']][] = $am;
            }
            $deptKeys      = array_keys($otherByDept);
            $extraRoles    = ['Anggota Divisi Humas','Anggota Panitia','Anggota Divisi Acara','Anggota Panitia','Anggota Divisi Logistik','Anggota Panitia'];
            $extraTugas    = [
                'Membantu koordinasi tamu undangan, publikasi, dan hubungan eksternal kegiatan.',
                'Membantu pelaksanaan dan koordinasi kegiatan antar departemen.',
                'Membantu menyiapkan dan melaksanakan rangkaian acara kegiatan.',
                'Mendukung koordinasi lapangan dan kesiapan sarana prasarana kegiatan.',
                'Membantu pengadaan dan penataan perlengkapan serta kebutuhan teknis kegiatan.',
                'Membantu seluruh keperluan teknis dan non-teknis selama kegiatan berlangsung.',
            ];
            $deptIdx        = 0;
            $memberPointers = array_fill_keys($deptKeys, 0);
            $extraIdx       = 0;
            while (count($assignedMembers) < 10 && !empty($deptKeys)) {
                $dk = $deptKeys[$deptIdx % count($deptKeys)];
                $mp = $memberPointers[$dk];
                if ($mp < count($otherByDept[$dk])) {
                    $am    = $otherByDept[$dk][$mp];
                    $memberPointers[$dk]++;
                    $role  = $extraRoles[$extraIdx % count($extraRoles)];
                    $tugas = $extraTugas[$extraIdx % count($extraTugas)];
                    if ($insertPart($am['ID_ANGGOTA'], $role, $tugas)) $extraIdx++;
                }
                $deptIdx++;
                $allExhausted = true;
                foreach ($deptKeys as $dk2) {
                    if ($memberPointers[$dk2] < count($otherByDept[$dk2])) { $allExhausted = false; break; }
                }
                if ($allExhausted) break;
            }

            // ── 10. Fallback KOMINFO sisa jika masih < 10 ─────────────────────────
            if (count($assignedMembers) < 10) {
                foreach ($kominfoRotated as $km) {
                    if (count($assignedMembers) >= 10) break;
                    $insertPart($km['ID_ANGGOTA'], 'Anggota PDD',
                        'Membantu publikasi dan dokumentasi kegiatan dari departemen KOMINFO.');
                }
            }

            // ── 11. Fallback akhir: seluruh sisa anggota ──────────────────────────
            if (count($assignedMembers) < 10) {
                foreach ($otherRotated as $am) {
                    if (count($assignedMembers) >= 10) break;
                    $insertPart($am['ID_ANGGOTA'], 'Anggota Panitia',
                        'Membantu pelaksanaan dan koordinasi kegiatan antar departemen.');
                }
            }

            $pi++;
        }

        return "<h1>Import Berhasil!</h1>
                <p>Data berhasil disesuaikan dengan periode: <strong>{$idPeriode}</strong></p>
                <ul>
                    <li>Anggota Baru Ditambahkan: <strong>{$addedAnggota}</strong> dari 72 total.</li>
                    <li>Struktur Kepengurusan: Telah di-generate untuk semua 72 anggota.</li>
                    <li>Program Kerja Baru: <strong>{$addedProker}</strong> ditambahkan.</li>
                    <li>Partisipan: Minimal <strong>10 panitia per proker</strong>. Dept penyelenggara = koor &amp; panitia inti. PDD selalu dari KOMINFO. ID rolling P&rarr;Q&rarr;R...</li>
                </ul>
                <a href='".base_url('master/anggota')."'>Kembali ke Daftar Anggota</a>";
    }

    private function getFullPjName($pj, $dept)
    {
        $pj = trim(strtolower($pj));
        if (empty($pj)) {
            if ($dept == 'PB') return 'Mufti Mubarok Khoiriansyah';
            if ($dept == 'PM') return 'Salimatuz Zahwah';
            return '';
        }
        
        $map = [
            'ima' => 'Ima Dwi Rahmania',
            'ammar' => 'Ammar Arifin',
            'dinda' => 'Edinda Ayunisa Rahma',
            'nanda' => 'Ananda Ayu Kartika Sari',
            'reyhan' => 'Rayhan Akmal Azhari',
            'gita' => 'Gita Nabila Putri Bahri',
            'shofi' => 'Shofie Fadliya Rahma',
            'husain & faiq' => 'Husain Asrarillah & Faiq',
            'riski & nizam' => 'Rizki Ridhwan Arif S. & Nizam Al-Habsyi',
            'ali & nizam' => 'Ali Rohmat & Nizam Al-Habsyi',
            'balqis & meysa' => 'Balqis Zuhruf Muttaqin & Lia Mesya Rahmadiani',
            'meysa' => 'Lia Mesya Rahmadiani',
            'faiq & lia' => 'Faiq & Lia Mesya Rahmadiani',
            'tim media' => 'Titha Auliya Khotim',
            'tim media dan zami' => 'Titha Auliya Khotim & M. Fadlullah Nuri Zam Zami',
            'safii dan alfarisi' => 'Safi i & Alfarisi',
            'sekretaris' => 'Alifatuz Zubaidah',
            'faisol' => 'Mokh. Faisol Nahdah M.',
            'tim media dan web' => 'Titha Auliya Khotim & Safi i',
            'titha' => 'Titha Auliya Khotim',
            'tim sosial media' => 'Rafifah Talitha Syahla',
            'tim media & sosial media' => 'Titha Auliya Khotim & Rafifah Talitha Syahla',
            'cloud documentary' => 'Titha Auliya Khotim',
            'saluran whatsapp' => 'Faradita Nuraini',
            'mufti' => 'Mufti Mubarok Khoiriansyah',
            'irfan + 25' => 'Muhammad Irfan Permana & Aflah Mahdi Yazdi',
            'kemeja si' => 'Muhammad Irfan Permana',
            'riyana + 25' => 'Riyana Isti Juwariyah & Aflah Mahdi Yazdi',
            'audina + 25' => 'Audina Ni\'matul Firdaus & Aflah Mahdi Yazdi',
            'jersey' => 'Novan Musyafatoni',
            '25' => 'Novan Musyafatoni',
            'yusuf' => 'Muhammad Yusuf Multazam',
            'rahman \'25' => 'Rahman Hakim',
            'kajian islami' => 'Muadz Mufti Musyafa',
            'muadz' => 'Muadz Mufti Musyafa',
            'rama' => 'Muhammad Ramadhan',
            'eriska' => 'Eriska Cahya Ramadhani',
            'hossam \'25' => 'Rafli Hossam Athaillah',
            'ikhwan \'25' => 'M. Acha Ikhwanussofa',
            'baihaqi' => 'Ahmad Baihaqi Hasibullah',
            'hakim' => 'Hakim Nizam',
            'rangga' => 'Muhamad Rangga Pratama P.',
            'nazwa' => 'Nazwa Dwi Rizkya',
            'ismi' => 'Ismi Septia Utami',
            'yudis & luthfi' => 'Yudistian Dzaky Yassar & Luthfi Kurnia Hadi',
            'sufyan' => 'Sufyan Abror',
            'vina & ismi' => 'Frisilia Vina Ariyanto & Ismi Septia Utami',
            'faizah & irur' => 'Faizah Aulia Firdaus & Ahmad Khoirur Rohman',
            'nadiya & nazwa' => 'Nadiya Putri Intan Nur R. & Nazwa Dwi Rizkya',
            'yudis & sufyan' => 'Yudistian Dzaky Yassar & Sufyan Abror',
        ];
        
        return isset($map[$pj]) ? $map[$pj] : ucwords($pj);
    }

    private function getProkerDates($index, $waktu)
    {
        $year = 2026;
        $waktuLower = strtolower($waktu);
        $month = 6;
        
        if (strpos($waktuLower, 'januari') !== false || strpos($waktuLower, 'jan') !== false) $month = 1;
        elseif (strpos($waktuLower, 'februari') !== false || strpos($waktuLower, 'feb') !== false) $month = 2;
        elseif (strpos($waktuLower, 'maret') !== false || strpos($waktuLower, 'mar') !== false) $month = 3;
        elseif (strpos($waktuLower, 'april') !== false || strpos($waktuLower, 'apr') !== false) $month = 4;
        elseif (strpos($waktuLower, 'mei') !== false) $month = 5;
        elseif (strpos($waktuLower, 'juni') !== false || strpos($waktuLower, 'jun') !== false) $month = 6;
        elseif (strpos($waktuLower, 'juli') !== false || strpos($waktuLower, 'jul') !== false) $month = 7;
        elseif (strpos($waktuLower, 'agustus') !== false || strpos($waktuLower, 'ags') !== false || strpos($waktuLower, 'agu') !== false) $month = 8;
        elseif (strpos($waktuLower, 'september') !== false || strpos($waktuLower, 'sep') !== false) $month = 9;
        elseif (strpos($waktuLower, 'oktober') !== false || strpos($waktuLower, 'okt') !== false) $month = 10;
        elseif (strpos($waktuLower, 'november') !== false || strpos($waktuLower, 'nov') !== false) $month = 11;
        elseif (strpos($waktuLower, 'desember') !== false || strpos($waktuLower, 'des') !== false) $month = 12;
        else {
            $month = ($index % 12) + 1;
        }
        
        if (strpos($waktuLower, 'proksi') !== false) {
            $month = 9;
        }
        
        $dayStart = (($index * 7) % 20) + 1;
        $dayEnd = $dayStart + (($index % 5) + 1);
        
        if (strpos($waktuLower, 'selama kepengurusan') !== false || strpos($waktuLower, 'awal periode') !== false || strpos($waktuLower, 'tiap') !== false || strpos($waktuLower, '1 x per bulan') !== false || strpos($waktuLower, '1 bulan sekali') !== false || strpos($waktuLower, 'satu bulan sekali') !== false) {
            $start = "{$year}-01-01";
            $end = "{$year}-12-31";
        } else {
            $start = sprintf("%d-%02d-%02d", $year, $month, $dayStart);
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            if ($dayEnd > $daysInMonth) $dayEnd = $daysInMonth;
            $end = sprintf("%d-%02d-%02d", $year, $month, $dayEnd);
        }
        
        if (strpos($waktuLower, '19 april 2026') !== false) {
            $start = "2026-04-19";
            $end = "2026-04-19";
        } elseif (strpos($waktuLower, '5 maret') !== false) {
            $start = "2026-03-05";
            $end = "2026-03-05";
        } elseif (strpos($waktuLower, '8 februari') !== false) {
            $start = "2026-02-08";
            $end = "2026-02-08";
        } elseif (strpos($waktuLower, '15 november') !== false) {
            $start = "2026-11-15";
            $end = "2026-11-15";
        } elseif (strpos($waktuLower, '16 april & 10 september') !== false) {
            $start = "2026-04-16";
            $end = "2026-09-10";
        } elseif (strpos($waktuLower, '19 mei & 27 agustus') !== false) {
            $start = "2026-05-19";
            $end = "2026-08-27";
        }
        
        return [$start, $end];
    }
}
