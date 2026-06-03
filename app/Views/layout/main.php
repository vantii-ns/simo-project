<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMO - Sistem Informasi Manajemen Organisasi</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=2.0') ?>">
    <!-- Apply theme ASAP to prevent flash -->
    <script>
    (function(){
        var t = localStorage.getItem('simoTheme');
        if (t === 'dark') document.documentElement.setAttribute('data-theme','dark');
    })();
    </script>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="sidebar-header" style="gap: 12px; display: flex; align-items: center;">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="SIMO Logo" style="width: 38px; height: 38px; object-fit: contain;">
                <div class="logo-text">
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #111827; letter-spacing: 0.5px; margin: 0;">SIMO</h2>
                    <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; margin: 0;">
                        <?php
                        $sidebarRole = session()->get('user_role') ?? 'user';
                        echo $sidebarRole === 'admin' ? 'Administrator' : 'Viewer';
                        ?>
                    </p>
                </div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (url_is('dashboard*') || url_is('/')) ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-simple"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('master/anggota') ?>" class="nav-link <?= url_is('master/anggota*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-users"></i> Anggota
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/departemen') ?>" class="nav-link <?= url_is('master/departemen*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-sitemap"></i> Departemen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/jabatan') ?>" class="nav-link <?= url_is('master/jabatan*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-id-badge"></i> Jabatan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/periode') ?>" class="nav-link <?= url_is('master/periode*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-calendar"></i> Periode
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('transaksi/struktur') ?>" class="nav-link <?= url_is('transaksi/struktur*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-network-wired"></i> Struktur
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/proker') ?>" class="nav-link <?= url_is('transaksi/proker*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-briefcase"></i> Program Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/partisipan') ?>" class="nav-link <?= url_is('transaksi/partisipan*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-user-check"></i> Partisipan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('laporan') ?>" class="nav-link <?= url_is('laporan*') ? 'active' : '' ?>">
                        <i class="fa-solid fa-file-invoice"></i> Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://drive.google.com/drive/folders/1gA3ZMO1nETcziVC8xnof3ku0OlDKbOmh" target="_blank" rel="noopener noreferrer" class="nav-link">
                        <i class="fa-brands fa-google-drive"></i> Google Drive
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <?php $sidebarRole2 = session()->get('user_role') ?? 'user'; ?>
            <div style="padding: 8px 16px 12px; display:flex; align-items:center; gap:8px;">
                <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Login sebagai:</span>
                <?php if ($sidebarRole2 === 'admin'): ?>
                    <span style="font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#1e40af;color:#bfdbfe;"><i class="fa-solid fa-shield-halved" style="font-size:9px;"></i> Admin</span>
                <?php else: ?>
                    <span style="font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#f3f4f6;color:#4b5563;"><i class="fa-solid fa-eye" style="font-size:9px;"></i> User</span>
                <?php endif; ?>
            </div>
            <a href="<?= base_url('pengaturan') ?>" class="nav-link <?= url_is('pengaturan*') ? 'active' : '' ?>">
                <i class="fa-solid fa-gear"></i> Pengaturan
            </a>
            <a href="<?= base_url('logout') ?>" class="nav-link danger-link"
               onclick="return confirm('Yakin ingin keluar?')">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <!-- Search bar -->
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <form id="globalSearchForm" onsubmit="handleGlobalSearch(event)" style="margin: 0;">
                    <input type="text" id="globalSearchInput" placeholder="Cari data anggota, program..." autocomplete="off">
                </form>
            </div>

            <!-- Topbar actions -->
            <div class="topbar-actions">
                <button class="icon-btn" title="Notifikasi">
                    <i class="fa-regular fa-bell"></i>
                    <span class="badge-dot"></span>
                </button>
                <button class="icon-btn" title="Bantuan">
                    <i class="fa-regular fa-circle-question"></i>
                </button>
                <a href="<?= base_url('pengaturan') ?>" class="profile-dropdown" style="text-decoration:none;">
                    <?php
                    $sessionAvatar   = session()->get('profile_avatar');
                    $sessionUsername = session()->get('profile_username') ?? session()->get('username') ?? 'Admin';
                    $sessionRole     = session()->get('user_role') ?? 'user';
                    ?>
                    <?php if ($sessionAvatar): ?>
                        <img src="<?= base_url($sessionAvatar) ?>" alt="Avatar" id="topbarAvatar">
                    <?php else: ?>
                        <div id="topbarAvatar" style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,<?= $sessionRole==='admin' ? '#2563eb,#1e40af' : '#64748b,#475569' ?>);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0;">
                            <?= strtoupper(substr($sessionUsername, 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                    <span id="topbarUsername"><?= esc($sessionUsername) ?></span>
                    <?php if ($sessionRole === 'admin'): ?>
                        <span style="font-size:0.65rem;font-weight:700;padding:1px 6px;border-radius:20px;background:#1e40af;color:#bfdbfe;margin-left:-4px;">Admin</span>
                    <?php else: ?>
                        <span style="font-size:0.65rem;font-weight:700;padding:1px 6px;border-radius:20px;background:#f1f5f9;color:#64748b;margin-left:-4px;">User</span>
                    <?php endif; ?>
                    <i class="fa-solid fa-chevron-down"></i>
                </a>
            </div>
        </header>

        <!-- Dynamic Header (non-dashboard only) -->
        <?php if (!url_is('dashboard*') && !url_is('/')): ?>
            <?php 
            $subtitle = 'Sistem Informasi Manajemen Organisasi HIMAPROSIF.';
            if (isset($title)) {
                if (stripos($title, 'anggota') !== false) {
                    $subtitle = 'Kelola daftar anggota, data diri, dan riwayat kontak mereka.';
                } elseif (stripos($title, 'departemen') !== false) {
                    $subtitle = 'Kelola pembagian departemen dan divisi kerja organisasi.';
                } elseif (stripos($title, 'jabatan') !== false) {
                    $subtitle = 'Kelola struktur tingkat jabatan kepengurusan.';
                } elseif (stripos($title, 'periode') !== false) {
                    $subtitle = 'Kelola daftar periode kepengurusan aktif dan historis.';
                } elseif (stripos($title, 'struktur') !== false || stripos($title, 'kepengurusan') !== false) {
                    $subtitle = 'Atur kepengurusan dan penempatan anggota pada jabatan.';
                } elseif (stripos($title, 'proker') !== false || stripos($title, 'program') !== false) {
                    $subtitle = 'Kelola program kerja divisi beserta partisipan kepanitiaan.';
                } elseif (stripos($title, 'laporan') !== false) {
                    $subtitle = 'Cetak rapor pengurus, SK kepengurusan, dan katalog program kerja.';
                }
            }
            ?>
            <div class="page-header-container">
                <div class="page-header-info">
                    <h2><?= $title ?? 'Beranda' ?></h2>
                    <p><?= $subtitle ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>

    </main>

    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/main.js?v=1.3') ?>"></script>
    
    <script>
    // Pencarian Global bertindak sebagai filter tabel lokal (Pencarian Dinamis)
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('globalSearchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                // Cari tabel di dalam page
                const table = document.querySelector(".table-responsive table");
                if (table) {
                    const tr = table.getElementsByTagName("tr");
                    for (let i = 1; i < tr.length; i++) {
                        let textContent = tr[i].textContent || tr[i].innerText;
                        if (textContent.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            });
        }
    });

    // Handle form submit (cegah reload, karena search sudah realtime pakai keyup di atas)
    function handleGlobalSearch(e) {
        e.preventDefault();
    }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
