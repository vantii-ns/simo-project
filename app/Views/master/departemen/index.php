<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Departemen</h3>
        <button class="btn btn-primary" onclick="document.getElementById('addForm').style.display = 'block'">
            <i class="fa-solid fa-plus"></i> Tambah Departemen
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
        <h4>Tambah Departemen Baru</h4><br>
        <form action="<?= base_url('master/departemen/save') ?>" method="post">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ID Departemen (Max 2 Char, mis: D1)</label>
                    <input type="text" class="form-control" name="ID_DEPARTEMEN" required maxlength="2">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Departemen</label>
                    <input type="text" class="form-control" name="NAMA_DEPARTEMEN" required>
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
                    <th>Nama Departemen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departemen as $d) : ?>
                    <tr>
                        <td><?= $d['ID_DEPARTEMEN'] ?></td>
                        <td><?= $d['NAMA_DEPARTEMEN'] ?></td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($d)) ?>)" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="<?= base_url('master/departemen/delete/' . $d['ID_DEPARTEMEN']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
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
            <h4 style="margin: 0;"><i class="fa-solid fa-pen-to-square"></i> Ubah Departemen</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editFormElement" action="" method="post">
            <div class="form-group">
                <label class="form-label">ID Departemen</label>
                <input type="text" class="form-control" id="edit_ID_DEPARTEMEN" disabled style="background: #f1f5f9; color: #64748b;">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Departemen</label>
                <input type="text" class="form-control" name="NAMA_DEPARTEMEN" id="edit_NAMA_DEPARTEMEN" required>
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
function openEditModal(dept) {
    document.getElementById('edit_ID_DEPARTEMEN').value = dept.ID_DEPARTEMEN;
    document.getElementById('edit_NAMA_DEPARTEMEN').value = dept.NAMA_DEPARTEMEN;
    
    // Set form action
    document.getElementById('editFormElement').action = '<?= base_url('master/departemen/update') ?>/' + dept.ID_DEPARTEMEN;
    
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
