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
    <?php if (session()->get('user_role') === 'admin'): ?>
    <!-- Form Tambah Partisipan - Admin Only -->
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
    <?php else: ?>
    <!-- Info Panel - User View -->
    <div class="glass-panel">
        <h3 style="margin-bottom: 16px;"><i class="fa-solid fa-circle-info"></i> Informasi Program Kerja</h3>
        <div style="display: flex; flex-direction: column; gap: 14px;">
            <div style="padding: 14px; background: var(--border-light); border-radius: 10px;">
                <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Departemen</p>
                <p style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($proker['NAMA_DEPARTEMEN']) ?></p>
            </div>
            <div style="padding: 14px; background: var(--border-light); border-radius: 10px;">
                <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Target Waktu</p>
                <p style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($proker['WAKTU_PELAKSANAAN'] ?? '-') ?></p>
            </div>
            <div style="padding: 14px; background: var(--border-light); border-radius: 10px;">
                <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Penanggung Jawab</p>
                <p style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($proker['PENANGGUNG_JAWAB'] ?? '-') ?></p>
            </div>
            <div style="padding: 14px; background: var(--border-light); border-radius: 10px;">
                <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Status</p>
                <?php if ($proker['STATUS'] === 'Terlaksana'): ?>
                    <span style="background: rgba(16,185,129,0.15); color: #10b981; border: 1px solid rgba(16,185,129,0.3); padding: 3px 10px; border-radius: 6px; font-weight: 700;">✓ Terlaksana</span>
                <?php elseif ($proker['STATUS'] === 'Tidak Terlaksana'): ?>
                    <span style="background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); padding: 3px 10px; border-radius: 6px; font-weight: 700;">✗ Tidak Terlaksana</span>
                <?php else: ?>
                    <span style="background: rgba(100,116,139,0.15); color: var(--text-muted); border: 1px solid var(--border-color); padding: 3px 10px; border-radius: 6px; font-weight: 700;">Belum Terlaksana</span>
                <?php endif; ?>
            </div>
        </div>
        <p style="margin-top: 20px; font-size: 0.8rem; color: var(--text-muted); text-align: center; padding: 12px; background: var(--border-light); border-radius: 8px;">
            <i class="fa-solid fa-eye"></i> Mode baca saja — hanya admin yang dapat mengelola partisipan
        </p>
    </div>
    <?php endif; ?>

    <!-- Daftar Partisipan -->
    <div class="glass-panel">
        <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-users"></i> Daftar Kepanitiaan</h3>
        
        <?php if (session()->get('user_role') !== 'admin' && session()->getFlashdata('message')) : ?>
            <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
        
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Peran</th>
                        <th>Tugas</th>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($partisipan)): ?>
                        <tr>
                            <td colspan="<?= session()->get('user_role') === 'admin' ? '4' : '3' ?>" style="text-align: center; color: var(--text-muted);">Belum ada partisipan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($partisipan as $p): ?>
                            <tr>
                                <td><strong><?= $p['NAMA_ANGGOTA'] ?></strong></td>
                                <td><span class="badge" style="background: rgba(5,150,105,0.12); color: #10b981; border: 1px solid rgba(5,150,105,0.2); padding: 4px 8px; border-radius: 6px; font-weight: 600;"><?= $p['PERAN_PADA_PROKER'] ?></span></td>
                                <td><span style="font-size: 0.85rem; color: var(--text-muted);"><?= htmlspecialchars($p['TUGAS'] ?: '-') ?></span></td>
                                <?php if (session()->get('user_role') === 'admin'): ?>
                                <td>
                                    <a href="<?= base_url('transaksi/proker/delete_partisipan/' . $p['ID_PARTISIPASI'] . '/' . $proker['ID_PROKER']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
