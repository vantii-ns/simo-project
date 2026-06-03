<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — SIMO HIMAPROSIF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            color: #e2e8f0;
            overflow: hidden;
        }

        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 70%, #059669 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .auth-left-orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.2; }
        .orb-1 { width: 400px; height: 400px; background: #10b981; top: -100px; right: -100px; }
        .orb-2 { width: 250px; height: 250px; background: #34d399; bottom: -50px; left: -50px; }

        .brand {
            display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;
        }

        .brand-logo {
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.15);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .brand-text h1 { font-size: 1.4rem; font-weight: 800; color: #fff; }
        .brand-text p  { font-size: 0.78rem; color: rgba(255,255,255,0.6); font-weight: 500; margin-top: 1px; }

        .auth-left-content { position: relative; z-index: 1; }
        .auth-left-content h2 { font-size: 2.2rem; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 16px; }
        .auth-left-content h2 span { background: linear-gradient(90deg, #6ee7b7, #a7f3d0); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .auth-left-content p { color: rgba(255,255,255,0.65); font-size: 0.95rem; line-height: 1.7; max-width: 360px; }

        .role-notice {
            margin-top: 28px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 16px;
            backdrop-filter: blur(8px);
        }

        .role-notice p { color: rgba(255,255,255,0.9); font-size: 0.88rem; margin-bottom: 8px; font-weight: 600; }
        .role-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.12); padding: 4px 10px; border-radius: 20px; font-size: 0.78rem; color: #d1fae5; font-weight: 600; }

        .auth-left-footer { position: relative; z-index: 1; color: rgba(255,255,255,0.4); font-size: 0.78rem; }

        .auth-right {
            width: 480px;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            border-left: 1px solid #1e293b;
            overflow-y: auto;
        }

        .auth-form-wrap { width: 100%; max-width: 380px; }

        .auth-form-title { margin-bottom: 28px; }
        .auth-form-title h2 { font-size: 1.7rem; font-weight: 800; color: #f1f5f9; margin-bottom: 6px; }
        .auth-form-title p  { color: #64748b; font-size: 0.88rem; }
        .auth-form-title p a { color: #10b981; font-weight: 600; text-decoration: none; }
        .auth-form-title p a:hover { text-decoration: underline; }

        .auth-alert { padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; animation: fadeIn .3s ease; }
        @keyframes fadeIn { from { opacity:0; transform: translateY(-8px); } to { opacity:1; transform: translateY(0); } }
        .auth-alert-error   { background: rgba(239,68,68,.12); color: #fca5a5; border: 1px solid rgba(239,68,68,.2); }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px; }

        .input-wrap { position: relative; }
        .input-wrap i.field-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #475569; font-size: 0.9rem; pointer-events: none; }

        .form-control {
            width: 100%; padding: 12px 16px 12px 42px;
            background: #1e293b; border: 1px solid #334155; border-radius: 10px;
            color: #e2e8f0; font-size: 0.92rem; font-family: inherit; outline: none; transition: all .2s ease;
        }
        .form-control:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
        .form-control::placeholder { color: #475569; }

        .toggle-pw { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #475569; cursor: pointer; font-size: 0.9rem; padding: 4px; transition: color .2s; }
        .toggle-pw:hover { color: #94a3b8; }

        .strength-bar { height: 4px; border-radius: 4px; background: #1e293b; margin-top: 6px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 4px; transition: width .3s, background .3s; width: 0; }

        .form-hint { font-size: 0.75rem; color: #475569; margin-top: 4px; }

        .btn-auth {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 700;
            font-family: inherit; cursor: pointer; transition: all .25s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-auth:hover { background: linear-gradient(135deg, #047857, #059669); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(16,185,129,0.3); }
        .btn-auth:active { transform: translateY(0); }

        @media (max-width: 900px) { .auth-left { display: none; } .auth-right { width: 100%; border-left: none; } }
    </style>
</head>
<body>

<div class="auth-left">
    <div class="auth-left-orb orb-1"></div>
    <div class="auth-left-orb orb-2"></div>

    <div class="brand">
        <div class="brand-logo"><i class="fa-solid fa-building-columns"></i></div>
        <div class="brand-text">
            <h1>SIMO</h1>
            <p>Sistem Informasi Manajemen Organisasi</p>
        </div>
    </div>

    <div class="auth-left-content">
        <h2>Bergabung dengan<br><span>HIMAPROSIF</span></h2>
        <p>Daftarkan akun Anda untuk mengakses informasi lengkap tentang kepengurusan dan program kerja organisasi.</p>

        <div class="role-notice">
            <p><i class="fa-solid fa-circle-info" style="margin-right:6px;"></i> Tentang Hak Akses</p>
            <p style="margin-bottom:10px;font-size:.82rem;color:rgba(255,255,255,.7);">Setiap akun yang didaftarkan akan mendapatkan role:</p>
            <div class="role-badge"><i class="fa-solid fa-eye"></i> Viewer (User) — Lihat semua data</div>
            <p style="margin-top:8px;font-size:.78rem;color:rgba(255,255,255,.5);">Untuk akses Admin (CRUD penuh), hubungi pengelola sistem.</p>
        </div>
    </div>

    <div class="auth-left-footer">
        &copy; <?= date('Y') ?> HIMAPROSIF &mdash; SIMO v2.0
    </div>
</div>

<div class="auth-right">
    <div class="auth-form-wrap">

        <div class="auth-form-title">
            <h2>Buat Akun Baru</h2>
            <p>Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk di sini</a></p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="auth-alert auth-alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post" id="registerForm">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-at field-icon"></i>
                    <input type="text" name="username" id="username" class="form-control"
                           placeholder="Contoh: budi_santoso"
                           value="<?= old('username') ?>" autocomplete="username" required>
                </div>
                <p class="form-hint">3–30 karakter, huruf/angka/underscore saja.</p>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock field-icon"></i>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Minimal 6 karakter" oninput="checkStrength(this.value)" required>
                    <button type="button" class="toggle-pw" onclick="togglePw('password','eyePw1')">
                        <i class="fa-solid fa-eye" id="eyePw1"></i>
                    </button>
                </div>
                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                <p class="form-hint" id="strengthText">Masukkan password...</p>
            </div>

            <div class="form-group">
                <label class="form-label" for="confirm_password">Konfirmasi Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock-open field-icon"></i>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                           placeholder="Ulangi password" required>
                    <button type="button" class="toggle-pw" onclick="togglePw('confirm_password','eyePw2')">
                        <i class="fa-solid fa-eye" id="eyePw2"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-auth" id="registerBtn" style="margin-top:8px;">
                <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
            </button>
        </form>

    </div>
</div>

<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function checkStrength(val) {
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    let score = 0;
    if (val.length >= 6)  score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { pct: '0%',   color: '#334155', label: 'Masukkan password...' },
        { pct: '25%',  color: '#ef4444', label: 'Lemah' },
        { pct: '50%',  color: '#f97316', label: 'Cukup' },
        { pct: '75%',  color: '#eab308', label: 'Kuat' },
        { pct: '90%',  color: '#22c55e', label: 'Sangat Kuat' },
        { pct: '100%', color: '#10b981', label: 'Sempurna!' },
    ];
    const l = levels[Math.min(score, 5)];
    fill.style.width = l.pct;
    fill.style.background = l.color;
    text.textContent = l.label;
    text.style.color = l.color;
}

document.getElementById('registerForm').addEventListener('submit', function() {
    const btn = document.getElementById('registerBtn');
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Mendaftarkan...';
    btn.disabled = true;
});
</script>
</body>
</html>
