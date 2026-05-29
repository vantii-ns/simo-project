<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/patchdata', 'PatchData::index');
$routes->get('/import2026', 'Import2026::index');

$routes->group('master', ['namespace' => 'App\Controllers\Master'], function($routes) {
    // Periode
    $routes->get('periode', 'Periode::index');
    $routes->post('periode/save', 'Periode::save');
    $routes->post('periode/update/(:segment)', 'Periode::update/$1');
    $routes->get('periode/delete/(:segment)', 'Periode::delete/$1');
    $routes->get('periode/set_active/(:segment)', 'Periode::set_active/$1');

    // Anggota
    $routes->get('anggota', 'Anggota::index');
    $routes->post('anggota/save', 'Anggota::save');
    $routes->post('anggota/update/(:segment)', 'Anggota::update/$1');
    $routes->get('anggota/delete/(:segment)', 'Anggota::delete/$1');

    // Departemen
    $routes->get('departemen', 'Departemen::index');
    $routes->post('departemen/save', 'Departemen::save');
    $routes->post('departemen/update/(:segment)', 'Departemen::update/$1');
    $routes->get('departemen/delete/(:segment)', 'Departemen::delete/$1');

    // Jabatan
    $routes->get('jabatan', 'Jabatan::index');
    $routes->post('jabatan/save', 'Jabatan::save');
    $routes->post('jabatan/update/(:segment)', 'Jabatan::update/$1');
    $routes->get('jabatan/delete/(:segment)', 'Jabatan::delete/$1');
});

$routes->group('transaksi', ['namespace' => 'App\Controllers\Transaksi'], function($routes) {
    // Struktur Kepengurusan
    $routes->get('struktur', 'Struktur::index');
    $routes->post('struktur/save', 'Struktur::save');
    $routes->post('struktur/update/(:segment)', 'Struktur::update/$1');
    $routes->get('struktur/delete/(:segment)', 'Struktur::delete/$1');

    // Program Kerja
    $routes->get('proker', 'Proker::index');
    $routes->post('proker/save', 'Proker::save');
    $routes->post('proker/update/(:segment)', 'Proker::update/$1');
    $routes->get('proker/delete/(:segment)', 'Proker::delete/$1');
    $routes->get('proker/detail/(:segment)', 'Proker::detail/$1');
    $routes->post('proker/save_partisipan', 'Proker::save_partisipan');
    $routes->get('proker/delete_partisipan/(:segment)/(:segment)', 'Proker::delete_partisipan/$1/$2');

    // Partisipan
    $routes->get('partisipan', 'Partisipan::index');
    $routes->post('partisipan/save', 'Partisipan::save');
    $routes->post('partisipan/update/(:segment)', 'Partisipan::update/$1');
    $routes->get('partisipan/delete/(:segment)', 'Partisipan::delete/$1');
});

$routes->group('laporan', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'Laporan::index');
    $routes->get('sk', 'Laporan::sk');
    $routes->get('katalog', 'Laporan::katalog');
    $routes->post('rapor', 'Laporan::rapor');
});
