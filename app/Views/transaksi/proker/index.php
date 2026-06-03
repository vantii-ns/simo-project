<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$formatTanggalIndo = function($dateStr) {
    if (empty($dateStr)) return '-';
    $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
        7 => 'Jul', 8 => 'Ags', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];
    $time = strtotime($dateStr);
    $d = date('j', $time);
    $m = date('n', $time);
    $y = date('Y', $time);
    return "{$d} {$months[$m]} {$y}";
};

$formatTanggalIndoFull = function($dateStr) {
    if (empty($dateStr)) return '-';
    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $time = strtotime($dateStr);
    $d = date('j', $time);
    $m = date('n', $time);
    $y = date('Y', $time);
    return "{$d} {$months[$m]} {$y}";
};
?>

<?php if (!$activePeriode): ?>
    <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 20px; border-radius: 8px;">
        <i class="fa-solid fa-triangle-exclamation"></i> Tidak ada periode yang aktif.
    </div>
<?php else: ?>

<!-- Premium Navigation Tabs -->
<div class="tabs-container" style="display: flex; gap: 8px; margin-bottom: 20px; background: rgba(255,255,255,0.7); backdrop-filter: blur(8px); padding: 6px; border-radius: 12px; border: 1px solid var(--border-color); width: fit-content; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
    <button class="tab-btn active" onclick="switchTab('table')" id="tab-table-btn" style="background: #1e3a8a; border: none; padding: 10px 20px; font-weight: 700; font-size: 0.9rem; cursor: pointer; color: #ffffff; transition: var(--transition); border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.25);">
        <i class="fa-solid fa-table-list"></i> Daftar Program Kerja
    </button>
    <button class="tab-btn" onclick="switchTab('gantt')" id="tab-gantt-btn" style="background: transparent; border: none; padding: 10px 20px; font-weight: 700; font-size: 0.9rem; cursor: pointer; color: var(--text-muted); transition: var(--transition); border-radius: 8px; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-chart-gantt"></i> Visualisasi Gantt Chart
    </button>
</div>

