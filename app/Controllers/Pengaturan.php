<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Pengaturan extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('id'); 

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        // Ambil data role dari database, jika kosong berikan default 'user'
        $role = $user['role'] ?? 'user';

        if (!empty($user['username'])) {
            $username = $user['username'];
        } else {
            $username = 'Admin';
        }

        if (!empty($user['bio'])) {
            $bio = $user['bio'];
        } else {
            $bio = 'Administrator SIMO - Sistem Informasi Manajemen Organisasi HIMAPROSIF.';
        }

        if (!empty($user['avatar'])) {
            $avatar = $user['avatar'];
        } else {
            $avatar = null;
        }

        if (!empty($user['theme'])) {
            $theme = $user['theme'];
        } else {
            $theme = 'light';
        }

        $data = [
            'title'    => 'Pengaturan',
            'username' => $user['username'] ?? 'Admin',
            'bio'      => $user['bio'] ?? 'Administrator SIMO - Sistem Informasi Manajemen Organisasi HIMAPROSIF.',
            'avatar'   => $user['avatar'] ?? null,
            'theme'    => $user['theme'] ?? 'light',
            'role'     => $role, // <-- Tambahkan baris ini untuk mengirimkan role ke view
        ];

        return view('pengaturan/index', $data);
    }

    /**
     * Save profile settings (username, bio, avatar upload)
     */
    public function save()
    {
        $session = session();
        $userId = $session->get('id');
        
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        // Validasi input post dengan if-else
        $postUsername = $this->request->getPost('username');
        if (!empty($postUsername)) {
            $username = $postUsername;
        } else {
            $username = 'Admin';
        }

        $postBio = $this->request->getPost('bio');
        if (!empty($postBio)) {
            $bio = $postBio;
        } else {
            $bio = '';
        }

        $postTheme = $this->request->getPost('theme');
        if (!empty($postTheme)) {
            $theme = $postTheme;
        } else {
            $theme = 'light';
        }

        // Ambil data avatar lama dari database
        if (!empty($user['avatar'])) {
            $avatar = $user['avatar'];
        } else {
            $avatar = null;
        }

        // Proses upload file foto profil baru
        $file = $this->request->getFile('avatar');
        if ($file) {
            if ($file->isValid()) {
                if (!$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'assets/images/avatars', $newName);
                    $avatar = 'assets/images/avatars/' . $newName;
                }
            }
        }

        // 4. Siapkan data array untuk disimpan ke Database
        $updateData = [
            'username' => $username,
            'bio'      => $bio,
            'avatar'   => $avatar,
            'theme'    => $theme
        ];

        // 5. Jalankan perintah update ke database berdasarkan ID user
        $userModel->update($userId, $updateData);

        // 6. Perbarui juga data session global (opsional, berguna jika nama/foto muncul di navbar)
        $session->set('profile_username', $username);
        $session->set('profile_bio', $bio);
        $session->set('profile_avatar', $avatar);
        $session->set('profile_theme', $theme);

        return redirect()->to(base_url('pengaturan'))->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * AJAX endpoint to remove avatar
     */
    public function removeAvatar()
    {
        $session = session();
        $userId = $session->get('id');

        $userModel = new UserModel();
        
        // Update kolom avatar di database menjadi null atau kosong
        $userModel->update($userId, ['avatar' => null]);

        $session->remove('profile_avatar');
        return $this->response->setJSON(['success' => true]);
    }
}