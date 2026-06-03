<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; line-height: 1.5; color: #000; background: #fff; margin: 0; padding: 20px 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #000; padding-bottom: 15px; }
        .header h1 { margin: 0; font-size: 20pt; }
        .header p { margin: 5px 0 0; font-size: 12pt; }
        .content { margin-top: 20px; }
        .dept-title { font-weight: bold; text-decoration: underline; margin-top: 20px; font-size: 14pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 2cm; }
        }
        .btn-print { padding: 10px 20px; background: #4F46E5; color: #fff; border: none; cursor: pointer; font-size: 14px; margin-bottom: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <button class="no-print btn-print" onclick="window.print()">Cetak Halaman (PDF)</button>
    
    <div class="header" style="display: flex; align-items: center; justify-content: center; gap: 24px; border-bottom: 4px double #000; padding-bottom: 15px; margin-bottom: 25px;">
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo HIMAPROSIF" style="width: 90px; height: 90px; object-fit: contain;">
        <div style="text-align: center;">
            <h2 style="margin: 0; font-size: 14pt; text-transform: uppercase; font-family: 'Times New Roman', serif; font-weight: bold; letter-spacing: 0.5px;">HIMPUNAN MAHASISWA PROGRAM STUDI INFORMATIKA</h2>
            <h1 style="margin: 5px 0 0; font-size: 24pt; font-weight: bold; letter-spacing: 1px; font-family: 'Times New Roman', serif;">HIMAPROSIF</h1>
            <p style="margin: 5px 0 0; font-size: 9pt; font-style: italic; font-family: 'Times New Roman', serif; color: #333;">Sekretariat: Gedung Kuliah Bersama, Jl. Terusan Ryacudu, Lampung Selatan</p>
        </div>
    </div>

    <div style="text-align: center; margin-bottom: 25px;">
        <h3 style="margin: 0; font-size: 13pt; text-decoration: underline; font-weight: bold; text-transform: uppercase;">LAMPIRAN SURAT KEPUTUSAN</h3>
        <p style="margin: 3px 0 0; font-size: 11pt;">Nomor: 01/SK/HIMAPROSIF/V/2026</p>
        <p style="margin: 3px 0 0; font-size: 11pt; font-weight: bold;">TENTANG SUSUNAN KEPENGURUSAN PERIODE <?= $periode['TAHUN_MULAI'] ?> - <?= $periode['TAHUN_SELESAI'] ?></p>
    </div>

    <div class="content">
        <?php if (empty($strukturPerDept)): ?>
            <p style="text-align:center; font-style:italic;">Belum ada susunan kepengurusan pada periode ini.</p>
        <?php else: ?>
            <?php foreach ($strukturPerDept as $deptName => $anggotaList): ?>
                <div class="dept-title">Departemen: <?= strtoupper($deptName) ?></div>
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="45%">Nama Anggota</th>
                            <th width="50%">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($anggotaList as $a): ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= $a['NAMA_ANGGOTA'] ?></td>
                                <td><?= $a['NAMA_JABATAN'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
