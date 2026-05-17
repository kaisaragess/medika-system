<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Semua rute ini HANYA bisa diakses jika sudah login
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/dashboard', 'Home::index');

    // --- ADMIN ONLY (Data Master & Pegawai) ---
    $routes->group('', ['filter' => 'role:Admin'], function ($routes) {
        // Master Kamar
        $routes->get('/kamar', 'KamarController::index');                 
        $routes->get('/kamar/create', 'KamarController::create');         
        $routes->post('/kamar/store', 'KamarController::store');          
        $routes->get('/kamar/edit/(:num)', 'KamarController::edit/$1');   
        $routes->post('/kamar/update/(:num)', 'KamarController::update/$1'); 
        $routes->get('/kamar/delete/(:num)', 'KamarController::delete/$1');

        // Master Poliklinik
        $routes->get('/poliklinik', 'PoliklinikController::index');                 
        $routes->get('/poliklinik/create', 'PoliklinikController::create');         
        $routes->post('/poliklinik/store', 'PoliklinikController::store');          
        $routes->get('/poliklinik/edit/(:num)', 'PoliklinikController::edit/$1');   
        $routes->post('/poliklinik/update/(:num)', 'PoliklinikController::update/$1'); 
        $routes->get('/poliklinik/delete/(:num)', 'PoliklinikController::delete/$1');

        // Master Layanan
        $routes->get('/layanan', 'LayananController::index');                 
        $routes->get('/layanan/create', 'LayananController::create');         
        $routes->post('/layanan/store', 'LayananController::store');          
        $routes->get('/layanan/edit/(:num)', 'LayananController::edit/$1');   
        $routes->post('/layanan/update/(:num)', 'LayananController::update/$1'); 
        $routes->get('/layanan/delete/(:num)', 'LayananController::delete/$1');

        // Manajemen Pegawai
        $routes->get('/pegawai', 'PegawaiController::index');                 
        $routes->get('/pegawai/create', 'PegawaiController::create');         
        $routes->post('/pegawai/store', 'PegawaiController::store');          
        $routes->get('/pegawai/edit/(:num)', 'PegawaiController::edit/$1');   
        $routes->post('/pegawai/update/(:num)', 'PegawaiController::update/$1'); 
        $routes->get('/pegawai/delete/(:num)', 'PegawaiController::delete/$1');
        $routes->post('/pegawai/approve/(:num)', 'PegawaiController::approve/$1');
    });

    // --- ADMIN & PERAWAT (Pendaftaran & Rawat Inap) ---
    $routes->group('', ['filter' => 'role:Admin,Perawat'], function ($routes) {
        // Master Pasien
        $routes->get('/pasien', 'PasienController::index');                 
        $routes->get('/pasien/create', 'PasienController::create');         
        $routes->post('/pasien/store', 'PasienController::store');          
        $routes->get('/pasien/edit/(:num)', 'PasienController::edit/$1');   
        $routes->post('/pasien/update/(:num)', 'PasienController::update/$1'); 
        $routes->get('/pasien/delete/(:num)', 'PasienController::delete/$1');

        // Transaksi Kamar
        $routes->get('/transaksi_kamar', 'TransaksiKamarController::index');
        $routes->get('/transaksi_kamar/create', 'TransaksiKamarController::create');
        $routes->post('/transaksi_kamar/store', 'TransaksiKamarController::store');
        $routes->post('/transaksi_kamar/checkout/(:num)', 'TransaksiKamarController::checkout/$1');
        $routes->get('/transaksi_kamar/edit/(:num)', 'TransaksiKamarController::edit/$1');
        $routes->post('/transaksi_kamar/update/(:num)', 'TransaksiKamarController::update/$1');
    });

    // --- ADMIN, PERAWAT & DOKTER (Antrean Pendaftaran) ---
    $routes->group('', ['filter' => 'role:Admin,Perawat,Dokter'], function ($routes) {
        $routes->get('/pendaftaran', 'PendaftaranController::index');                 
        $routes->get('/pendaftaran/create', 'PendaftaranController::create');                 
        $routes->get('/pendaftaran/edit/(:num)', 'PendaftaranController::edit/$1');   
        $routes->post('/pendaftaran/update/(:num)', 'PendaftaranController::update/$1'); 
        $routes->get('/pendaftaran/delete/(:num)', 'PendaftaranController::delete/$1');
        $routes->post('/pendaftaran/review', 'PendaftaranController::review');
        $routes->get('/pendaftaran/confirm', 'PendaftaranController::confirm');
        $routes->post('/pendaftaran/store', 'PendaftaranController::store');
        $routes->get('/pendaftaran/cancel', 'PendaftaranController::cancel');
        
        $routes->get('/histori', 'HistoriController::index');
    });

    // --- ADMIN & DOKTER (Rekam Medis) ---
    $routes->group('', ['filter' => 'role:Admin,Dokter'], function ($routes) {
        // 3. Modul Rekam Medis & Histori
        $routes->get('/rekam_medis', 'RekamMedisController::index');                 
        $routes->get('/rekam_medis/create', 'RekamMedisController::create');         
        $routes->post('/rekam_medis/store', 'RekamMedisController::store');          
        $routes->get('/rekam_medis/edit/(:num)', 'RekamMedisController::edit/$1');   
        $routes->post('/rekam_medis/update/(:num)', 'RekamMedisController::update/$1'); 
        $routes->get('/rekam_medis/delete/(:num)', 'RekamMedisController::delete/$1');
    });

    // --- ADMIN & APOTEKER (Farmasi) ---
    $routes->group('', ['filter' => 'role:Admin,Apoteker'], function ($routes) {
        // Master Obat
        $routes->get('/obat', 'ObatController::index');                 
        $routes->get('/obat/create', 'ObatController::create');         
        $routes->post('/obat/store', 'ObatController::store');          
        $routes->get('/obat/edit/(:num)', 'ObatController::edit/$1');   
        $routes->post('/obat/update/(:num)', 'ObatController::update/$1'); 
        $routes->get('/obat/delete/(:num)', 'ObatController::delete/$1');

        // Transaksi Obat
        $routes->get('/transaksi_obat', 'TransaksiObatController::index');
        $routes->get('/transaksi_obat/create', 'TransaksiObatController::create');
        $routes->post('/transaksi_obat/store', 'TransaksiObatController::store');
        $routes->get('/transaksi_obat/edit/(:num)', 'TransaksiObatController::edit/$1');
        $routes->post('/transaksi_obat/update/(:num)', 'TransaksiObatController::update/$1');
        $routes->get('/transaksi_obat/delete/(:num)', 'TransaksiObatController::delete/$1');
    });

    // --- ADMIN & KASIR (Keuangan) ---
    $routes->group('', ['filter' => 'role:Admin,Kasir'], function ($routes) {
        // Transaksi Layanan
        $routes->get('/transaksi_layanan', 'TransaksiLayananController::index');                 
        $routes->get('/transaksi_layanan/create', 'TransaksiLayananController::create');         
        $routes->post('/transaksi_layanan/store', 'TransaksiLayananController::store');          
        $routes->get('/transaksi_layanan/edit/(:num)', 'TransaksiLayananController::edit/$1');   
        $routes->post('/transaksi_layanan/update/(:num)', 'TransaksiLayananController::update/$1'); 
        $routes->get('/transaksi_layanan/delete/(:num)', 'TransaksiLayananController::delete/$1');

        // Pembayaran / Kasir
        $routes->get('/pembayaran', 'PembayaranController::index');
        $routes->get('/pembayaran/create', 'PembayaranController::create');
        $routes->post('/pembayaran/store', 'PembayaranController::store');
        $routes->get('/pembayaran/cetak/(:num)', 'PembayaranController::cetak/$1');
    });
});

    // Rute Publik (Tidak kena filter)
$routes->get('/login', 'AuthController::login');
$routes->post('/auth/process', 'AuthController::process');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register'); // Tampilkan form
$routes->post('/auth/processRegister', 'AuthController::processRegister'); // Proses form