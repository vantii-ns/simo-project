<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="glass-panel" style="margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2><?= $proker['NAMA_PROKER'] ?></h2>
            <p style="color: var(--text-muted); margin-top: 5px;">
                <i class="fa-regular fa-calendar"></i> <?= $proker['WAKTU_PELAKSANAAN'] ?> | 
                <i class="fa-solid fa-sitemap"></i> Departemen: <?= $proker['NAMA_DEPARTEMEN'] ?>
            </p>
        </div>
        <a href="<?= base_url('transaksi/proker') ?>" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="grid-2">
    <!-- Form Tambah Partisipan -->
    <div class="glass-panel">
        <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-user-plus"></i> Tambah Partisipan/Kepanitiaan</h3>
        
        <?php if (session()->getFlashdata('message')) : ?>
            <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('transaksi/proker/save_partisipan') ?>" method="post">
            <input type="hidden" name="ID_PROKER" value="<?= $proker['ID_PROKER'] ?>">
            
            <div class="form-group">
                <label class="form-label">Pilih Anggota</label>
                <select class="form-control" name="ID_ANGGOTA" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['ID_ANGGOTA'] ?>"><?= $a['ID_ANGGOTA'] ?> - <?= $a['NAMA_ANGGOTA'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Peran / Jobdesc</label>
                <input type="text" class="form-control" name="PERAN_PADA_PROKER" required placeholder="Misal: Ketua Pelaksana, Anggota Divisi Acara">
            </div>
            
            <div class="form-group">
                <label class="form-label">Tugas / Tanggung Jawab</label>
                <input type="text" class="form-control" name="TUGAS" placeholder="Misal: Bertanggung jawab atas logistik & perlengkapan">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fa-solid fa-check"></i> Tambahkan
            </button>
        </form>
    </div>

    <!-- Daftar Partisipan -->
    <div class="glass-panel">
        <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-users"></i> Daftar Kepanitiaan</h3>
        
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Peran</th>
                        <th>Tugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($partisipan)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada partisipan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($partisipan as $p): ?>
                            <tr>
                                <td><strong><?= $p['NAMA_ANGGOTA'] ?></strong></td>
                                <td><span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid rgba(5, 150, 105, 0.1); padding: 4px 8px; border-radius: 6px; font-weight: 600;"><?= $p['PERAN_PADA_PROKER'] ?></span></td>
                                <td><span style="font-size: 0.85rem; color: #475569;"><?= htmlspecialchars($p['TUGAS'] ?: '-') ?></span></td>
                                <td>
                                    <a href="<?= base_url('transaksi/proker/delete_partisipan/' . $p['ID_PARTISIPASI'] . '/' . $proker['ID_PROKER']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
