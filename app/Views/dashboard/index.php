<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
// Fallback / mockup data for empty states to match mockup image 2
$hasRealData = !empty($chartLabels);
$displayLabels = $hasRealData ? $chartLabels : ['PSDM', 'DIKBUD', 'KOMINFO', 'HUBLU'];
$displayValues = $hasRealData ? $chartValues : [64, 58, 42, 36];
$totalMembers = array_sum($displayValues);

// Actual proker statistics from controller
$totalProker = isset($totalProker) ? $totalProker : 60;
$terlaksanaProker = isset($terlaksanaProker) ? $terlaksanaProker : 18;
$tidakTerlaksanaProker = isset($tidakTerlaksanaProker) ? $tidakTerlaksanaProker : 2;
$belumTerlaksanaProker = isset($belumTerlaksanaProker) ? $belumTerlaksanaProker : 40;

$progressPct = $totalProker > 0 ? round(($terlaksanaProker / $totalProker) * 100) : 0;

$formatTanggalIndo = function($dateStr) {
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

<div class="page-header-container">
    <div class="page-header-info">
        <h2>Overview Dashboard</h2>
        <p>Ringkasan operasional dan statistik HIMAPROSIF periode berjalan.</p>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('laporan') ?>" class="btn btn-secondary">
            <i class="fa-solid fa-download"></i> Ekspor Laporan
        </a>
        <a href="<?= base_url('transaksi/proker') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Program
        </a>
    </div>
</div>

<div class="stats-grid">
    <!-- Stat 1: Total Anggota Aktif -->
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Total Anggota Aktif</span>
            <div class="stat-card-icon blue">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <div class="stat-card-body">
            <span class="stat-card-value"><?= $totalAnggotaAktif > 0 ? $totalAnggotaAktif : 248 ?></span>
            <span class="stat-card-trend">
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.65rem;"></i> +12%
            </span>
        </div>
        <div class="stat-card-footer">
            <span>Dari <?= $totalAnggotaTerdaftar > 0 ? $totalAnggotaTerdaftar : 260 ?> total terdaftar</span>
        </div>
    </div>

    <!-- Stat 2: Status Program Kerja -->
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Status Program Kerja</span>
            <div class="stat-card-icon slate">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
        </div>
        <div class="stat-card-body" style="justify-content: space-between; align-items: flex-end; width: 100%; margin-bottom: 8px;">
            <div>
                <span class="stat-card-value" style="font-size: 1.8rem; font-weight: 800; color: #1e3a8a;"><?= $terlaksanaProker ?></span>
                <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;"> Terlaksana</span>
                <span style="font-size: 1.1rem; color: var(--text-muted); font-weight: 500; margin: 0 4px;">/</span>
                <span style="font-size: 1.3rem; font-weight: 700; color: #475569;"><?= $totalProker ?></span>
                <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;"> Total</span>
            </div>
            <span style="font-size: 0.8rem; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 4px 8px; border-radius: 6px;">Periode Aktif</span>
        </div>
        
        <!-- Status Breakdown Grid -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; font-size: 0.72rem; margin: 8px 0; border-top: 1px solid var(--border-light); padding-top: 8px;">
            <div style="text-align: center;">
                <span style="color: #10b981; font-weight: 700; display: block;"><?= $terlaksanaProker ?></span>
                <span style="color: var(--text-muted);">Terlaksana</span>
            </div>
            <div style="text-align: center; border-left: 1px solid var(--border-light); border-right: 1px solid var(--border-light);">
                <span style="color: #ef4444; font-weight: 700; display: block;"><?= $tidakTerlaksanaProker ?></span>
                <span style="color: var(--text-muted);">Gagal</span>
            </div>
            <div style="text-align: center;">
                <span style="color: #3b82f6; font-weight: 700; display: block;"><?= $belumTerlaksanaProker ?></span>
                <span style="color: var(--text-muted);">Belum Mulai</span>
            </div>
        </div>

        <div class="stat-card-progress" style="margin-top: 8px;">
            <div class="progress-bar-container" style="height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                <div class="progress-bar-fill" style="width: <?= $progressPct ?>%; height: 100%; background: #1e3a8a; border-radius: 3px;"></div>
            </div>
            <div class="stat-card-footer" style="margin-top: 4px; display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-muted);">
                <span>Progress Penyelesaian</span>
                <span style="font-weight: 700; color: #1e3a8a;"><?= $progressPct ?>%</span>
            </div>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Donut Chart Card -->
    <div class="glass-panel" style="margin-bottom: 0;">
        <div class="card-header-flex">
            <div>
                <h3>Sebaran Anggota per Departemen</h3>
                <p>Distribusi keaktifan anggota berdasarkan penempatan departemen.</p>
            </div>
            <i class="fa-solid fa-sliders" style="color: var(--text-muted); cursor: pointer; font-size: 1rem;" title="Filter"></i>
        </div>
        
        <div class="chart-container">
            <div class="chart-wrapper">
                <canvas id="deptChart"></canvas>
                <div class="chart-center-text">
                    <h4><?= $totalMembers ?></h4>
                    <p>Total</p>
                </div>
            </div>
            
            <div class="chart-legend">
                <?php 
                $colors = ['#1e3a8a', '#10b981', '#2563eb', '#64748b', '#a855f7', '#ec4899', '#0ea5e9'];
                foreach ($displayLabels as $index => $label): 
                    $val = $displayValues[$index];
                    $pct = $totalMembers > 0 ? round(($val / $totalMembers) * 100) : 0;
                    $color = $colors[$index % count($colors)];
                ?>
                    <div class="chart-legend-item">
                        <div class="chart-legend-label">
                            <span class="chart-legend-color" style="background: <?= $color ?>;"></span>
                            <span><?= esc($label) ?></span>
                        </div>
                        <div class="chart-legend-values">
                            <span class="chart-legend-count"><?= $val ?></span>
                            <span class="chart-legend-pct"><?= $pct ?>%</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Activity Timeline Card -->
    <div class="glass-panel" style="margin-bottom: 0; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div class="card-header-flex">
                <h3>Timeline Program Kerja</h3>
            </div>
            
            <div class="timeline" style="margin-top: 15px;">
                <?php if (!empty($latestProkerList)): ?>
                    <!-- Display dynamic activities if data exists -->
                    <?php 
                    $markerColors = ['blue', 'emerald', 'orange', 'violet', 'pink'];
                    foreach ($latestProkerList as $index => $p): 
                        $color = $markerColors[$index % count($markerColors)];
                    ?>
                        <div class="timeline-item">
                            <span class="timeline-marker <?= $color ?>"></span>
                            <div class="timeline-content">
                                <p style="margin: 0; font-weight: 600; color: #1e293b;"><?= esc($p['NAMA_PROKER']) ?></p>
                                <p style="font-size: 0.78rem; margin: 2px 0; color: var(--text-muted);">
                                    Departemen: <strong><?= esc($p['NAMA_DEPARTEMEN']) ?></strong> | PJ: <strong><?= esc($p['PENANGGUNG_JAWAB'] ?: '-') ?></strong>
                                </p>
                                <small style="display: block; margin-top: 4px; color: #64748b;">
                                    <i class="fa-regular fa-calendar-days"></i> <?= $formatTanggalIndo($p['TANGGAL_MULAI']) ?> s/d <?= $formatTanggalIndo($p['TANGGAL_SELESAI']) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback to Mock timeline items if database is empty -->
                    <div class="timeline-item">
                        <span class="timeline-marker blue"></span>
                        <div class="timeline-content">
                            <p>Program kerja <strong>Kunjungan Industri & Studi Banding</strong> di bawah Departemen <strong>HUBLU</strong>.</p>
                            <small><i class="fa-regular fa-calendar-days"></i> Pelaksanaan: Juli 2025</small>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <span class="timeline-marker violet"></span>
                        <div class="timeline-content">
                            <p>Program kerja <strong>Workshop Web Development & UI/UX</strong> di bawah Departemen <strong>KOMINFO</strong>.</p>
                            <small><i class="fa-regular fa-calendar-days"></i> Pelaksanaan: Juni 2025</small>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <span class="timeline-marker orange"></span>
                        <div class="timeline-content">
                            <p>Program kerja <strong>Seminar Teknologi & Pendidikan Kreatif</strong> di bawah Departemen <strong>DIKBUD</strong>.</p>
                            <small><i class="fa-regular fa-calendar-days"></i> Pelaksanaan: Mei 2025</small>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 20px; border-top: 1px solid var(--border-light); padding-top: 15px;">
            <a href="<?= base_url('transaksi/proker') ?>" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 0.85rem;" hover="text-decoration: underline;">
                Lihat Semua Program Kerja
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('deptChart').getContext('2d');
    
    const colors = [
        '#1e3a8a', // Dark Navy
        '#10b981', // Emerald
        '#2563eb', // Royal Blue
        '#64748b', // Gray
        '#a855f7', // Purple
        '#ec4899', // Pink
        '#0ea5e9'  // Sky Blue
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($displayLabels) ?>,
            datasets: [{
                data: <?= json_encode($displayValues) ?>,
                backgroundColor: colors,
                borderWidth: 4,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Using custom HTML legend for exact mockup styling
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ` ${context.label}: ${context.raw} Anggota`;
                        }
                    }
                }
            },
            cutout: '78%' // Tighter donut ring matching the premium mockup
        }
    });
});
</script>
<?= $this->endSection() ?>
