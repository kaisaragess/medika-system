<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;
use App\Models\PoliklinikModel;

class PendaftaranController extends BaseController
{
    protected $pendaftaranModel;
    protected $pasienModel;

    public function __construct()
    {
        // Inisialisasi kedua model
        $this->pendaftaranModel = new PendaftaranModel();
        $this->pasienModel = new PasienModel();
    }

    // ==========================================
    // 1. READ: Menampilkan Daftar Kunjungan/Pendaftaran
    // ==========================================
    public function index()
    {
        // Menggunakan JOIN agar nama dan NIK pasien muncul di tabel pendaftaran
        $pendaftaran = $this->pendaftaranModel->select('pendaftaran.*, pasien.nama as nama_pasien, pasien.nik')
                                              ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                              ->orderBy('pendaftaran.tgl_daftar', 'DESC') // Urutkan dari yang terbaru
                                              ->findAll();

        $data = [
            'title'       => 'Data Pendaftaran Pasien | MedikaSistem',
            'pendaftaran' => $pendaftaran
        ];

        return view('pendaftaran/index', $data);
    }

    // ==========================================
    // 2. CREATE: Menampilkan Form Pendaftaran Baru
    // ==========================================
    public function create()
    {
        $pasienModel = new PasienModel();
        $poliModel = new PoliklinikModel();

        $semuaPoli = $poliModel->findAll();
        $poliUnik = [];
        $namaPoliTerdaftar = [];

        foreach ($semuaPoli as $pl) {
            if (!in_array($pl['nama_poli'], $namaPoliTerdaftar)) {
                $poliUnik[] = $pl;
                $namaPoliTerdaftar[] = $pl['nama_poli'];
            }
        }

        $data = [
            'title'  => 'Pendaftaran Kunjungan Baru',
            'pasien' => $pasienModel->findAll(),
            'poli'   => $poliUnik,
            'temp_data' => session()->get('temp_kunjungan') 
        ];

        return view('pendaftaran/create', $data);
    }

    // Tambahkan fungsi review() ini
    public function review()
    {
        $rules = [
            'id_pasien' => ['rules' => 'required', 'errors' => ['required' => 'Pasien harus dipilih.']],
            'id_poli'   => ['rules' => 'required', 'errors' => ['required' => 'Tujuan Poliklinik harus dipilih.']],
            'keluhan_awal' => ['rules' => 'required|min_length[5]', 'errors' => ['required' => 'Keluhan awal wajib diisi.', 'min_length' => 'Keluhan minimal 5 karakter.']]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $pasienModel = new PasienModel();
        $poliModel = new PoliklinikModel();
        
        $pasien = $pasienModel->find($this->request->getPost('id_pasien'));
        $poli = $poliModel->find($this->request->getPost('id_poli'));

        $pendaftaranModel = new PendaftaranModel();
        $hariIni = date('Y-m-d');
        $jumlahAntreanHariIni = $pendaftaranModel->where('id_poli', $poli['id'])
                                                 ->like('tgl_daftar', $hariIni)
                                                 ->countAllResults();

        if ($jumlahAntreanHariIni >= 10) {
            return redirect()->back()->withInput()->with('error', 'Mohon maaf, kuota antrean untuk Poliklinik ' . $poli['nama_poli'] . ' hari ini sudah penuh (Maksimal 10 pasien).');
        }

        $tempData = [
            'id_pasien'    => $pasien['id'],
            'nama_pasien'  => $pasien['nama'], 
            'id_poli'      => $poli['id'],
            'nama_poli'    => $poli['nama_poli'], 
            'keluhan_awal' => $this->request->getPost('keluhan_awal'),
            'tanggal'      => date('Y-m-d H:i:s'),
            'petugas'      => session()->get('nama')
        ];

        session()->set('temp_kunjungan', $tempData);
        return redirect()->to('/pendaftaran/confirm');
    }

    // Tambahkan fungsi confirm() ini
    public function confirm()
    {
        if (!session()->has('temp_kunjungan')) {
            return redirect()->to('/pendaftaran/create')->with('error', 'Tidak ada data kunjungan yang sedang diproses.');
        }

        $data = [
            'title'     => 'Konfirmasi Pendaftaran',
            'temp_data' => session()->get('temp_kunjungan')
        ];

        return view('pendaftaran/confirm', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data Pendaftaran
    // ==========================================
   public function store()
    {
        if (!session()->has('temp_kunjungan')) {
            return redirect()->to('/pendaftaran/create');
        }

        $tempData = session()->get('temp_kunjungan');
        $pendaftaranModel = new PendaftaranModel();

        // 1. Membuat Kode Pendaftaran Otomatis (Format: REG-YYYYMMDD-XXXX)
        $tanggalHariIni = date('Ymd');
        $randomNumber = rand(1000, 9999);
        $noPendaftaranBaru = 'REG-' . $tanggalHariIni . '-' . $randomNumber;

        // 2. Data yang akan masuk ke Database
        $saveData = [
            'no_pendaftaran' => $noPendaftaranBaru, // Menggunakan kode unik
            'id_pasien'      => $tempData['id_pasien'],
            'id_poli'        => $tempData['id_poli'],
            'keluhan_awal'   => $tempData['keluhan_awal'],
            'tgl_daftar'     => $tempData['tanggal'], // Menggunakan tgl_daftar
            'status'         => 'Antri' 
        ];

        $pendaftaranModel->save($saveData);
        session()->remove('temp_kunjungan');

        return redirect()->to('/pendaftaran')->with('pesan', 'Pendaftaran dengan No: ' . $noPendaftaranBaru . ' berhasil disimpan!');
    }

    // Tambahkan fungsi cancel() ini
    public function cancel()
    {
        session()->remove('temp_kunjungan');
        return redirect()->to('/pendaftaran/create')->with('pesan', 'Pendaftaran kunjungan dibatalkan.');
    }

    // ==========================================
    // 4. EDIT: Menampilkan Form Ubah Status Pendaftaran
    // ==========================================
    public function edit($id)
    {
        $data = [
            'title'       => 'Ubah Data Pendaftaran | MedikaSistem',
            'validation'  => \Config\Services::validation(),
            'pendaftaran' => $this->pendaftaranModel->find($id),
            'pasien'      => $this->pasienModel->findAll() 
        ];

        if (empty($data['pendaftaran'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pendaftaran dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('pendaftaran/edit', $data);
    }

    // ==========================================
    // 5. UPDATE: Menyimpan Perubahan Pendaftaran
    // ==========================================
    // Fungsi untuk memproses data dari form Edit
    public function update($id)
    {
        $pendaftaranModel = new \App\Models\PendaftaranModel();

        // Kita hanya mengambil data yang memang boleh diubah oleh petugas
        // (Status dan Keluhan Awal)
        $data = [
            'status'       => $this->request->getPost('status'),
            'keluhan_awal' => $this->request->getPost('keluhan_awal')
        ];

        // Lakukan update ke database berdasarkan ID
        $pendaftaranModel->update($id, $data);

        // Kembalikan ke halaman daftar antrean dengan pesan sukses
        return redirect()->to('/pendaftaran')->with('pesan', 'Data kunjungan berhasil diperbarui!');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Pendaftaran
    // ==========================================
    public function delete($id)
    {
        // Ingat! Karena kita menggunakan ON DELETE CASCADE di database,
        // Jika pendaftaran ini dihapus, semua transaksi terkait (kamar, obat, dll) akan ikut terhapus otomatis!
        $this->pendaftaranModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data pendaftaran berhasil dihapus.');
        return redirect()->to('/pendaftaran');
    }

    
}