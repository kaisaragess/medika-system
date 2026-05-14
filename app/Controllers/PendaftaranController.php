<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;

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
        // Membuat Nomor Pendaftaran Otomatis (Contoh hasil: REG-20260514-8932)
        $no_pendaftaran_otomatis = 'REG-' . date('Ymd') . '-' . rand(1000, 9999);

        $data = [
            'title'          => 'Pendaftaran Pasien Baru | MedikaSistem',
            'validation'     => \Config\Services::validation(),
            'pasien'         => $this->pasienModel->findAll(), // Mengirim data pasien untuk dropdown pilihan
            'no_pendaftaran' => $no_pendaftaran_otomatis
        ];

        return view('pendaftaran/create', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data Pendaftaran
    // ==========================================
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'no_pendaftaran' => [
                'rules'  => 'required|is_unique[pendaftaran.no_pendaftaran]',
                'errors' => [
                    'required'  => 'Nomor pendaftaran tidak boleh kosong.',
                    'is_unique' => 'Nomor pendaftaran sudah digunakan, silakan muat ulang halaman.'
                ]
            ],
            'id_pasien' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Pasien harus dipilih.']
            ]
        ])) {
            return redirect()->to('/pendaftaran/create')->withInput();
        }

        // Simpan data pendaftaran
        $this->pendaftaranModel->save([
            'no_pendaftaran' => $this->request->getPost('no_pendaftaran'),
            'id_pasien'      => $this->request->getPost('id_pasien'),
            // tgl_daftar tidak perlu diinput manual, biarkan MySQL mengisi dengan CURRENT_TIMESTAMP
            'status'         => 'Antri' // Secara default, saat baru daftar statusnya 'Antri'
        ]);

        session()->setFlashdata('pesan', 'Pendaftaran pasien berhasil. Pasien masuk ke daftar antrean.');
        return redirect()->to('/pendaftaran');
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
    public function update($id)
    {
        if (!$this->validate([
            'id_pasien' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Pasien harus dipilih.']
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Status pendaftaran harus dipilih.']
            ]
        ])) {
            return redirect()->to('/pendaftaran/edit/' . $id)->withInput();
        }

        $this->pendaftaranModel->save([
            'id'        => $id,
            'id_pasien' => $this->request->getPost('id_pasien'),
            'status'    => $this->request->getPost('status') // Mengubah status (misal: dari Antri -> Diperiksa -> Selesai)
        ]);

        session()->setFlashdata('pesan', 'Status pendaftaran berhasil diperbarui.');
        return redirect()->to('/pendaftaran');
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