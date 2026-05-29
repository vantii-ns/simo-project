<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.5; color: #000; background: #fff; margin: 0; padding: 20px 40px; }
        .header { margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 15px; display: flex; justify-content: space-between; align-items: flex-end; }
        .header h1 { margin: 0; font-size: 24pt; color: #f59e0b; }
        .profile { margin-bottom: 30px; }
        .profile table { width: 50%; border: none; }
        .profile td { padding: 4px 0; border: none; }
        .section-title { font-weight: bold; background: #f2f2f2; padding: 8px; margin-top: 20px; border-left: 5px solid #f59e0b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f9f9f9; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 1cm; }
        }
        .btn-print { padding: 10px 20px; background: #f59e0b; color: #fff; border: none; cursor: pointer; font-size: 14px; margin-bottom: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <button class="no-print btn-print" onclick="window.print()">Cetak Track Record (PDF)</button>
    
    <div class="header">
        <div>
            <h1>PORTFOLIO ANGGOTA</h1>
            <p style="margin: 5px 0 0; color: #555;">Dokumen Rekam Jejak Organisasi</p>
        </div>
        <div style="text-align: right;">
            <strong style="font-size: 18pt;"><?= $anggota['ID_ANGGOTA'] ?></strong>
        </div>
    </div>

    <div class="profile">
        <table>
            <tr><td width="30%"><strong>Nama Lengkap</strong></td><td width="5%">:</td><td><?= $anggota['NAMA_ANGGOTA'] ?></td></tr>
            <tr><td><strong>Jenis Kelamin</strong></td><td>:</td><td><?= $anggota['JENIS_KELAMIN'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td></tr>
            <tr><td><strong>Kontak / Email</strong></td><td>:</td><td><?= $anggota['NO_TELPON'] ?> / <?= $anggota['EMAIL'] ?></td></tr>
            <tr><td><strong>Alamat</strong></td><td>:</td><td><?= $anggota['ALAMAT'] ?></td></tr>
        </table>
    </div>

    <div class="section-title">Riwayat Jabatan Kepengurusan</div>
    <table>
        <thead>
            <tr>
                <th width="20%">Periode</th>
                <th width="40%">Departemen</th>
                <th width="40%">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($riwayatJabatan)): ?>
                <tr><td colspan="3" style="text-align: center;">Belum ada riwayat jabatan.</td></tr>
            <?php else: ?>
                <?php foreach($riwayatJabatan as $rj): ?>
                    <tr>
                        <td><?= $rj['TAHUN_MULAI'] ?> - <?= $rj['TAHUN_SELESAI'] ?></td>
                        <td><?= $rj['NAMA_DEPARTEMEN'] ?></td>
                        <td><strong><?= $rj['NAMA_JABATAN'] ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="section-title" style="margin-top: 30px;">Riwayat Partisipasi Program Kerja / Kepanitiaan</div>
    <table>
        <thead>
            <tr>
                <th width="20%">Periode</th>
                <th width="45%">Program Kerja</th>
                <th width="35%">Peran / Jobdesc</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($riwayatKepanitiaan)): ?>
                <tr><td colspan="3" style="text-align: center;">Belum ada riwayat partisipasi proker.</td></tr>
            <?php else: ?>
                <?php foreach($riwayatKepanitiaan as $rk): ?>
                    <tr>
                        <td><?= $rk['TAHUN_MULAI'] ?> - <?= $rk['TAHUN_SELESAI'] ?></td>
                        <td>
                            <strong><?= $rk['NAMA_PROKER'] ?></strong><br>
                            <small style="color: #666;"><?= $rk['WAKTU_PELAKSANAAN'] ?></small>
                        </td>
                        <td><?= $rk['PERAN_PADA_PROKER'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right; font-style: italic; color: #777;">
        Dicetak pada sistem SIMO, <?= date('d M Y H:i') ?>
    </div>
</body>
</html>
