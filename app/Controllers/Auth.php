<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ──────────────────────────────────────────────────────────────
    // LOGIN
    // ──────────────────────────────────────────────────────────────

    public function loginForm()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password wajib diisi.')->withInput();
        }

        $user = $this->userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Username atau password salah.')->withInput();
        }

        // Set session
        session()->set([
            'logged_in'   => true,
            'user_id'     => $user['id'],
            'user_role'   => $user['role'],
            'username'    => $user['username'],
        ]);

        // Preserve profile settings if already in session
        if (!session()->get('profile_username')) {
            session()->set('profile_username', ucfirst($user['username']));
        }

        return redirect()->to(base_url('dashboard'));
    }

    // ──────────────────────────────────────────────────────────────
    // REGISTER
    // ──────────────────────────────────────────────────────────────

    public function registerForm()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/register');
    }

    public function register()
    {
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

        // Validasi dasar
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.')->withInput();
        }

        if (strlen($username) < 3 || strlen($username) > 30) {
            return redirect()->back()->with('error', 'Username harus antara 3–30 karakter.')->withInput();
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            return redirect()->back()->with('error', 'Username hanya boleh berisi huruf, angka, dan underscore.')->withInput();
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.')->withInput();
        }

        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.')->withInput();
        }

        if ($this->userModel->usernameExists($username)) {
            return redirect()->back()->with('error', 'Username sudah digunakan, coba yang lain.')->withInput();
        }

        $this->userModel->save([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role'     => 'user', // Semua pendaftaran baru = user biasa
        ]);

        return redirect()->to(base_url('login'))
            ->with('success', 'Akun berhasil dibuat! Silakan login dengan username <strong>' . esc($username) . '</strong>.');
    }

    // ──────────────────────────────────────────────────────────────
    // LOGOUT
    // ──────────────────────────────────────────────────────────────

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Anda telah berhasil keluar.');
    }
}