<div id="table-tab-content">
<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h3>Daftar Program Kerja</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px;">Periode: <?= $activePeriode['TAHUN_MULAI'] ?>-<?= $activePeriode['TAHUN_SELESAI'] ?></p>
        </div>
        <?php if (session()->get('user_role') === 'admin'): ?>
        <button class="btn btn-primary" onclick="document.getElementById('addForm').style.display = 'block'">
            <i class="fa-solid fa-plus"></i> Tambah Proker
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
        <h4>Tambah Program Kerja Baru</h4><br>
        <form action="<?= base_url('transaksi/proker/save') ?>" method="post">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ID Proker (Max 5 Char)</label>
                    <input type="text" class="form-control" name="ID_PROKER" required maxlength="5" placeholder="Misal: PK001">
                </div>
                <div class="form-group">
                    <label class="form-label">Departemen Penanggung Jawab</label>
                    <select class="form-control" name="ID_DEPARTEMEN" required>
                        <option value="">-- Pilih Departemen --</option>
                        <?php foreach ($departemen as $d): ?>
                            <option value="<?= $d['ID_DEPARTEMEN'] ?>"><?= $d['NAMA_DEPARTEMEN'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Program Kerja</label>
                    <input type="text" class="form-control" name="NAMA_PROKER" required placeholder="Misal: Studi Banding">
                </div>
                <div class="form-group">
                    <label class="form-label">Target Tanggal / Waktu (Keterangan)</label>
                    <input type="text" class="form-control" name="WAKTU_PELAKSANAAN" placeholder="Misal: Akhir Bulan Mei" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="TANGGAL_MULAI" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="TANGGAL_SELESAI" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" class="form-control" name="PENANGGUNG_JAWAB" placeholder="Misal: Ima, Husain & Faiq">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Pelaksanaan</label>
                    <select class="form-control" name="STATUS">
                        <option value="Belum Terlaksana">Belum Terlaksana</option>
                        <option value="Terlaksana">✓ Terlaksana</option>
                        <option value="Tidak Terlaksana">✗ Tidak Terlaksana</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Simpan</button>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('addForm').style.display = 'none'" style="margin-top: 15px;">Batal</button>
        </form>
    </div>
    <?php endif; ?>

    <!-- Edit Form (Modal Overlay style) -->
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div class="glass-panel" style="width: 90%; max-width: 600px; padding: 25px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 12px;">
                <h4 style="margin: 0;"><i class="fa-solid fa-pen-to-square"></i> Ubah Program Kerja</h4>
                <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="editProkerForm" action="" method="post">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">ID Proker</label>
                        <input type="text" class="form-control" id="edit_ID_PROKER" disabled style="background: #f1f5f9; color: #64748b;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Departemen Penanggung Jawab</label>
                        <select class="form-control" name="ID_DEPARTEMEN" id="edit_ID_DEPARTEMEN" required>
                            <option value="">-- Pilih Departemen --</option>
                            <?php foreach ($departemen as $d): ?>
                                <option value="<?= $d['ID_DEPARTEMEN'] ?>"><?= $d['NAMA_DEPARTEMEN'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Nama Program Kerja</label>
                        <input type="text" class="form-control" name="NAMA_PROKER" id="edit_NAMA_PROKER" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Target Tanggal / Waktu (Keterangan)</label>
                        <input type="text" class="form-control" name="WAKTU_PELAKSANAAN" id="edit_WAKTU_PELAKSANAAN" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="TANGGAL_MULAI" id="edit_TANGGAL_MULAI" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="TANGGAL_SELESAI" id="edit_TANGGAL_SELESAI" required>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Penanggung Jawab</label>
                        <input type="text" class="form-control" name="PENANGGUNG_JAWAB" id="edit_PENANGGUNG_JAWAB">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Status Pelaksanaan</label>
                        <select class="form-control" name="STATUS" id="edit_STATUS">
                            <option value="Belum Terlaksana">Belum Terlaksana</option>
                            <option value="Terlaksana">✓ Terlaksana</option>
                            <option value="Tidak Terlaksana">✗ Tidak Terlaksana</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; border-top: 1px solid var(--border-light); padding-top: 15px;">
                    <button type="button" class="btn btn-danger" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Departemen</th>
                    <th>Nama Program Kerja</th>
                    <th>Target Tanggal</th>
                    <th>Penanggung Jawab</th>
                    <th style="text-align: center;">Terlaksana</th>
                    <th style="text-align: center;">Tidak Terlaksana</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proker as $p) : ?>
                    <tr>
                        <td><?= $p['ID_PROKER'] ?></td>
                        <td><span class="badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid rgba(29, 78, 216, 0.1); padding: 4px 8px; border-radius: 6px; font-weight: 600;"><?= $p['NAMA_DEPARTEMEN'] ?></span></td>
                        <td><strong><?= $p['NAMA_PROKER'] ?></strong></td>
                        <td>
                            <?= htmlspecialchars($p['WAKTU_PELAKSANAAN'] ?? '-') ?>
                            <?php if (!empty($p['TANGGAL_MULAI'])): ?>
                                <br><small style="color: var(--text-muted); font-size: 0.76rem;"><i class="fa-regular fa-calendar-days" style="font-size: 0.7rem;"></i> <?= $formatTanggalIndoFull($p['TANGGAL_MULAI']) ?> - <?= $formatTanggalIndoFull($p['TANGGAL_SELESAI']) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($p['PENANGGUNG_JAWAB'] ?: '-') ?></td>
                        <td style="text-align: center;">
                            <?php if ($p['STATUS'] == 'Terlaksana') : ?>
                                <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 3px 8px; border-radius: 6px; font-weight: bold; font-size: 0.95rem;">✓ Terlaksana</span>
                            <?php else : ?>
                                <span style="color: #94a3b8; font-size: 0.85rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if ($p['STATUS'] == 'Tidak Terlaksana') : ?>
                                <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); padding: 3px 8px; border-radius: 6px; font-weight: bold; font-size: 0.95rem;">✗ Gagal</span>
                            <?php else : ?>
                                <span style="color: #94a3b8; font-size: 0.85rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="<?= base_url('transaksi/proker/detail/' . $p['ID_PROKER']) ?>" class="btn btn-sm btn-success" title="Kelola Kepanitiaan/Partisipan"><i class="fa-solid fa-users"></i> Plotting</a>
                                <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($p)) ?>)" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="<?= base_url('transaksi/proker/delete/' . $p['ID_PROKER']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<?php
// Closure to check if the program kerja falls within a specific month
$isMonthActive = function($waktu, $monthKey) {
    if (empty($waktu)) return false;
    $waktuLower = strtolower($waktu);
    
    $keys = [];
    if ($monthKey == 1) $keys = ['januari', 'jan'];
    elseif ($monthKey == 2) $keys = ['februari', 'feb'];
    elseif ($monthKey == 3) $keys = ['maret', 'mar'];
    elseif ($monthKey == 4) $keys = ['april', 'apr'];
    elseif ($monthKey == 5) $keys = ['mei'];
    elseif ($monthKey == 6) $keys = ['juni', 'jun'];
    elseif ($monthKey == 7) $keys = ['juli', 'jul'];
    elseif ($monthKey == 8) $keys = ['agustus', 'ags', 'agu'];
    elseif ($monthKey == 9) $keys = ['september', 'sep'];
    elseif ($monthKey == 10) $keys = ['oktober', 'okt'];
    elseif ($monthKey == 11) $keys = ['november', 'nov'];
    elseif ($monthKey == 12) $keys = ['desember', 'des'];
    
    foreach ($keys as $k) {
        if (strpos($waktuLower, $k) !== false) {
            return true;
        }
    }
    
    // Check ranges (e.g., Maret - Mei)
    $getMonthIndex = function($str) {
        $str = trim(strtolower($str));
        $months = [
            ['januari', 'jan'],
            ['februari', 'feb'],
            ['maret', 'mar'],
            ['april', 'apr'],
            ['mei'],
            ['juni', 'jun'],
            ['juli', 'jul'],
            ['agustus', 'ags', 'agu'],
            ['september', 'sep'],
            ['oktober', 'okt'],
            ['november', 'nov'],
            ['desember', 'des']
        ];
        foreach ($months as $idx => $keys) {
            foreach ($keys as $k) {
                if (strpos($str, $k) !== false) {
                    return $idx + 1;
                }
            }
        }
        return 0;
    };

    $delimiters = ['-', ' s/d ', ' sampai ', ' s.d. '];
    foreach ($delimiters as $delim) {
        if (strpos($waktuLower, $delim) !== false) {
            $parts = explode($delim, $waktuLower);
            if (count($parts) == 2) {
                $startMonth = $getMonthIndex($parts[0]);
                $endMonth = $getMonthIndex($parts[1]);
                if ($startMonth > 0 && $endMonth > 0) {
                    if ($startMonth <= $endMonth) {
                        return ($monthKey >= $startMonth && $monthKey <= $endMonth);
                    } else {
                        return ($monthKey >= $startMonth || $monthKey <= $endMonth);
                    }
                }
            }
        }
    }
    return false;
};
?>

<div id="gantt-tab-content" style="display: none;">
<div class="glass-panel" style="margin-top: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 15px;">
        <div>
            <h3>Visualisasi Jadwal Program Kerja (Gantt Chart)</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px;">Representasi timeline pelaksanaan program kerja periode berjalan.</p>
        </div>
        <!-- Gantt Legend -->
        <div style="display: flex; gap: 15px; align-items: center; background: var(--border-light); padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border-color); font-size: 0.82rem;">
            <span style="color: var(--text-muted); font-weight: 600; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">Status:</span>
            <div style="display: flex; align-items: center; gap: 6px;">
                <div class="gantt-bar bg-blue-glow" style="width: 28px; height: 16px; border-radius: 8px; font-size: 0.6rem;"><i class="fa-solid fa-check"></i></div>
                <span style="font-weight: 600; color: var(--text-main);">Terlaksana</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <div class="gantt-bar gantt-bar-pending bg-blue-glow" style="width: 28px; height: 16px; border-radius: 8px;"></div>
                <span style="font-weight: 600; color: var(--text-main);">Belum Terlaksana</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <div class="gantt-bar gantt-bar-failed" style="width: 28px; height: 16px; border-radius: 8px; font-size: 0.6rem;"><i class="fa-solid fa-xmark"></i></div>
                <span style="font-weight: 600; color: var(--text-main);">Tidak Terlaksana</span>
            </div>
        </div>
    </div>
    
    <div style="overflow-x: auto;">
        <table class="gantt-table" style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid var(--border-light);">
                    <th style="padding: 12px 16px; text-align: left; width: 280px; font-weight: 600; color: #475569;">Program Kerja</th>
                    <?php 
                    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                    foreach ($months as $m): ?>
                        <th style="padding: 12px 8px; text-align: center; font-weight: 600; color: #475569; font-size: 0.8rem; border-left: 1px solid #f1f5f9;"><?= $m ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proker as $p): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 16px; vertical-align: middle;">
                            <div style="font-weight: 600; font-size: 0.88rem; color: #1e293b;"><?= $p['NAMA_PROKER'] ?></div>
                            <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 2px;">
                                <?= $p['NAMA_DEPARTEMEN'] ?>
                                <?php if (!empty($p['TANGGAL_MULAI'])): ?>
                                    | <i class="fa-regular fa-calendar-days" style="font-size: 0.65rem;"></i> <?= $formatTanggalIndo($p['TANGGAL_MULAI']) ?> - <?= $formatTanggalIndo($p['TANGGAL_SELESAI']) ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <?php 
                        // Assign custom colors based on department ID
                        $colorClass = 'bg-blue-glow';
                        if ($p['ID_DEPARTEMEN'] == 'HM') $colorClass = 'bg-blue-glow';
                        elseif ($p['ID_DEPARTEMEN'] == 'KM') $colorClass = 'bg-indigo-glow';
                        elseif ($p['ID_DEPARTEMEN'] == 'MS') $colorClass = 'bg-emerald-glow';
                        elseif ($p['ID_DEPARTEMEN'] == 'KK') $colorClass = 'bg-violet-glow';
                        elseif ($p['ID_DEPARTEMEN'] == 'PB') $colorClass = 'bg-orange-glow';
                        elseif ($p['ID_DEPARTEMEN'] == 'PM') $colorClass = 'bg-pink-glow';
                        elseif ($p['ID_DEPARTEMEN'] == 'PA') $colorClass = 'bg-rose-glow';
                        else $colorClass = 'bg-slate-glow';
                        
                        for ($mIndex = 1; $mIndex <= 12; $mIndex++): 
                            // Calculate month activity
                            $active = false;
                            if (!empty($p['TANGGAL_MULAI']) && !empty($p['TANGGAL_SELESAI'])) {
                                $startMonth = (int)date('n', strtotime($p['TANGGAL_MULAI']));
                                $endMonth = (int)date('n', strtotime($p['TANGGAL_SELESAI']));
                                $startYear = (int)date('Y', strtotime($p['TANGGAL_MULAI']));
                                $endYear = (int)date('Y', strtotime($p['TANGGAL_SELESAI']));
                                
                                if ($startYear == $endYear) {
                                    $active = ($mIndex >= $startMonth && $mIndex <= $endMonth);
                                } else {
                                    $active = ($mIndex >= $startMonth || $mIndex <= $endMonth);
                                }
                            } else {
                                $active = $isMonthActive($p['WAKTU_PELAKSANAAN'], $mIndex);
                            }
                            
                            // Determine status-specific classes and icons
                            $statusClass = '';
                            $barIcon = '';
                            $tooltipStatus = '';
                            
                            if ($p['STATUS'] == 'Terlaksana') {
                                $statusClass = ''; // uses default solid glow class
                                $barIcon = '<i class="fa-solid fa-check" style="font-size: 0.65rem;"></i>';
                                $tooltipStatus = 'Terlaksana';
                            } elseif ($p['STATUS'] == 'Tidak Terlaksana') {
                                $statusClass = 'gantt-bar-failed';
                                $barIcon = '<i class="fa-solid fa-xmark" style="font-size: 0.65rem;"></i>';
                                $tooltipStatus = 'Tidak Terlaksana';
                            } else {
                                $statusClass = 'gantt-bar-pending';
                                $barIcon = ''; // keep empty for clean planned look
                                $tooltipStatus = 'Belum Terlaksana';
                            }
                        ?>
                            <td style="padding: 8px 4px; text-align: center; border-left: 1px solid #f1f5f9; vertical-align: middle;">
                                <?php if ($active): ?>
                                    <div class="gantt-bar <?= $colorClass ?> <?= $statusClass ?>" style="height: 20px; border-radius: 10px;" title="<?= htmlspecialchars($p['NAMA_PROKER']) ?> (<?= $tooltipStatus ?>: <?= !empty($p['TANGGAL_MULAI']) ? $formatTanggalIndoFull($p['TANGGAL_MULAI']) . ' - ' . $formatTanggalIndoFull($p['TANGGAL_SELESAI']) : htmlspecialchars($p['WAKTU_PELAKSANAAN']) ?>)">
                                        <?= $barIcon ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openEditModal(proker) {
    document.getElementById('edit_ID_PROKER').value = proker.ID_PROKER;
    document.getElementById('edit_ID_DEPARTEMEN').value = proker.ID_DEPARTEMEN;
    document.getElementById('edit_NAMA_PROKER').value = proker.NAMA_PROKER;
    document.getElementById('edit_WAKTU_PELAKSANAAN').value = proker.WAKTU_PELAKSANAAN;
    document.getElementById('edit_TANGGAL_MULAI').value = proker.TANGGAL_MULAI || '';
    document.getElementById('edit_TANGGAL_SELESAI').value = proker.TANGGAL_SELESAI || '';
    document.getElementById('edit_PENANGGUNG_JAWAB').value = proker.PENANGGUNG_JAWAB || '';
    document.getElementById('edit_STATUS').value = proker.STATUS || 'Belum Terlaksana';
    
    // Set form action
    document.getElementById('editProkerForm').action = '<?= base_url('transaksi/proker/update') ?>/' + proker.ID_PROKER;
    
    // Display modal
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

function switchTab(tabName) {
    const tableBtn = document.getElementById('tab-table-btn');
    const ganttBtn = document.getElementById('tab-gantt-btn');
    const tableContent = document.getElementById('table-tab-content');
    const ganttContent = document.getElementById('gantt-tab-content');
    
    if (tabName === 'table') {
        tableBtn.style.background = '#1e3a8a';
        tableBtn.style.color = '#ffffff';
        tableBtn.style.boxShadow = '0 4px 6px -1px rgba(30, 58, 138, 0.25)';
        
        ganttBtn.style.background = 'transparent';
        ganttBtn.style.color = 'var(--text-muted)';
        ganttBtn.style.boxShadow = 'none';
        
        tableContent.style.display = 'block';
        ganttContent.style.display = 'none';
        
        localStorage.setItem('proker_active_tab', 'table');
    } else {
        ganttBtn.style.background = '#1e3a8a';
        ganttBtn.style.color = '#ffffff';
        ganttBtn.style.boxShadow = '0 4px 6px -1px rgba(30, 58, 138, 0.25)';
        
        tableBtn.style.background = 'transparent';
        tableBtn.style.color = 'var(--text-muted)';
        tableBtn.style.boxShadow = 'none';
        
        tableContent.style.display = 'none';
        ganttContent.style.display = 'block';
        
        localStorage.setItem('proker_active_tab', 'gantt');
    }
}

// Restore active tab on load
document.addEventListener('DOMContentLoaded', () => {
    const activeTab = localStorage.getItem('proker_active_tab') || 'table';
    switchTab(activeTab);
});
</script>
<?= $this->endSection() ?>
