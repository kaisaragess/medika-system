<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\PoliklinikModel;

class PegawaiController extends BaseController
{
    protected $pegawaiModel;
    protected $poliklinikModel;

    public function __construct()
    {
        // Menginisialisasi kedua model
        $this->pegawaiModel = new PegawaiModel();
        $this->poliklinikModel = new PoliklinikModel();
    }

    // ==========================================
    // 1. READ: Menampilkan Daftar Pegawai
    // ==========================================
    public function index()
    {
        // Kita menggunakan Query Builder JOIN agar nama_poli muncul, bukan cuma id_poli-nya saja
        $pegawai = $this->pegawaiModel->select('pegawai.*, poliklinik.nama_poli')
                                      ->join('poliklinik', 'poliklinik.id = pegawai.id_poli', 'left')
                                      ->findAll();

        $data = [
            'title'   => 'Data Pegawai | MedikaSistem',
            'pegawai' => $pegawai
        ];

        return view('pegawai/index', $data);
    }

    // ==========================================
    // 2. CREATE: Menampilkan Form Tambah Pegawai
    // ==========================================
    public function create()
    {
        $data = [
            'title'      => 'Tambah Data Pegawai | MedikaSistem',
            'validation' => \Config\Services::validation(),
            'poliklinik' => $this->poliklinikModel->findAll() // Mengirim data poli untuk dropdown pilihan
        ];

        return view('pegawai/create', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data Pegawai Baru
    // ==========================================
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama pegawai harus diisi.']
            ],
            'role' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Role/Jabatan pegawai harus dipilih.']
            ]
        ])) {
            return redirect()->to('/pegawai/create')->withInput();
        }

        // Jika id_poli kosong (karena pegawai bukan dokter, misalnya kasir), ubah jadi NULL
        $idPoli = $this->request->getPost('id_poli');
        $idPoli = empty($idPoli) ? null : $idPoli;

        $this->pegawaiModel->save([
            'id_poli'      => $idPoli,
            'nama'         => $this->request->getPost('nama'),
            'alamat'       => $this->request->getPost('alamat'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
            'nomor_telp'   => $this->request->getPost('nomor_telp'),
            'role'         => $this->request->getPost('role')
        ]);

        session()->setFlashdata('pesan', 'Data pegawai berhasil ditambahkan.');
        return redirect()->to('/pegawai');
    }

    // ==========================================
    // 4. EDIT: Menampilkan Form Ubah Pegawai
    // ==========================================
    public function edit($id)
    {
        $data = [
            'title'      => 'Ubah Data Pegawai | MedikaSistem',
            'validation' => \Config\Services::validation(),
            'pegawai'    => $this->pegawaiModel->find($id),
            'poliklinik' => $this->poliklinikModel->findAll() // Untuk dropdown saat edit
        ];

        if (empty($data['pegawai'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pegawai dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('pegawai/edit', $data);
    }

    // ==========================================
    // 5. UPDATE: Menyimpan Perubahan Data Pegawai
    // ==========================================
    public function update($id)
    {
        if (!$this->validate([
            'nama' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama pegawai harus diisi.']
            ],
            'role' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Role/Jabatan pegawai harus dipilih.']
            ]
        ])) {
            return redirect()->to('/pegawai/edit/' . $id)->withInput();
        }

        $idPoli = $this->request->getPost('id_poli');
        $idPoli = empty($idPoli) ? null : $idPoli;

        $this->pegawaiModel->save([
            'id'           => $id,
            'id_poli'      => $idPoli,
            'nama'         => $this->request->getPost('nama'),
            'alamat'       => $this->request->getPost('alamat'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
            'nomor_telp'   => $this->request->getPost('nomor_telp'),
            'role'         => $this->request->getPost('role')
        ]);

        session()->setFlashdata('pesan', 'Data pegawai berhasil diperbarui.');
        return redirect()->to('/pegawai');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Pegawai
    // ==========================================
    public function delete($id)
    {
        $this->pegawaiModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data pegawai berhasil dihapus.');
        return redirect()->to('/pegawai');
    }
}