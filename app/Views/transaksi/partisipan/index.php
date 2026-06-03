<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (!$activePeriode): ?>
    <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 20px; border-radius: 8px;">
        <i class="fa-solid fa-triangle-exclamation"></i> Tidak ada periode yang aktif.
    </div>
<?php else: ?>

<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h3>Daftar Partisipan Program Kerja</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px;">Mengelola panitia dan partisipan program kerja aktif.</p>
        </div>
        <?php if (session()->get('user_role') === 'admin'): ?>
        <button class="btn btn-primary" onclick="document.getElementById('addForm').style.display = 'block'">
            <i class="fa-solid fa-plus"></i> Tambah Partisipan
        </button>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->get('user_role') === 'admin'): ?>
    <div id="addForm" style="display: none; background: var(--bg-body); padding: 20px; border-radius: 12px; border: 1px solid var(--border-light); margin-bottom: 20px;">
        <h4>Tambah Partisipan Baru</h4><br>
        <form action="<?= base_url('transaksi/partisipan/save') ?>" method="post">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Program Kerja</label>
                    <select class="form-control" name="ID_PROKER" required>
                        <option value="">-- Pilih Program Kerja --</option>
                        <?php foreach ($proker as $pr): ?>
                            <option value="<?= $pr['ID_PROKER'] ?>"><?= $pr['NAMA_PROKER'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Anggota HIMA</label>
                    <select class="form-control" name="ID_ANGGOTA" required style="max-height: 200px;">
                        <option value="">-- Pilih Anggota --</option>
                        <?php foreach ($anggota as $ang): ?>
                            <option value="<?= $ang['ID_ANGGOTA'] ?>"><?= $ang['NAMA_ANGGOTA'] ?> (<?= $ang['ID_ANGGOTA'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Peran / Jobdesk</label>
                    <input type="text" class="form-control" name="PERAN_PADA_PROKER" required placeholder="Misal: Ketua Panitia, Divisi Acara">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Simpan</button>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('addForm').style.display = 'none'" style="margin-top: 15px;">Batal</button>
        </form>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Program Kerja</th>
                    <th>Peran / Jobdesk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($partisipan)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada data partisipan program kerja.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($partisipan as $pt) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= $pt['NAMA_ANGGOTA'] ?></strong></td>
                            <td><span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid rgba(22, 101, 52, 0.1); padding: 4px 8px; border-radius: 6px; font-weight: 600;"><?= $pt['NAMA_PROKER'] ?></span></td>
                            <td><?= $pt['PERAN_PADA_PROKER'] ?></td>
                            <td>
                                <?php if (session()->get('user_role') === 'admin'): ?>
                                <div style="display: flex; gap: 6px;">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($pt)) ?>)" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <a href="<?= base_url('transaksi/partisipan/delete/' . $pt['ID_PARTISIPASI']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                </div>
                                <?php else: ?><span style="font-size:0.78rem;color:var(--text-light);">—</span><?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal (Glassmorphism Pop-up style) -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div class="glass-panel" style="width: 90%; max-width: 500px; padding: 25px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 12px;">
            <h4 style="margin: 0;"><i class="fa-solid fa-pen-to-square"></i> Ubah Partisipan</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editFormElement" action="" method="post">
            <div class="form-group">
                <label class="form-label">Program Kerja</label>
                <select class="form-control" name="ID_PROKER" id="edit_ID_PROKER" required>
                    <?php foreach ($proker as $pr): ?>
                        <option value="<?= $pr['ID_PROKER'] ?>"><?= $pr['NAMA_PROKER'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Anggota HIMA</label>
                <select class="form-control" name="ID_ANGGOTA" id="edit_ID_ANGGOTA" required>
                    <?php foreach ($anggota as $ang): ?>
                        <option value="<?= $ang['ID_ANGGOTA'] ?>"><?= $ang['NAMA_ANGGOTA'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Peran / Jobdesk</label>
                <input type="text" class="form-control" name="PERAN_PADA_PROKER" id="edit_PERAN_PADA_PROKER" required>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; border-top: 1px solid var(--border-light); padding-top: 15px;">
                <button type="button" class="btn btn-danger" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openEditModal(partisipan) {
    document.getElementById('edit_ID_PROKER').value = partisipan.ID_PROKER;
    document.getElementById('edit_ID_ANGGOTA').value = partisipan.ID_ANGGOTA;
    document.getElementById('edit_PERAN_PADA_PROKER').value = partisipan.PERAN_PADA_PROKER;
    
    // Set form action
    document.getElementById('editFormElement').action = '<?= base_url('transaksi/partisipan/update') ?>/' + partisipan.ID_PARTISIPASI;
    
    // Show modal
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Close modal if clicked outside
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}
</script>
<?= $this->endSection() ?>
