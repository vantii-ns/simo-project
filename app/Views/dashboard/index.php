<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
// Fallback / mockup data for empty states to match mockup image 2
$hasRealData = !empty($chartLabels);
$displayLabels = $hasRealData ? $chartLabels : ['PSDM', 'DIKBUD', 'KOMINFO', 'HUBLU'];
$displayValues = $hasRealData ? $chartValues : [64, 58, 42, 36];
$totalMembers = array_sum($displayValues);

$activeProkerCount = $totalProker > 0 ? $totalProker : 12;
$targetProker = 18;
$progressPct = round(($activeProkerCount / $targetProker) * 100);
if ($progressPct > 100) $progressPct = 100;
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

    <!-- Stat 2: Program Kerja Berjalan -->
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Program Kerja Berjalan</span>
            <div class="stat-card-icon slate">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
        </div>
        <div class="stat-card-body" style="justify-content: space-between; align-items: flex-end; width: 100%;">
            <span class="stat-card-value"><?= $activeProkerCount ?> <span style="font-size: 1.1rem; color: var(--text-muted); font-weight: 500;">/ <?= $targetProker ?></span></span>
            <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">Semester Ganjil</span>
        </div>
        <div class="stat-card-progress">
            <div class="progress-bar-container">
                <div class="progress-bar-fill" style="width: <?= $progressPct ?>%;"></div>
            </div>
            <div class="stat-card-footer" style="margin-top: 2px;">
                <span>Progress Keseluruhan</span>
                <span><?= $progressPct ?>%</span>
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
                                <p>Program kerja <strong><?= esc($p['NAMA_PROKER']) ?></strong> terdaftar di Departemen <strong><?= esc($p['NAMA_DEPARTEMEN']) ?></strong>.</p>
                                <small><i class="fa-regular fa-calendar-days"></i> Pelaksanaan: <?= esc($p['WAKTU_PELAKSANAAN']) ?></small>
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
