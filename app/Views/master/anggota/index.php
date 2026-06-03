<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Anggota</h3>
        <?php if (session()->get('user_role') === 'admin'): ?>
        <button class="btn btn-primary" onclick="document.getElementById('addForm').style.display = 'block'">
            <i class="fa-solid fa-plus"></i> Tambah Anggota
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
        <h4>Tambah Anggota Baru</h4><br>
        <form action="<?= base_url('master/anggota/save') ?>" method="post">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ID Anggota (Max 6 Char)</label>
                    <input type="text" class="form-control" name="ID_ANGGOTA" required maxlength="6">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" name="NAMA_ANGGOTA" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="JENIS_KELAMIN" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="TANGGAL_LAHIR" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No Telpon</label>
                    <input type="text" class="form-control" name="NO_TELPON">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="EMAIL">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="ALAMAT" rows="3"></textarea>
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
                    <th>ID</th>
                    <th>Nama</th>
                    <th>L/P</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($anggota as $a) : ?>
                    <tr>
                        <td><?= $a['ID_ANGGOTA'] ?></td>
                        <td>
                            <strong><?= $a['NAMA_ANGGOTA'] ?></strong><br>
                            <small style="color: var(--text-muted);"><?= $a['EMAIL'] ?></small>
                        </td>
                        <td><?= $a['JENIS_KELAMIN'] ?></td>
                        <td><?= $a['NO_TELPON'] ?></td>
                        <td>
                            <?php if (session()->get('user_role') === 'admin'): ?>
                            <div style="display: flex; gap: 6px;">
                                <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($a)) ?>)" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="<?= base_url('master/anggota/delete/' . $a['ID_ANGGOTA']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                            </div>
                            <?php else: ?>
                            <span style="font-size:0.78rem;color:var(--text-light);">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal (Glassmorphism Pop-up style) -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div class="glass-panel" style="width: 90%; max-width: 600px; padding: 25px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 12px;">
            <h4 style="margin: 0;"><i class="fa-solid fa-pen-to-square"></i> Ubah Anggota</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editFormElement" action="" method="post">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ID Anggota</label>
                    <input type="text" class="form-control" id="edit_ID_ANGGOTA" disabled style="background: #f1f5f9; color: #64748b;">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" name="NAMA_ANGGOTA" id="edit_NAMA_ANGGOTA" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="JENIS_KELAMIN" id="edit_JENIS_KELAMIN" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="TANGGAL_LAHIR" id="edit_TANGGAL_LAHIR" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No Telpon</label>
                    <input type="text" class="form-control" name="NO_TELPON" id="edit_NO_TELPON">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="EMAIL" id="edit_EMAIL">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="ALAMAT" id="edit_ALAMAT" rows="3"></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; border-top: 1px solid var(--border-light); padding-top: 15px;">
                <button type="button" class="btn btn-danger" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toUpperCase();
    let table = document.querySelector(".table-responsive table");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        let td = tr[i].getElementsByTagName("td");
        // Loop through all columns except the last one (Aksi)
        for (let j = 0; j < td.length - 1; j++) {
            if (td[j]) {
                let txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('q');
    if (searchParam) {
        let input = document.getElementById("searchInput");
        input.value = searchParam;
        filterTable();
    }
});

function openEditModal(anggota) {
    document.getElementById('edit_ID_ANGGOTA').value = anggota.ID_ANGGOTA;
    document.getElementById('edit_NAMA_ANGGOTA').value = anggota.NAMA_ANGGOTA;
    document.getElementById('edit_JENIS_KELAMIN').value = anggota.JENIS_KELAMIN;
    document.getElementById('edit_TANGGAL_LAHIR').value = anggota.TANGGAL_LAHIR;
    document.getElementById('edit_NO_TELPON').value = anggota.NO_TELPON || '';
    document.getElementById('edit_EMAIL').value = anggota.EMAIL || '';
    document.getElementById('edit_ALAMAT').value = anggota.ALAMAT || '';
    
    // Set form action
    document.getElementById('editFormElement').action = '<?= base_url('master/anggota/update') ?>/' + anggota.ID_ANGGOTA;
    
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
