<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Periode Kepengurusan</h3>
        <?php if (session()->get('user_role') === 'admin'): ?>
        <button class="btn btn-primary" onclick="document.getElementById('addForm').style.display = 'block'">
            <i class="fa-solid fa-plus"></i> Tambah Periode
        </button>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div style="background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>



    <?php if (session()->get('user_role') === 'admin'): ?>
    <div id="addForm" style="display: none; background: var(--bg-body); padding: 20px; border-radius: 12px; border: 1px solid var(--border-light); margin-bottom: 20px;">
        <h4>Tambah Data Baru</h4><br>
        <form action="<?= base_url('master/periode/save') ?>" method="post">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ID Periode (Max 4 char, mis: 2024)</label>
                    <input type="text" class="form-control" name="ID_PERIODE" required maxlength="4">
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Mulai</label>
                    <input type="number" class="form-control" name="TAHUN_MULAI" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Selesai</label>
                    <input type="number" class="form-control" name="TAHUN_SELESAI" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('addForm').style.display = 'none'">Batal</button>
        </form>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID Periode</th>
                    <th>Tahun Mulai</th>
                    <th>Tahun Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($periode as $p) : ?>
                    <tr>
                        <td><?= $p['ID_PERIODE'] ?></td>
                        <td><?= $p['TAHUN_MULAI'] ?></td>
                        <td><?= $p['TAHUN_SELESAI'] ?></td>
                        <td>
                            <?php if ($p['STATUS_AKTIF'] == 1) : ?>
                                <span class="badge badge-active"><i class="fa-solid fa-check-circle"></i> Aktif</span>
                            <?php else : ?>
                                <span class="badge badge-inactive">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (session()->get('user_role') === 'admin'): ?>
                            <div style="display: flex; gap: 6px;">
                                <?php if ($p['STATUS_AKTIF'] == 0) : ?>
                                    <a href="<?= base_url('master/periode/set_active/' . $p['ID_PERIODE']) ?>" class="btn btn-sm btn-success" title="Jadikan Aktif"><i class="fa-solid fa-power-off"></i> Aktifkan</a>
                                <?php endif; ?>
                                <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($p)) ?>)" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="<?= base_url('master/periode/delete/' . $p['ID_PERIODE']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                            </div>
                            <?php else: ?><span style="font-size:0.78rem;color:var(--text-light);">—</span><?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal (Glassmorphism Pop-up style) -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div class="glass-panel" style="width: 90%; max-width: 500px; padding: 25px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 12px;">
            <h4 style="margin: 0;"><i class="fa-solid fa-pen-to-square"></i> Ubah Periode</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editFormElement" action="" method="post">
            <div class="form-group">
                <label class="form-label">ID Periode</label>
                <input type="text" class="form-control" id="edit_ID_PERIODE" disabled style="background: #f1f5f9; color: #64748b;">
            </div>
            <div class="form-group">
                <label class="form-label">Tahun Mulai</label>
                <input type="number" class="form-control" name="TAHUN_MULAI" id="edit_TAHUN_MULAI" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tahun Selesai</label>
                <input type="number" class="form-control" name="TAHUN_SELESAI" id="edit_TAHUN_SELESAI" required>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; border-top: 1px solid var(--border-light); padding-top: 15px;">
                <button type="button" class="btn btn-danger" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openEditModal(periode) {
    document.getElementById('edit_ID_PERIODE').value = periode.ID_PERIODE;
    document.getElementById('edit_TAHUN_MULAI').value = periode.TAHUN_MULAI;
    document.getElementById('edit_TAHUN_SELESAI').value = periode.TAHUN_SELESAI;
    
    // Set form action
    document.getElementById('editFormElement').action = '<?= base_url('master/periode/update') ?>/' + periode.ID_PERIODE;
    
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
