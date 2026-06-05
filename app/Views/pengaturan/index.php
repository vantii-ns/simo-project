<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$successMsg = session()->getFlashdata('success');

// Ambil role langsung dari session karena Pengaturan.php belum mengirimkannya
$userRole = session()->get('user_role');

if ($userRole === 'admin') {
    $roleLong  = 'ADMINISTRATOR';
    $roleShort = 'Admin';
    $roleForm  = 'Administrator';
} else {
    $roleLong  = 'USER';
    $roleShort = 'User';
    $roleForm  = 'User';
}
?>

<div class="settings-page">

    <?php if ($successMsg): ?>
    <div class="settings-alert settings-alert-success" id="settingsAlert">
        <i class="fa-solid fa-circle-check"></i>
        <span><?= esc($successMsg) ?></span>
        <button onclick="this.parentElement.remove()" class="alert-close"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <?php endif; ?>

    <div class="settings-layout">

        <div class="settings-sidebar-panel">
            <div class="profile-card-settings">
                <div class="profile-avatar-wrap" id="avatarWrap">
                    <?php if (!empty($avatar)): ?>
                        <img src="<?= base_url($avatar) ?>" alt="Avatar" class="profile-avatar-img" id="avatarPreview">
                    <?php else: ?>
                        <div class="profile-avatar-initials" id="avatarInitials">
                            <?= strtoupper(substr($username, 0, 2)) ?>
                        </div>
                        <img src="" alt="Avatar" class="profile-avatar-img" id="avatarPreview" style="display:none;">
                    <?php endif; ?>
                    <label for="avatarInput" class="avatar-edit-btn" title="Ubah foto profil">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                </div>
                <h3 class="profile-card-name" id="previewUsername"><?= esc($username) ?></h3>
                <p class="profile-card-role"><?= $roleLong ?> HIMAPROSIF</p>
                <p class="profile-card-bio" id="previewBio"><?= esc($bio) ?></p>

                <div class="profile-card-stats">
                    <div class="pcs-item">
                        <span class="pcs-value">2026</span>
                        <span class="pcs-label">Periode</span>
                    </div>
                    <div class="pcs-divider"></div>
                    <div class="pcs-item">
                        <span class="pcs-value"><?= $roleShort ?></span>
                        <span class="pcs-label">Role</span>
                    </div>
                </div>
            </div> <div class="theme-card">
                <div class="theme-card-header">
                    <i class="fa-solid fa-palette"></i>
                    <div>
                        <p class="theme-card-title">Tampilan</p>
                        <p class="theme-card-sub">Pilih mode yang Anda sukai</p>
                    </div>
                </div>
                <div class="theme-options">
                    <div class="theme-option <?= ($theme === 'light') ? 'selected' : '' ?>" id="themeLight" onclick="setTheme('light')">
                        <div class="theme-preview theme-preview-light">
                            <div class="tp-sidebar"></div>
                            <div class="tp-content">
                                <div class="tp-bar tp-bar-1"></div>
                                <div class="tp-bar tp-bar-2"></div>
                                <div class="tp-bar tp-bar-3"></div>
                            </div>
                        </div>
                        <span>Terang</span>
                        <i class="fa-solid fa-check theme-check"></i>
                    </div>
                    <div class="theme-option <?= ($theme === 'dark') ? 'selected' : '' ?>" id="themeDark" onclick="setTheme('dark')">
                        <div class="theme-preview theme-preview-dark">
                            <div class="tp-sidebar tp-sidebar-dark"></div>
                            <div class="tp-content tp-content-dark">
                                <div class="tp-bar tp-bar-d1"></div>
                                <div class="tp-bar tp-bar-d2"></div>
                                <div class="tp-bar tp-bar-d3"></div>
                            </div>
                        </div>
                        <span>Gelap</span>
                        <i class="fa-solid fa-check theme-check"></i>
                    </div>
                </div>
            </div>
        </div> <div class="settings-main-panel">
            

            <!-- Tabs -->
            <div class="settings-tabs">
                <button class="stab active" data-tab="profil" onclick="switchTab('profil', this)">
                    <i class="fa-solid fa-user"></i> Profil
                </button>
                <button class="stab" data-tab="akun" onclick="switchTab('akun', this)">
                    <i class="fa-solid fa-shield-halved"></i> Akun
                </button>
            </div>

            <!-- Tab: Profil -->
            <div class="stab-content active" id="tab-profil">
                <form action="<?= base_url('pengaturan/save') ?>" method="post" enctype="multipart/form-data" id="settingsForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="theme" id="hiddenTheme" value="<?= esc($theme) ?>">
                    <!-- Hidden file input -->
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">

                    <!-- Upload Section -->
                    <div class="settings-section">
                        <div class="settings-section-header">
                            <div>
                                <h4>Foto Profil</h4>
                                <p>Format JPG, PNG, atau GIF. Maksimal 2MB.</p>
                            </div>
                            <div class="avatar-actions">
                                <label for="avatarInput" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-upload"></i> Upload Foto
                                </label>
                                <button type="button" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid rgba(220,38,38,.2);" onclick="removeAvatar()">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Dasar -->
                    <div class="settings-section">
                        <h4 class="settings-section-title">Informasi Dasar</h4>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label class="form-label">Username <span class="required-dot">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa-solid fa-at input-icon"></i>
                                    <input type="text" name="username" id="usernameInput" class="form-control with-icon"
                                           value="<?= esc($username) ?>"
                                           placeholder="Masukkan username..."
                                           oninput="document.getElementById('previewUsername').textContent = this.value || 'Username'" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <div class="input-icon-wrap">
                                    <i class="fa-solid fa-crown input-icon"></i>
                                    <input type="text" class="form-control with-icon" value="<?= $roleForm ?>" readonly style="cursor:not-allowed;background:#f9fafb;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Bio / Deskripsi Singkat</label>
                            <div class="textarea-wrap">
                                <textarea name="bio" id="bioInput" class="form-control" rows="3"
                                          placeholder="Tuliskan bio singkat Anda..."
                                          oninput="document.getElementById('previewBio').textContent = this.value"><?= esc($bio) ?></textarea>
                                <span class="textarea-count" id="bioCount"><?= strlen($bio) ?>/150</span>
                            </div>
                            <p class="form-hint">Bio akan ditampilkan di kartu profil Anda.</p>
                        </div>
                    </div>

                    <!-- Informasi Organisasi (display only) -->
                    <div class="settings-section">
                        <h4 class="settings-section-title">Informasi Organisasi</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label"><i class="fa-solid fa-building-columns"></i> Organisasi</span>
                                <span class="info-value">HIMAPROSIF</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fa-solid fa-calendar"></i> Periode Aktif</span>
                                <span class="info-value">2025/2026</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fa-solid fa-clock"></i> Terakhir Login</span>
                                <span class="info-value" id="lastLoginDisplay">—</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fa-solid fa-database"></i> Sistem</span>
                                <span class="info-value">SIMO v2.0</span>
                            </div>
                        </div>
                    </div>

                    <div class="settings-form-footer">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div><!-- /#tab-profil -->

            <!-- Tab: Akun -->
            <div class="stab-content" id="tab-akun">
                <div class="settings-section">
                    <h4 class="settings-section-title">Keamanan Akun</h4>
                    <div class="security-items">
                        <div class="security-item">
                            <div class="security-item-info">
                                <i class="fa-solid fa-lock security-icon"></i>
                                <div>
                                    <p class="security-item-title">Password</p>
                                    <p class="security-item-desc">Ubah password akun administrator Anda</p>
                                </div>
                            </div>
                            <button class="btn btn-secondary btn-sm" onclick="alert('Fitur ubah password akan segera hadir.')">
                                Ubah Password
                            </button>
                        </div>
                        <div class="security-item">
                            <div class="security-item-info">
                                <i class="fa-solid fa-mobile-screen security-icon"></i>
                                <div>
                                    <p class="security-item-title">Autentikasi Dua Faktor</p>
                                    <p class="security-item-desc">Tingkatkan keamanan dengan verifikasi tambahan</p>
                                </div>
                            </div>
                            <div class="toggle-switch disabled" title="Segera hadir">
                                <div class="toggle-knob"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="settings-section">
                    <h4 class="settings-section-title">Sesi & Aktivitas</h4>
                    <div class="session-card">
                        <div class="session-info">
                            <i class="fa-solid fa-desktop" style="color:var(--primary);font-size:1.4rem;"></i>
                            <div>
                                <p class="session-title">Sesi Saat Ini</p>
                                <p class="session-desc">Browser aktif — <span id="sessionBrowser">—</span></p>
                            </div>
                        </div>
                        <span class="badge badge-active"><i class="fa-solid fa-circle" style="font-size:6px;"></i> Aktif</span>
                    </div>
                </div>

                <div class="settings-section danger-section">
                    <h4 class="settings-section-title" style="color:#dc2626;">Zona Berbahaya</h4>
                    <p style="font-size:.875rem;color:var(--text-muted);margin-bottom:16px;">Tindakan berikut bersifat permanen dan tidak dapat dibatalkan.</p>
                    <button class="btn" style="background:#fee2e2;color:#dc2626;border:1px solid rgba(220,38,38,.2);" onclick="confirmReset()">
                        <i class="fa-solid fa-triangle-exclamation"></i> Reset Semua Pengaturan
                    </button>
                </div>
            </div><!-- /#tab-akun -->

        </div><!-- /.settings-main-panel -->
    </div><!-- /.settings-layout -->
