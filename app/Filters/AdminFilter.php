<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * AdminFilter — Hanya ijinkan role 'admin'. User biasa ditolak dengan pesan 403.
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('user_role') !== 'admin') {
            // Jika AJAX / JSON request
            if ($request->isAJAX()) {
                return service('response')
                    ->setStatusCode(403)
                    ->setJSON(['status' => 'error', 'message' => 'Akses ditolak. Anda tidak memiliki izin.']);
            }
            // Biasa: tampilkan flash error dan redirect ke halaman sebelumnya
            return redirect()->back()->with('error', '⛔ Akses ditolak. Fitur ini hanya tersedia untuk Admin.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah request
    }
}
