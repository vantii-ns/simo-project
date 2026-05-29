<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Jabatan</h3>
        <button class="btn btn-primary" onclick="document.getElementById('addForm').style.display = 'block'">
            <i class="fa-solid fa-plus"></i> Tambah Jabatan
        </button>
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



    <div id="addForm" style="display: none; background: var(--bg-body); padding: 20px; border-radius: 12px; border: 1px solid var(--border-light); margin-bottom: 20px;">
        <h4>Tambah Jabatan Baru</h4><br>
        <form action="<?= base_url('master/jabatan/save') ?>" method="post">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ID Jabatan (Max 2 Char, mis: J1)</label>
                    <input type="text" class="form-control" name="ID_JABATAN" required maxlength="2">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" class="form-control" name="NAMA_JABATAN" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('addForm').style.display = 'none'">Batal</button>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jabatan as $j) : ?>
                    <tr>
                        <td><?= $j['ID_JABATAN'] ?></td>
                        <td><?= $j['NAMA_JABATAN'] ?></td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($j)) ?>)" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="<?= base_url('master/jabatan/delete/' . $j['ID_JABATAN']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                            </div>
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
            <h4 style="margin: 0;"><i class="fa-solid fa-pen-to-square"></i> Ubah Jabatan</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editFormElement" action="" method="post">
            <div class="form-group">
                <label class="form-label">ID Jabatan</label>
                <input type="text" class="form-control" id="edit_ID_JABATAN" disabled style="background: #f1f5f9; color: #64748b;">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Jabatan</label>
                <input type="text" class="form-control" name="NAMA_JABATAN" id="edit_NAMA_JABATAN" required>
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
function openEditModal(jabatan) {
    document.getElementById('edit_ID_JABATAN').value = jabatan.ID_JABATAN;
    document.getElementById('edit_NAMA_JABATAN').value = jabatan.NAMA_JABATAN;
    
    // Set form action
    document.getElementById('editFormElement').action = '<?= base_url('master/jabatan/update') ?>/' + jabatan.ID_JABATAN;
    
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
