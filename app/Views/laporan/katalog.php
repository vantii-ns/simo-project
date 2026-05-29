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
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 2cm; }
        }
        .btn-print { padding: 10px 20px; background: #10B981; color: #fff; border: none; cursor: pointer; font-size: 14px; margin-bottom: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <button class="no-print btn-print" onclick="window.print()">Cetak Halaman (PDF)</button>
    
    <div class="header">
        <h1>KATALOG PROGRAM KERJA</h1>
        <p>Rencana Program Organisasi Periode <?= $periode['TAHUN_MULAI'] ?> - <?= $periode['TAHUN_SELESAI'] ?></p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Nama Program Kerja</th>
                    <th width="25%">Departemen Penanggung Jawab</th>
                    <th width="30%">Waktu Pelaksanaan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($proker)): ?>
                    <tr><td colspan="4" style="text-align: center;">Belum ada program kerja yang direncanakan.</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($proker as $p): ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++ ?></td>
                            <td><?= $p['NAMA_PROKER'] ?></td>
                            <td><?= $p['NAMA_DEPARTEMEN'] ?></td>
                            <td><?= $p['WAKTU_PELAKSANAAN'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
