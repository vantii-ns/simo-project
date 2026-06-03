<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIMO HIMAPROSIF</title>
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

        /* ── Left panel (decorative) ── */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 40%, #312e81 70%, #4c1d95 100%);
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

        .auth-left-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
        }
        .orb-1 { width: 400px; height: 400px; background: #6366f1; top: -100px; right: -100px; }
        .orb-2 { width: 300px; height: 300px; background: #3b82f6; bottom: -50px; left: -50px; }
        .orb-3 { width: 200px; height: 200px; background: #a855f7; top: 50%; left: 50%; transform: translate(-50%,-50%); }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .brand-text h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
        }

        .brand-text p {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
            margin-top: 1px;
        }

        .auth-left-content {
            position: relative;
            z-index: 1;
        }

        .auth-left-content h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .auth-left-content h2 span {
            background: linear-gradient(90deg, #a5b4fc, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-left-content p {
            color: rgba(255,255,255,0.65);
            font-size: 0.95rem;
            line-height: 1.7;
            max-width: 360px;
        }

        .feature-list {
            margin-top: 32px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.8);
            font-size: 0.88rem;
            font-weight: 500;
        }

        .feature-item i {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: #a5b4fc;
            flex-shrink: 0;
        }

        .auth-left-footer {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.4);
            font-size: 0.78rem;
        }

        /* ── Right panel (form) ── */
        .auth-right {
            width: 480px;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
            border-left: 1px solid #1e293b;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 380px;
        }

        .auth-form-title {
            margin-bottom: 32px;
        }

        .auth-form-title h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 6px;
        }

        .auth-form-title p {
            color: #64748b;
            font-size: 0.88rem;
        }

        .auth-form-title p a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-form-title p a:hover {
            text-decoration: underline;
        }

        /* Alert */
        .auth-alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn { from { opacity:0; transform: translateY(-8px); } to { opacity:1; transform: translateY(0); } }

        .auth-alert-error   { background: rgba(239,68,68,.12); color: #fca5a5; border: 1px solid rgba(239,68,68,.2); }
        .auth-alert-success { background: rgba(16,185,129,.12); color: #6ee7b7; border: 1px solid rgba(16,185,129,.2); }

        /* Form groups */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px 12px 42px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #e2e8f0;
            font-size: 0.92rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
            background: #1e293b;
        }

        .form-control::placeholder { color: #475569; }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #475569;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 4px;
            transition: color .2s;
        }

        .toggle-pw:hover { color: #94a3b8; }

        /* Remember & forgot */
        .form-extras {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: #64748b;
            cursor: pointer;
        }

        .check-label input { accent-color: #6366f1; }

        .forgot-link {
            font-size: 0.82rem;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-link:hover { text-decoration: underline; }

        /* Submit button */
        .btn-auth {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.3px;
        }

        .btn-auth:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(99,102,241,0.35);
        }

        .btn-auth:active { transform: translateY(0); }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: #334155;
            font-size: 0.78rem;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #1e293b;
        }

        /* Role info box */
        .role-info {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.8rem;
            color: #64748b;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 16px;
        }

        .role-info i { color: #6366f1; margin-top: 1px; flex-shrink: 0; }

        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; border-left: none; }
        }
    </style>
</head>
<body>

<div class="auth-left">
    <div class="auth-left-orb orb-1"></div>
    <div class="auth-left-orb orb-2"></div>
    <div class="auth-left-orb orb-3"></div>

    <div class="brand">
        <div class="brand-logo"><i class="fa-solid fa-building-columns"></i></div>
        <div class="brand-text">
            <h1>SIMO</h1>
            <p>Sistem Informasi Manajemen Organisasi</p>
        </div>
    </div>

    <div class="auth-left-content">
        <h2>Selamat datang<br>di <span>HIMAPROSIF</span></h2>
        <p>Platform terpusat untuk mengelola anggota, struktur kepengurusan, dan program kerja organisasi secara efisien dan real-time.</p>
        <div class="feature-list">
            <div class="feature-item">
                <i class="fa-solid fa-users"></i>
                Manajemen Anggota & Departemen
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-briefcase"></i>
                Program Kerja dengan Gantt Chart
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-file-invoice"></i>
                Laporan SK & Katalog Proker
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-shield-halved"></i>
                Hak Akses Role Admin & User
            </div>
        </div>
    </div>

    <div class="auth-left-footer">
        &copy; <?= date('Y') ?> HIMAPROSIF &mdash; SIMO v2.0
    </div>
</div>

<div class="auth-right">
    <div class="auth-form-wrap">

        <div class="auth-form-title">
            <h2>Masuk ke SIMO</h2>
            <p>Belum punya akun? <a href="<?= base_url('register') ?>">Daftar sekarang</a></p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="auth-alert auth-alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="auth-alert auth-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post" id="loginForm">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-at"></i>
                    <input type="text" name="username" id="username" class="form-control"
                           placeholder="Masukkan username..."
                           value="<?= old('username') ?>" autocomplete="username" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Masukkan password..." autocomplete="current-password" required>
                    <button type="button" class="toggle-pw" onclick="togglePw('password','eyePw')">
                        <i class="fa-solid fa-eye" id="eyePw"></i>
                    </button>
                </div>
            </div>

            <div class="form-extras">
                <label class="check-label">
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
                <a href="#" class="forgot-link">Lupa password?</a>
            </div>

            <button type="submit" class="btn-auth" id="loginBtn">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk
            </button>
        </form>

        <div class="role-info">
            <i class="fa-solid fa-circle-info"></i>
            <div>
                <strong style="color:#94a3b8;">Info Akun Default:</strong><br>
                Admin: <code style="color:#a5b4fc;">admin</code> / <code style="color:#a5b4fc;">admin123</code><br>
                User: <code style="color:#94a3b8;">user</code> / <code style="color:#94a3b8;">user123</code>
            </div>
        </div>

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

document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('loginBtn');
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memverifikasi...';
    btn.disabled = true;
});
</script>
</body>
</html>
