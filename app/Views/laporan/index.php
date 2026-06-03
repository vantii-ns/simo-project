<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="glass-panel">
    <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-print"></i> Pusat Cetak Laporan</h3>

    <?php if (session()->getFlashdata('message')) : ?>
        <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="grid-2">
        <!-- SK Kepengurusan -->
        <div style="background: var(--bg-body); padding: 20px; border-radius: 12px; border: 1px solid var(--border-light); border-top: 4px solid var(--primary);">
            <h4>SK Susunan Kepengurusan</h4>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 10px; margin-bottom: 20px;">
                Mencetak lampiran Surat Keputusan yang berisi daftar lengkap pengurus (diklasifikasikan per departemen) untuk periode aktif saat ini.
            </p>
            <a href="<?= base_url('laporan/sk') ?>" target="_blank" class="btn btn-primary"><i class="fa-solid fa-file-contract"></i> Buka Mode Cetak</a>
        </div>

        <!-- Katalog Proker -->
        <div style="background: var(--bg-body); padding: 20px; border-radius: 12px; border: 1px solid var(--border-light); border-top: 4px solid #10b981;">
            <h4>Katalog Program Kerja</h4>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 10px; margin-bottom: 20px;">
                Mencetak daftar rencana program kerja organisasi selama satu periode penuh, lengkap dengan waktu pelaksanaan dan departemen terkait.
            </p>
            <a href="<?= base_url('laporan/katalog') ?>" target="_blank" class="btn btn-success"><i class="fa-solid fa-calendar-alt"></i> Buka Mode Cetak</a>
        </div>
        
        <!-- Track Record Anggota -->
        <div style="background: var(--bg-body); padding: 20px; border-radius: 12px; border: 1px solid var(--border-light); border-top: 4px solid #f59e0b; grid-column: span 2;">
            <h4>Track Record & Portofolio Anggota</h4>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 10px; margin-bottom: 20px;">
                Cetak laporan lengkap riwayat jabatan dan riwayat partisipasi program kerja dari seorang anggota. Sangat berguna untuk keperluan kaderisasi.
            </p>
            <form action="<?= base_url('laporan/rapor') ?>" method="post" target="_blank" style="display: flex; gap: 15px;">
                <select class="form-control" name="ID_ANGGOTA" required style="flex: 1;">
                    <option value="">-- Pilih Anggota yang Ingin Dicetak --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['ID_ANGGOTA'] ?>"><?= $a['ID_ANGGOTA'] ?> - <?= $a['NAMA_ANGGOTA'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary" style="background: #f59e0b; color: #fff; border-color: #f59e0b;"><i class="fa-solid fa-address-card"></i> Cetak Track Record</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
