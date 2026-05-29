<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (!$activePeriode): ?>
    <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 20px; border-radius: 8px;">
        <i class="fa-solid fa-triangle-exclamation"></i> Tidak ada periode yang aktif. Silakan set periode aktif di menu Data Master > Periode terlebih dahulu untuk memplot struktur kepengurusan.
    </div>
<?php else: ?>

<div class="grid-2">
    <!-- Form Plotting -->
    <div class="glass-panel">
        <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-user-plus"></i> Plot Anggota ke Struktur</h3>
        <form id="plotForm">
            <div class="form-group">
                <label class="form-label">Pilih Anggota</label>
                <select class="form-control" name="ID_ANGGOTA" id="ID_ANGGOTA" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['ID_ANGGOTA'] ?>"><?= $a['ID_ANGGOTA'] ?> - <?= $a['NAMA_ANGGOTA'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Pilih Departemen</label>
                <select class="form-control" name="ID_DEPARTEMEN" id="ID_DEPARTEMEN" required>
                    <option value="">-- Pilih Departemen --</option>
                    <?php foreach ($departemen as $d): ?>
                        <option value="<?= $d['ID_DEPARTEMEN'] ?>"><?= $d['NAMA_DEPARTEMEN'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Pilih Jabatan</label>
                <select class="form-control" name="ID_JABATAN" id="ID_JABATAN" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php foreach ($jabatan as $j): ?>
                        <option value="<?= $j['ID_JABATAN'] ?>"><?= $j['NAMA_JABATAN'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="button" id="btnSavePlot" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fa-solid fa-check"></i> Simpan Posisi
            </button>
            <div id="ajaxMsg" style="margin-top: 15px; font-size: 0.9rem;"></div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="glass-panel" style="grid-column: span 1;">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 15px;">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo HIMAPROSIF" style="width: 50px; height: 50px; object-fit: contain;">
            <div>
                <h3 style="margin: 0;"><i class="fa-solid fa-network-wired"></i> Susunan Saat Ini</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Periode: <?= $activePeriode['TAHUN_MULAI'] ?>-<?= $activePeriode['TAHUN_SELESAI'] ?></p>
            </div>
        </div>
        
        <?php if (session()->getFlashdata('message')) : ?>
            <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>



        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table id="strukturTable">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($struktur as $s): ?>
                        <tr>
                            <td><strong><?= $s['NAMA_ANGGOTA'] ?></strong></td>
                            <td><span class="badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid rgba(29, 78, 216, 0.1); padding: 4px 8px; border-radius: 6px; font-weight: 600;"><?= $s['NAMA_DEPARTEMEN'] ?></span></td>
                            <td><?= $s['NAMA_JABATAN'] ?></td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($s)) ?>)" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <a href="<?= base_url('transaksi/struktur/delete/' . $s['ID_STRUKTUR']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal (Glassmorphism Pop-up style) -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div class="glass-panel" style="width: 90%; max-width: 500px; padding: 25px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 12px;">
            <h4 style="margin: 0;"><i class="fa-solid fa-pen-to-square"></i> Ubah Struktur Kepengurusan</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editFormElement" action="" method="post">
            <div class="form-group">
                <label class="form-label">Nama Anggota</label>
                <select class="form-control" name="ID_ANGGOTA" id="edit_ID_ANGGOTA" required>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['ID_ANGGOTA'] ?>"><?= $a['NAMA_ANGGOTA'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Departemen</label>
                <select class="form-control" name="ID_DEPARTEMEN" id="edit_ID_DEPARTEMEN" required>
                    <?php foreach ($departemen as $d): ?>
                        <option value="<?= $d['ID_DEPARTEMEN'] ?>"><?= $d['NAMA_DEPARTEMEN'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jabatan</label>
                <select class="form-control" name="ID_JABATAN" id="edit_ID_JABATAN" required>
                    <?php foreach ($jabatan as $j): ?>
                        <option value="<?= $j['ID_JABATAN'] ?>"><?= $j['NAMA_JABATAN'] ?></option>
                    <?php endforeach; ?>
                </select>
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
document.addEventListener('DOMContentLoaded', function() {
    const btnSave = document.getElementById('btnSavePlot');
    if (btnSave) {
        btnSave.addEventListener('click', function() {
            const idAnggota = document.getElementById('ID_ANGGOTA').value;
            const idDept = document.getElementById('ID_DEPARTEMEN').value;
            const idJabatan = document.getElementById('ID_JABATAN').value;
            const msgDiv = document.getElementById('ajaxMsg');

            if (!idAnggota || !idDept || !idJabatan) {
                msgDiv.innerHTML = '<span style="color: #ef4444;">Semua field harus dipilih!</span>';
                return;
            }

            btnSave.disabled = true;
            btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

            const formData = new FormData();
            formData.append('ID_ANGGOTA', idAnggota);
            formData.append('ID_DEPARTEMEN', idDept);
            formData.append('ID_JABATAN', idJabatan);

            fetch('<?= base_url('transaksi/struktur/save') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="fa-solid fa-check"></i> Simpan Posisi';

                if (data.status === 'success') {
                    msgDiv.innerHTML = `<span style="color: #34d399;">${data.message}</span>`;
                    
                    // Add row to table dynamically
                    const tbody = document.querySelector('#strukturTable tbody');
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><strong>${data.data.NAMA_ANGGOTA}</strong></td>
                        <td><span class="badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid rgba(29, 78, 216, 0.1); padding: 4px 8px; border-radius: 6px; font-weight: 600;">${data.data.NAMA_DEPARTEMEN}</span></td>
                        <td>${data.data.NAMA_JABATAN}</td>
                        <td>
                            <a href="<?= base_url('transaksi/struktur/delete/') ?>${data.data.ID_STRUKTUR}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    `;
                    tbody.prepend(tr); // Add to top
                } else {
                    msgDiv.innerHTML = `<span style="color: #ef4444;">${data.message}</span>`;
                }
            })
            .catch(error => {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="fa-solid fa-check"></i> Simpan Posisi';
                msgDiv.innerHTML = `<span style="color: #ef4444;">Terjadi kesalahan server</span>`;
            });
        });
    }
});

function openEditModal(struktur) {
    document.getElementById('edit_ID_ANGGOTA').value = struktur.ID_ANGGOTA;
    document.getElementById('edit_ID_DEPARTEMEN').value = struktur.ID_DEPARTEMEN;
    document.getElementById('edit_ID_JABATAN').value = struktur.ID_JABATAN;
    
    // Set form action
    document.getElementById('editFormElement').action = '<?= base_url('transaksi/struktur/update') ?>/' + struktur.ID_STRUKTUR;
    
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
