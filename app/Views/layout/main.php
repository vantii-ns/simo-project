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
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=2.1') ?>">
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
            <div class="search-container" id="searchContainer">
                <i class="fa-solid fa-magnifying-glass" id="searchIcon"></i>
                <form id="globalSearchForm" onsubmit="handleGlobalSearch(event)" style="margin: 0;">
                    <input type="text" id="globalSearchInput" placeholder="Cari anggota, proker, departemen..." autocomplete="off">
                </form>
                <!-- Dropdown Hasil Pencarian -->
                <div class="search-dropdown" id="searchDropdown">
                    <div class="search-dropdown-inner" id="searchDropdownInner">
                        <!-- Diisi oleh JS -->
                    </div>
                </div>
            </div>

            <!-- Topbar actions -->
            <div class="topbar-actions">
                <div class="dropdown-wrapper">
                    <button class="icon-btn" id="btnNotification" title="Notifikasi">
                        <i class="fa-regular fa-bell"></i>
                        <span class="badge-dot" id="notiBadge"></span>
                    </button>
                    <!-- Notification Dropdown -->
                    <div class="topbar-dropdown" id="dropdownNotification">
                        <div class="dropdown-header">
                            <h5>Notifikasi</h5>
                            <button class="dropdown-clear-btn" id="btnClearNoti">Tandai dibaca</button>
                        </div>
                        <div class="dropdown-body" id="notiList">
                            <div class="notification-item">
                                <div class="notification-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary);">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">Program kerja baru <strong>Kunjungan Industri</strong> ditambahkan</div>
                                    <div class="notification-time">10 menit yang lalu</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">Rapor pengurus periode berjalan siap diekspor</div>
                                    <div class="notification-time">2 jam yang lalu</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">Update data: 5 Anggota baru terdaftar di departemen <strong>PSDM</strong></div>
                                    <div class="notification-time">1 hari yang lalu</div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-footer">
                            <a href="<?= base_url('transaksi/proker') ?>">Lihat Semua Aktivitas</a>
                        </div>
                    </div>
                </div>

                <div class="dropdown-wrapper">
                    <button class="icon-btn" id="btnHelp" title="Bantuan">
                        <i class="fa-regular fa-circle-question"></i>
                    </button>
                    <!-- Help Dropdown -->
                    <div class="topbar-dropdown" id="dropdownHelp" style="width: 240px;">
                        <div class="dropdown-header">
                            <h5>Pusat Bantuan</h5>
                        </div>
                        <div class="dropdown-body">
                            <button class="help-menu-item" id="btnOpenGuideModal">
                                <i class="fa-solid fa-book-open"></i> Panduan SIMO
                            </button>
                            <a href="https://wa.me/6287873390072" target="_blank" rel="noopener noreferrer" class="help-menu-item" style="text-decoration:none;">
                                <i class="fa-solid fa-comments"></i> Hubungi Support
                            </a>
                            <button class="help-menu-item" id="btnOpenAbout">
                                <i class="fa-solid fa-circle-info"></i> Tentang Aplikasi
                            </button>
                        </div>
                    </div>
                </div>
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
    // ════════════════════════════════════════════════════
    // GLOBAL SEARCH — AJAX Dropdown
    // ════════════════════════════════════════════════════
    (function () {
        const BASE_URL = '<?= base_url() ?>';
        const input    = document.getElementById('globalSearchInput');
        const dropdown = document.getElementById('searchDropdown');
        const inner    = document.getElementById('searchDropdownInner');
        const icon     = document.getElementById('searchIcon');

        if (!input) return;

        let debounceTimer = null;

        const typeIcons = {
            proker:     { icon: 'fa-briefcase',  color: '#2563eb', label: 'Program Kerja' },
            anggota:    { icon: 'fa-user',        color: '#10b981', label: 'Anggota' },
            departemen: { icon: 'fa-sitemap',     color: '#8b5cf6', label: 'Departemen' },
        };

        const statusColors = {
            'Terlaksana':        { bg: '#d1fae5', color: '#065f46' },
            'Tidak Terlaksana':  { bg: '#fef2f2', color: '#991b1b' },
            'Belum Terlaksana':  { bg: '#eff6ff', color: '#1e40af' },
        };

        function showDropdown(html) {
            inner.innerHTML = html;
            dropdown.classList.add('active');
        }

        function hideDropdown() {
            dropdown.classList.remove('active');
        }

        function renderResults(data) {
            if (!data.results || data.results.length === 0) {
                showDropdown(`
                    <div class="search-empty">
                        <i class="fa-solid fa-magnifying-glass" style="font-size:1.4rem;color:#94a3b8;margin-bottom:8px;"></i>
                        <p>Tidak ada hasil untuk <strong>"${escHtml(data.keyword)}"</strong></p>
                    </div>
                `);
                return;
            }

            // Kelompokkan per type
            const grouped = {};
            data.results.forEach(r => {
                if (!grouped[r.type]) grouped[r.type] = [];
                grouped[r.type].push(r);
            });

            let html = '';
            for (const [type, items] of Object.entries(grouped)) {
                const meta = typeIcons[type] || { icon: 'fa-circle', color: '#64748b', label: type };
                html += `<div class="search-group-label"><i class="fa-solid ${meta.icon}" style="color:${meta.color}"></i> ${meta.label}</div>`;
                items.forEach(item => {
                    let statusBadge = '';
                    if (item.status && statusColors[item.status]) {
                        const sc = statusColors[item.status];
                        statusBadge = `<span class="search-status-badge" style="background:${sc.bg};color:${sc.color};">${item.status}</span>`;
                    }
                    html += `
                        <a href="${item.url}" class="search-result-item">
                            <div class="search-result-icon" style="background:${meta.color}20;color:${meta.color}">
                                <i class="fa-solid ${meta.icon}"></i>
                            </div>
                            <div class="search-result-text">
                                <div class="search-result-label">${escHtml(item.label)} ${statusBadge}</div>
                                <div class="search-result-sub">${escHtml(item.sub)}</div>
                            </div>
                            <i class="fa-solid fa-arrow-right search-result-arrow"></i>
                        </a>`;
                });
            }

            html += `<div class="search-footer">Menampilkan ${data.results.length} hasil untuk "${escHtml(data.keyword)}"</div>`;
            showDropdown(html);
        }

        function escHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g,'&amp;').replace(/</g,'&lt;')
                .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }

        function doSearch(q) {
            if (q.length < 2) { hideDropdown(); return; }
            icon.className = 'fa-solid fa-spinner fa-spin';
            fetch(`${BASE_URL}search?q=${encodeURIComponent(q)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                icon.className = 'fa-solid fa-magnifying-glass';
                renderResults(data);
            })
            .catch(() => {
                icon.className = 'fa-solid fa-magnifying-glass';
                hideDropdown();
            });
        }

        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            const q = this.value.trim();
            if (q.length < 2) { hideDropdown(); return; }
            debounceTimer = setTimeout(() => doSearch(q), 300);
        });

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function (e) {
            if (!document.getElementById('searchContainer').contains(e.target)) {
                hideDropdown();
            }
        });

        // Buka kembali bila fokus & ada isi
        input.addEventListener('focus', function () {
            if (this.value.trim().length >= 2 && inner.innerHTML.trim() !== '') {
                dropdown.classList.add('active');
            }
        });
    })();

    function handleGlobalSearch(e) { e.preventDefault(); }
    </script>
    <!-- Modal Panduan SIMO -->
    <?php $guideRole = session()->get('user_role') ?? 'user'; ?>
    <div class="simo-modal" id="guideModal">
        <div class="simo-modal-content">
            <div class="simo-modal-header">
                <h3>
                    <i class="fa-solid fa-book-open"></i> 
                    Panduan SIMO (<?= $guideRole === 'admin' ? 'Administrator' : 'Viewer' ?>)
                </h3>
                <button class="simo-modal-close" id="btnCloseGuideModal">&times;</button>
            </div>
            <div class="simo-modal-body">
                <div class="simo-modal-sidebar">
                    <button class="simo-modal-tab-btn active" data-tab="tab-overview">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard Overview
                    </button>
                    <button class="simo-modal-tab-btn" data-tab="tab-anggota">
                        <i class="fa-solid fa-users"></i> Data Anggota
                    </button>
                    <button class="simo-modal-tab-btn" data-tab="tab-proker">
                        <i class="fa-solid fa-briefcase"></i> Program Kerja
                    </button>
                    <button class="simo-modal-tab-btn" data-tab="tab-laporan">
                        <i class="fa-solid fa-file-pdf"></i> Cetak Laporan
                    </button>
                </div>
                <div class="simo-modal-main-content">
                    <!-- Tab: Overview -->
                    <div class="simo-modal-tab-panel active" id="tab-overview">
                        <h4>Dashboard Overview</h4>
                        <p>Dashboard SIMO menyajikan ringkasan operasional dan statistik visual kepengurusan HIMAPROSIF secara real-time.</p>
                        <ul>
                            <li><strong>Total Anggota Aktif:</strong> Jumlah anggota unik yang terdaftar pada kepengurusan berjalan.</li>
                            <li><strong>Status Program Kerja:</strong> Diagram penyelesaian dan status program kerja (Terlaksana, Gagal, Belum Terlaksana).</li>
                            <li><strong>Sebaran Anggota:</strong> Visualisasi persentase keaktifan anggota berdasarkan departemen.</li>
                            <li><strong>Timeline Program Kerja:</strong> Daftar program kerja terdekat yang diurutkan secara kronologis.</li>
                        </ul>
                    </div>
                    
                    <!-- Tab: Anggota -->
                    <div class="simo-modal-tab-panel" id="tab-anggota">
                        <?php if ($guideRole === 'admin'): ?>
                            <h4>Mengelola Data Anggota (Admin)</h4>
                            <p>Anda memiliki hak akses penuh untuk melakukan manajemen data seluruh pengurus.</p>
                            <ul>
                                <li><strong>Tambah Anggota:</strong> Klik tombol "+ Tambah Anggota" untuk memasukkan NIM, Nama, Email, No. HP, dan Jenis Kelamin.</li>
                                <li><strong>Ubah Data:</strong> Klik ikon pensil kuning pada baris anggota untuk mengupdate data diri pengurus.</li>
                                <li><strong>Hapus Anggota:</strong> Klik ikon tempat sampah merah untuk menghapus pengurus dari database secara permanen.</li>
                                <li><strong>Pencarian Cepat:</strong> Cari data pengurus secara instan menggunakan kolom filter search bar.</li>
                            </ul>
                        <?php else: ?>
                            <h4>Melihat Data Anggota (Viewer)</h4>
                            <p>Hak akses Anda adalah peninjau (read-only). Anda dapat melihat database seluruh pengurus aktif.</p>
                            <ul>
                                <li><strong>Melihat Daftar Anggota:</strong> Menelusuri seluruh data NIM, nama lengkap, departemen, email, dan no HP pengurus.</li>
                                <li><strong>Pencarian Cepat:</strong> Masukkan nama atau NIM pada search bar di atas tabel untuk memfilter data anggota secara cepat.</li>
                                <li><em style="color:var(--text-muted);">*Catatan: Hak akses Viewer tidak diizinkan untuk menambah, mengedit, atau menghapus data.*</em></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Tab: Proker -->
                    <div class="simo-modal-tab-panel" id="tab-proker">
                        <?php if ($guideRole === 'admin'): ?>
                            <h4>Program Kerja & Kepanitiaan (Admin)</h4>
                            <p>Kelola program kerja divisi beserta susunan kepanitiaan di masing-masing program.</p>
                            <ul>
                                <li><strong>Tambah Program Kerja:</strong> Klik tombol "+ Tambah Program" untuk memasukkan nama proker, departemen penanggung jawab, sasaran, estimasi anggaran, tanggal pelaksanaan, dan status.</li>
                                <li><strong>Edit & Hapus:</strong> Gunakan tombol aksi yang tersedia untuk mengupdate status program kerja atau menghapus program kerja.</li>
                                <li><strong>Manajemen Partisipan:</strong> Buka rincian detail proker untuk mendaftarkan dan memetakan kepanitiaan anggota pengurus (Ketua Pelaksana, Sekretaris, Bendahara, dsb).</li>
                            </ul>
                        <?php else: ?>
                            <h4>Program Kerja & Kepanitiaan (Viewer)</h4>
                            <p>Pantau keterlaksanaan program kerja divisi HIMAPROSIF selama masa kepengurusan berjalan.</p>
                            <ul>
                                <li><strong>Melihat Program Kerja:</strong> Meninjau seluruh daftar program kerja divisi beserta detail sasaran dan status keterlaksanaannya.</li>
                                <li><strong>Detail Kepanitiaan:</strong> Klik opsi detail program kerja untuk melihat susunan struktur panitia dan penanggung jawab kegiatan.</li>
                                <li><strong>Gantt Chart Jadwal:</strong> Meninjau grafik visualisasi jadwal dan durasi pelaksanaan program kerja organisasi.</li>
                                <li><em style="color:var(--text-muted);">*Catatan: Perubahan status proker dan kepanitiaan hanya dapat dilakukan oleh Administrator.*</em></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Tab: Laporan -->
                    <div class="simo-modal-tab-panel" id="tab-laporan">
                        <h4>Pencetakan & Ekspor Dokumen</h4>
                        <p>Ekspor dokumen administratif resmi HIMAPROSIF langsung dalam bentuk file PDF siap cetak.</p>
                        <ul>
                            <li><strong>Surat Keputusan (SK) Kepengurusan:</strong> Cetak struktur fungsional kepengurusan yang disahkan.</li>
                            <li><strong>Katalog Program Kerja:</strong> Rekapitulasi proker berjalan beserta departemen penanggung jawab dan status keterlaksanaannya.</li>
                            <li><strong>Rapor Kinerja Pengurus:</strong> Menghasilkan rekap nilai keterlibatan dan kontribusi pengurus dalam berbagai kepanitiaan.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="simo-modal-footer">
                <button class="btn btn-secondary btn-sm" id="btnCloseGuideModal2">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Tentang SIMO -->
    <div class="simo-modal" id="aboutModal">
        <div class="simo-modal-content" style="max-width: 420px; min-height: auto;">
            <div class="simo-modal-header">
                <h3><i class="fa-solid fa-circle-info"></i> Tentang Aplikasi</h3>
                <button class="simo-modal-close" id="btnCloseAboutModal">&times;</button>
            </div>
            <div class="simo-modal-body" style="min-height: auto; padding: 24px; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 12px;">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="SIMO Logo" style="width: 70px; height: 70px; object-fit: contain;">
                <div>
                    <h4 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: var(--text-main);">SIMO</h4>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 2px 0;">Sistem Informasi Manajemen Organisasi</p>
                    <p style="font-size: 0.82rem; font-weight: 700; color: var(--primary);">Versi 2.1 - HIMAPROSIF</p>
                </div>
                <p style="font-size: 0.8rem; line-height: 1.5; color: var(--text-muted); border-top: 1px solid var(--border-light); padding-top: 12px; margin: 0;">
                    Aplikasi manajemen terpadu kepengurusan, departemen, program kerja, partisipan kepanitiaan, serta pelaporan otomatis HIMAPROSIF.
                </p>
            </div>
            <div class="simo-modal-footer">
                <button class="btn btn-secondary btn-sm" id="btnCloseAboutModal2">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Logic Bantuan & Notifikasi -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnNoti = document.getElementById('btnNotification');
        const dropNoti = document.getElementById('dropdownNotification');
        const notiBadge = document.getElementById('notiBadge');
        const btnClearNoti = document.getElementById('btnClearNoti');
        const notiList = document.getElementById('notiList');

        const btnHelp = document.getElementById('btnHelp');
        const dropHelp = document.getElementById('dropdownHelp');

        const guideModal = document.getElementById('guideModal');
        const btnOpenGuide = document.getElementById('btnOpenGuideModal');
        const closeGuideBtns = [
            document.getElementById('btnCloseGuideModal'),
            document.getElementById('btnCloseGuideModal2')
        ];

        const aboutModal = document.getElementById('aboutModal');
        const btnOpenAbout = document.getElementById('btnOpenAbout');
        const closeAboutBtns = [
            document.getElementById('btnCloseAboutModal'),
            document.getElementById('btnCloseAboutModal2')
        ];

        // Toggle dropdown helper
        function toggleDropdown(dropdown) {
            const isActive = dropdown.classList.contains('active');
            // Close all first
            closeAllDropdowns();
            if (!isActive) {
                dropdown.classList.add('active');
            }
        }

        function closeAllDropdowns() {
            if (dropNoti) dropNoti.classList.remove('active');
            if (dropHelp) dropHelp.classList.remove('active');
        }

        // Toggle Notifikasi
        if (btnNoti && dropNoti) {
            btnNoti.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown(dropNoti);
                // Clear badge dot when clicked
                if (notiBadge) {
                    notiBadge.style.display = 'none';
                }
            });
        }

        // Clear Notifikasi
        if (btnClearNoti) {
            btnClearNoti.addEventListener('click', function(e) {
                e.stopPropagation();
                if (notiList) {
                    notiList.innerHTML = `
                        <div style="padding: 24px; text-align: center; color: var(--text-muted); font-size: 0.82rem;">
                            <i class="fa-regular fa-bell-slash" style="font-size: 1.5rem; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                            Tidak ada notifikasi baru
                        </div>
                    `;
                }
                if (notiBadge) notiBadge.remove();
            });
        }

        // Toggle Bantuan
        if (btnHelp && dropHelp) {
            btnHelp.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown(dropHelp);
            });
        }

        // Close dropdowns on click outside
        document.addEventListener('click', function() {
            closeAllDropdowns();
        });

        // Prevent click propagation inside dropdowns
        if (dropNoti) dropNoti.addEventListener('click', e => e.stopPropagation());
        if (dropHelp) dropHelp.addEventListener('click', e => e.stopPropagation());

        // Guide Modal
        if (btnOpenGuide && guideModal) {
            btnOpenGuide.addEventListener('click', function() {
                closeAllDropdowns();
                guideModal.classList.add('active');
            });
        }

        closeGuideBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', function() {
                    guideModal.classList.remove('active');
                });
            }
        });

        // Tab switching in Guide Modal
        const tabBtns = document.querySelectorAll('.simo-modal-tab-btn');
        const tabPanels = document.querySelectorAll('.simo-modal-tab-panel');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanels.forEach(p => p.classList.remove('active'));

                this.classList.add('active');
                const panel = document.getElementById(targetTab);
                if (panel) panel.classList.add('active');
            });
        });

        // About Modal
        if (btnOpenAbout && aboutModal) {
            btnOpenAbout.addEventListener('click', function() {
                closeAllDropdowns();
                aboutModal.classList.add('active');
            });
        }

        closeAboutBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', function() {
                    aboutModal.classList.remove('active');
                });
            }
        });

        // Close modals on clicking backdrop
        window.addEventListener('click', function(e) {
            if (e.target === guideModal) guideModal.classList.remove('active');
            if (e.target === aboutModal) aboutModal.classList.remove('active');
        });
    });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
