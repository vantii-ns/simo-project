<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Search extends BaseController
{
    /**
     * Global search endpoint – returns JSON with results grouped by entity.
     * GET /search?q=keyword
     */
    public function index(): ResponseInterface
    {
        $keyword = trim($this->request->getGet('q') ?? '');

        // Selalu sertakan keyword di response agar JS bisa menampilkan pesan yg benar
        if (strlen($keyword) < 2) {
            return $this->response->setJSON([
                'results' => [],
                'total'   => 0,
                'keyword' => $keyword,
            ]);
        }

        try {
            $db      = \Config\Database::connect();
            $results = [];
            $kw      = '%' . $keyword . '%';

            // ── 1. Program Kerja ─────────────────────────────────────────────
            // Cari di nama proker, nama departemen, penanggung jawab, dan status
            $prokerRows = $db->query("
                SELECT
                    pk.ID_PROKER,
                    pk.NAMA_PROKER,
                    pk.STATUS,
                    pk.PENANGGUNG_JAWAB,
                    d.NAMA_DEPARTEMEN
                FROM program_kerja pk
                LEFT JOIN departemen d ON d.ID_DEPARTEMEN = pk.ID_DEPARTEMEN
                WHERE pk.NAMA_PROKER       LIKE ?
                   OR d.NAMA_DEPARTEMEN    LIKE ?
                   OR pk.PENANGGUNG_JAWAB  LIKE ?
                   OR pk.STATUS            LIKE ?
                ORDER BY pk.TANGGAL_MULAI DESC
                LIMIT 8
            ", [$kw, $kw, $kw, $kw])->getResultArray();

            foreach ($prokerRows as $row) {
                $results[] = [
                    'type'   => 'proker',
                    'label'  => $row['NAMA_PROKER'],
                    'sub'    => 'Departemen: ' . ($row['NAMA_DEPARTEMEN'] ?? '-') . ' | PJ: ' . ($row['PENANGGUNG_JAWAB'] ?: '-'),
                    'status' => $row['STATUS'],
                    'url'    => base_url('transaksi/proker/detail/' . $row['ID_PROKER']),
                    'icon'   => 'fa-briefcase',
                    'color'  => '#2563eb',
                ];
            }

            // ── 2. Anggota ───────────────────────────────────────────────────
            // Gunakan raw query dengan MAX() agar aman dengan sql_mode=only_full_group_by
            $anggotaRows = $db->query("
                SELECT
                    a.ID_ANGGOTA,
                    a.NAMA_ANGGOTA,
                    a.EMAIL,
                    MAX(d.NAMA_DEPARTEMEN) AS NAMA_DEPARTEMEN,
                    MAX(j.NAMA_JABATAN)    AS NAMA_JABATAN
                FROM anggota a
                LEFT JOIN struktur_kepengurusan sk ON sk.ID_ANGGOTA = a.ID_ANGGOTA
                LEFT JOIN departemen d ON d.ID_DEPARTEMEN = sk.ID_DEPARTEMEN
                LEFT JOIN jabatan    j ON j.ID_JABATAN    = sk.ID_JABATAN
                WHERE a.NAMA_ANGGOTA       LIKE ?
                   OR a.EMAIL              LIKE ?
                   OR d.NAMA_DEPARTEMEN    LIKE ?
                   OR j.NAMA_JABATAN       LIKE ?
                GROUP BY a.ID_ANGGOTA, a.NAMA_ANGGOTA, a.EMAIL
                LIMIT 8
            ", [$kw, $kw, $kw, $kw])->getResultArray();

            foreach ($anggotaRows as $row) {
                $deptInfo = $row['NAMA_DEPARTEMEN'] ? ('Dept: ' . $row['NAMA_DEPARTEMEN']) : 'Belum ada struktur';
                $jabInfo  = $row['NAMA_JABATAN']   ? (' | Jabatan: ' . $row['NAMA_JABATAN']) : '';
                $results[] = [
                    'type'  => 'anggota',
                    'label' => $row['NAMA_ANGGOTA'],
                    'sub'   => $deptInfo . $jabInfo,
                    'url'   => base_url('master/anggota'),
                    'icon'  => 'fa-user',
                    'color' => '#10b981',
                ];
            }

            // ── 3. Departemen ────────────────────────────────────────────────
            $deptRows = $db->query("
                SELECT
                    d.ID_DEPARTEMEN,
                    d.NAMA_DEPARTEMEN,
                    COUNT(DISTINCT pk.ID_PROKER)              AS proker_count,
                    COUNT(DISTINCT sk.ID_ANGGOTA)             AS anggota_count
                FROM departemen d
                LEFT JOIN program_kerja           pk ON pk.ID_DEPARTEMEN = d.ID_DEPARTEMEN
                LEFT JOIN struktur_kepengurusan   sk ON sk.ID_DEPARTEMEN  = d.ID_DEPARTEMEN
                WHERE d.NAMA_DEPARTEMEN LIKE ?
                GROUP BY d.ID_DEPARTEMEN, d.NAMA_DEPARTEMEN
                LIMIT 5
            ", [$kw])->getResultArray();

            foreach ($deptRows as $row) {
                $results[] = [
                    'type'  => 'departemen',
                    'label' => $row['NAMA_DEPARTEMEN'],
                    'sub'   => $row['proker_count'] . ' Program Kerja | ' . $row['anggota_count'] . ' Anggota',
                    'url'   => base_url('master/departemen'),
                    'icon'  => 'fa-sitemap',
                    'color' => '#8b5cf6',
                ];
            }

            return $this->response->setJSON([
                'results' => $results,
                'total'   => count($results),
                'keyword' => $keyword,
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'results' => [],
                'total'   => 0,
                'keyword' => $keyword,
                'error'   => 'Database error'
            ]);
        }
    }
}