</div><!-- /.settings-page -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// ─── Theme ───────────────────────────────────────────────────────────────────
function setTheme(theme) {
    document.getElementById('hiddenTheme').value = theme;

    // Visual selection
    document.getElementById('themeLight').classList.toggle('selected', theme === 'light');
    document.getElementById('themeDark').classList.toggle('selected', theme === 'dark');

    // Apply immediately
    applyTheme(theme);
    localStorage.setItem('simoTheme', theme);
}

function applyTheme(theme) {
    if (theme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.removeAttribute('data-theme');
    }
}

// ─── Tabs ─────────────────────────────────────────────────────────────────────
function switchTab(tabName, btn) {
    document.querySelectorAll('.stab').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.stab-content').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + tabName).classList.add('active');
}

// ─── Avatar preview ───────────────────────────────────────────────────────────
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const initials = document.getElementById('avatarInitials');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initials) initials.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAvatar() {
    if (!confirm('Hapus foto profil?')) return;
    const preview = document.getElementById('avatarPreview');
    const initials = document.getElementById('avatarInitials');
    preview.src = '';
    preview.style.display = 'none';
    if (initials) {
        initials.style.display = 'flex';
        initials.textContent = (document.getElementById('usernameInput').value || 'AD').substring(0, 2).toUpperCase();
    }
    document.getElementById('avatarInput').value = '';
    // Tell server to remove via AJAX
    fetch('<?= base_url('pengaturan/remove_avatar') ?>', { method: 'POST', headers: {'X-Requested-With': 'XMLHttpRequest'} });
}

