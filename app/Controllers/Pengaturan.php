<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pengaturan extends BaseController
{
    public function index()
    {
        // Load profile from session (or defaults)
        $session = session();

        $data = [
            'title'    => 'Pengaturan',
            'username' => $session->get('profile_username') ?? 'Admin',
            'bio'      => $session->get('profile_bio') ?? 'Administrator SIMO - Sistem Informasi Manajemen Organisasi HIMAPROSIF.',
            'avatar'   => $session->get('profile_avatar') ?? null,
            'theme'    => $session->get('profile_theme') ?? 'light',
        ];

        return view('pengaturan/index', $data);
    }

    /**
     * Save profile settings (username, bio, avatar upload)
     */
    public function save()
    {
        $session = session();

        $username = $this->request->getPost('username') ?: 'Admin';
        $bio      = $this->request->getPost('bio') ?: '';
        $theme    = $this->request->getPost('theme') ?: 'light';

        // Handle avatar upload
        $avatar = $session->get('profile_avatar');
        $file   = $this->request->getFile('avatar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'assets/images/avatars', $newName);
            $avatar = 'assets/images/avatars/' . $newName;
        }

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
        $session->remove('profile_avatar');
        return $this->response->setJSON(['success' => true]);
    }
}
