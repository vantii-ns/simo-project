<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ══════════════════════════════════════════════════════════
// PUBLIK — Tanpa filter (siapapun bisa akses)
// ══════════════════════════════════════════════════════════
$routes->get('login',    'Auth::loginForm');
$routes->post('login',   'Auth::login');
$routes->get('register', 'Auth::registerForm');
$routes->post('register','Auth::register');
$routes->get('logout',   'Auth::logout', ['filter' => 'auth']);

// ══════════════════════════════════════════════════════════
// REDIRECT ROOT → dashboard (dilindungi auth)
// ══════════════════════════════════════════════════════════
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// ══════════════════════════════════════════════════════════
// UTILITAS — Admin only
// ══════════════════════════════════════════════════════════
$routes->get('/patchdata',  'PatchData::index',  ['filter' => ['auth', 'admin_only']]);
$routes->get('/import2026', 'Import2026::index', ['filter' => ['auth', 'admin_only']]);

// ══════════════════════════════════════════════════════════
// MASTER — GET: auth | POST/DELETE: auth + admin_only
// ══════════════════════════════════════════════════════════
$routes->group('master', ['namespace' => 'App\Controllers\Master'], function($routes) {
    // Periode
    $routes->get('periode',                      'Periode::index',      ['filter' => 'auth']);
    $routes->post('periode/save',                'Periode::save',       ['filter' => ['auth', 'admin_only']]);
    $routes->post('periode/update/(:segment)',   'Periode::update/$1',  ['filter' => ['auth', 'admin_only']]);
    $routes->get('periode/delete/(:segment)',    'Periode::delete/$1',  ['filter' => ['auth', 'admin_only']]);
    $routes->get('periode/set_active/(:segment)','Periode::set_active/$1', ['filter' => ['auth', 'admin_only']]);

    // Anggota
    $routes->get('anggota',                    'Anggota::index',     ['filter' => 'auth']);
    $routes->post('anggota/save',              'Anggota::save',      ['filter' => ['auth', 'admin_only']]);
    $routes->post('anggota/update/(:segment)', 'Anggota::update/$1', ['filter' => ['auth', 'admin_only']]);
    $routes->get('anggota/delete/(:segment)',  'Anggota::delete/$1', ['filter' => ['auth', 'admin_only']]);

    // Departemen
    $routes->get('departemen',                    'Departemen::index',     ['filter' => 'auth']);
    $routes->post('departemen/save',              'Departemen::save',      ['filter' => ['auth', 'admin_only']]);
    $routes->post('departemen/update/(:segment)', 'Departemen::update/$1', ['filter' => ['auth', 'admin_only']]);
    $routes->get('departemen/delete/(:segment)',  'Departemen::delete/$1', ['filter' => ['auth', 'admin_only']]);

    // Jabatan
    $routes->get('jabatan',                    'Jabatan::index',     ['filter' => 'auth']);
    $routes->post('jabatan/save',              'Jabatan::save',      ['filter' => ['auth', 'admin_only']]);
    $routes->post('jabatan/update/(:segment)', 'Jabatan::update/$1', ['filter' => ['auth', 'admin_only']]);
    $routes->get('jabatan/delete/(:segment)',  'Jabatan::delete/$1', ['filter' => ['auth', 'admin_only']]);
});

// ══════════════════════════════════════════════════════════
// TRANSAKSI — GET: auth | POST/DELETE: auth + admin_only
// ══════════════════════════════════════════════════════════
$routes->group('transaksi', ['namespace' => 'App\Controllers\Transaksi'], function($routes) {
    // Struktur Kepengurusan
    $routes->get('struktur',                    'Struktur::index',     ['filter' => 'auth']);
    $routes->post('struktur/save',              'Struktur::save',      ['filter' => ['auth', 'admin_only']]);
    $routes->post('struktur/update/(:segment)', 'Struktur::update/$1', ['filter' => ['auth', 'admin_only']]);
    $routes->get('struktur/delete/(:segment)',  'Struktur::delete/$1', ['filter' => ['auth', 'admin_only']]);

    // Program Kerja
    $routes->get('proker',                              'Proker::index',               ['filter' => 'auth']);
    $routes->post('proker/save',                        'Proker::save',                ['filter' => ['auth', 'admin_only']]);
    $routes->post('proker/update/(:segment)',            'Proker::update/$1',           ['filter' => ['auth', 'admin_only']]);
    $routes->get('proker/delete/(:segment)',             'Proker::delete/$1',           ['filter' => ['auth', 'admin_only']]);
    $routes->get('proker/detail/(:segment)',             'Proker::detail/$1',           ['filter' => 'auth']);
    $routes->post('proker/save_partisipan',              'Proker::save_partisipan',     ['filter' => ['auth', 'admin_only']]);
    $routes->get('proker/delete_partisipan/(:segment)/(:segment)', 'Proker::delete_partisipan/$1/$2', ['filter' => ['auth', 'admin_only']]);

    // Partisipan
    $routes->get('partisipan',                    'Partisipan::index',     ['filter' => 'auth']);
    $routes->post('partisipan/save',              'Partisipan::save',      ['filter' => ['auth', 'admin_only']]);
    $routes->post('partisipan/update/(:segment)', 'Partisipan::update/$1', ['filter' => ['auth', 'admin_only']]);
    $routes->get('partisipan/delete/(:segment)',  'Partisipan::delete/$1', ['filter' => ['auth', 'admin_only']]);
});

// ══════════════════════════════════════════════════════════
// PENCARIAN GLOBAL — auth
// ══════════════════════════════════════════════════════════
$routes->get('search', 'Search::index', ['filter' => 'auth']);

// ══════════════════════════════════════════════════════════
// PENGATURAN — auth
// ══════════════════════════════════════════════════════════
$routes->get('pengaturan',              'Pengaturan::index',       ['filter' => 'auth']);
$routes->post('pengaturan/save',        'Pengaturan::save',        ['filter' => 'auth']);
$routes->post('pengaturan/remove_avatar','Pengaturan::removeAvatar',['filter' => 'auth']);

// ══════════════════════════════════════════════════════════
// LAPORAN — auth
// ══════════════════════════════════════════════════════════
$routes->group('laporan', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/',        'Laporan::index',   ['filter' => 'auth']);
    $routes->get('sk',       'Laporan::sk',      ['filter' => 'auth']);
    $routes->get('katalog',  'Laporan::katalog', ['filter' => 'auth']);
    $routes->post('rapor',   'Laporan::rapor',   ['filter' => 'auth']);
});