// ─── Bio counter ──────────────────────────────────────────────────────────────
const bioInput = document.getElementById('bioInput');
const bioCount = document.getElementById('bioCount');
if (bioInput && bioCount) {
    bioInput.addEventListener('input', function() {
        const len = Math.min(this.value.length, 150);
        this.value = this.value.substring(0, 150);
        bioCount.textContent = len + '/150';
    });
}

// ─── Reset form ───────────────────────────────────────────────────────────────
function resetForm() {
    if (confirm('Reset semua perubahan yang belum disimpan?')) {
        document.getElementById('settingsForm').reset();
    }
}

function confirmReset() {
    if (confirm('PERHATIAN: Ini akan mereset SEMUA pengaturan profil ke nilai awal. Lanjutkan?')) {
        fetch('<?= base_url('pengaturan/remove_avatar') ?>', { method: 'POST', headers: {'X-Requested-With': 'XMLHttpRequest'} });
        setTimeout(() => window.location.reload(), 300);
    }
}

// ─── On Load ──────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    // Apply saved theme
    const savedTheme = localStorage.getItem('simoTheme') || '<?= esc($theme) ?>';
    applyTheme(savedTheme);
    document.getElementById('hiddenTheme').value = savedTheme;
    document.getElementById('themeLight').classList.toggle('selected', savedTheme === 'light');
    document.getElementById('themeDark').classList.toggle('selected', savedTheme === 'dark');

    // Set session browser info
    const sb = document.getElementById('sessionBrowser');
    if (sb) sb.textContent = navigator.userAgent.split(' ').slice(-1)[0] || 'Unknown';

    // Last login
    const ll = document.getElementById('lastLoginDisplay');
    if (ll) ll.textContent = new Date().toLocaleString('id-ID');

    // Auto-hide alert
    const alert = document.getElementById('settingsAlert');
    if (alert) setTimeout(() => alert.style.opacity = '0', 4000);

    // Username initials live update
    const uInput = document.getElementById('usernameInput');
    const initials = document.getElementById('avatarInitials');
    if (uInput && initials) {
        uInput.addEventListener('input', function() {
            initials.textContent = (this.value || 'AD').substring(0, 2).toUpperCase();
        });
    }
});
</script>
<?= $this->endSection() ?>
