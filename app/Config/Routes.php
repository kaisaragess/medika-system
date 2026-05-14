<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// Rute untuk mengelola Pasien
$routes->get('/pasien', 'PasienController::index');                 // Halaman daftar pasien
$routes->get('/pasien/create', 'PasienController::create');         // Halaman form tambah pasien
$routes->post('/pasien/store', 'PasienController::store');          // Proses simpan data baru
$routes->get('/pasien/edit/(:num)', 'PasienController::edit/$1');   // Halaman form edit pasien (berdasarkan ID)
$routes->post('/pasien/update/(:num)', 'PasienController::update/$1'); // Proses simpan perubahan
$routes->get('/pasien/delete/(:num)', 'PasienController::delete/$1');  // Proses hapus data

// Rute untuk mengelola Obat
$routes->get('/obat', 'ObatController::index');                 
$routes->get('/obat/create', 'ObatController::create');         
$routes->post('/obat/store', 'ObatController::store');          
$routes->get('/obat/edit/(:num)', 'ObatController::edit/$1');   
$routes->post('/obat/update/(:num)', 'ObatController::update/$1'); 
$routes->get('/obat/delete/(:num)', 'ObatController::delete/$1');

// Rute untuk Fitur Manajemen Kamar
$routes->get('/kamar', 'KamarController::index');                 
$routes->get('/kamar/create', 'KamarController::create');         
$routes->post('/kamar/store', 'KamarController::store');          
$routes->get('/kamar/edit/(:num)', 'KamarController::edit/$1');   
$routes->post('/kamar/update/(:num)', 'KamarController::update/$1'); 
$routes->get('/kamar/delete/(:num)', 'KamarController::delete/$1');

// Rute untuk Fitur Manajemen Poliklinik
$routes->get('/poliklinik', 'PoliklinikController::index');                 
$routes->get('/poliklinik/create', 'PoliklinikController::create');         
$routes->post('/poliklinik/store', 'PoliklinikController::store');          
$routes->get('/poliklinik/edit/(:num)', 'PoliklinikController::edit/$1');   
$routes->post('/poliklinik/update/(:num)', 'PoliklinikController::update/$1'); 
$routes->get('/poliklinik/delete/(:num)', 'PoliklinikController::delete/$1');

// Rute untuk Fitur Manajemen Layanan
$routes->get('/layanan', 'LayananController::index');                 
$routes->get('/layanan/create', 'LayananController::create');         
$routes->post('/layanan/store', 'LayananController::store');          
$routes->get('/layanan/edit/(:num)', 'LayananController::edit/$1');   
$routes->post('/layanan/update/(:num)', 'LayananController::update/$1'); 
$routes->get('/layanan/delete/(:num)', 'LayananController::delete/$1');

// Rute untuk Fitur Manajemen Pegawai
$routes->get('/pegawai', 'PegawaiController::index');                 
$routes->get('/pegawai/create', 'PegawaiController::create');         
$routes->post('/pegawai/store', 'PegawaiController::store');          
$routes->get('/pegawai/edit/(:num)', 'PegawaiController::edit/$1');   
$routes->post('/pegawai/update/(:num)', 'PegawaiController::update/$1'); 
$routes->get('/pegawai/delete/(:num)', 'PegawaiController::delete/$1');

// Rute untuk Fitur Transaksi Pendaftaran
$routes->get('/pendaftaran', 'PendaftaranController::index');                 
$routes->get('/pendaftaran/create', 'PendaftaranController::create');         
$routes->post('/pendaftaran/store', 'PendaftaranController::store');          
$routes->get('/pendaftaran/edit/(:num)', 'PendaftaranController::edit/$1');   
$routes->post('/pendaftaran/update/(:num)', 'PendaftaranController::update/$1'); 
$routes->get('/pendaftaran/delete/(:num)', 'PendaftaranController::delete/$1');

// Rute untuk Fitur Rekam Medis
$routes->get('/rekam_medis', 'RekamMedisController::index');                 
$routes->get('/rekam_medis/create', 'RekamMedisController::create');         
$routes->post('/rekam_medis/store', 'RekamMedisController::store');          
$routes->get('/rekam_medis/edit/(:num)', 'RekamMedisController::edit/$1');   
$routes->post('/rekam_medis/update/(:num)', 'RekamMedisController::update/$1'); 
$routes->get('/rekam_medis/delete/(:num)', 'RekamMedisController::delete/$1');

// Rute untuk Fitur Transaksi Layanan Medis
$routes->get('/transaksi_layanan', 'TransaksiLayananController::index');                 
$routes->get('/transaksi_layanan/create', 'TransaksiLayananController::create');         
$routes->post('/transaksi_layanan/store', 'TransaksiLayananController::store');          
$routes->get('/transaksi_layanan/edit/(:num)', 'TransaksiLayananController::edit/$1');   
$routes->post('/transaksi_layanan/update/(:num)', 'TransaksiLayananController::update/$1'); 
$routes->get('/transaksi_layanan/delete/(:num)', 'TransaksiLayananController::delete/$1');