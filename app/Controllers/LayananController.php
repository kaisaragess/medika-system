<?php

namespace App\Controllers;

use App\Models\LayananModel;

class LayananController extends BaseController
{
    protected $layananModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
    }

    // ==========================================
    // 1. READ: Menampilkan Daftar Layanan
    // ==========================================
    public function index()
    {
        $data = [
            'title'   => 'Data Layanan Medis | MedikaSistem',
            'layanan' => $this->layananModel->findAll()
        ];

        return view('layanan/index', $data);
    }

    // ==========================================
    // 2. CREATE: Menampilkan Form Tambah Layanan
    // ==========================================
    public function create()
    {
        $data = [
            'title'      => 'Tambah Data Layanan | MedikaSistem',
            'validation' => \Config\Services::validation()
        ];

        return view('layanan/create', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data Layanan Baru
    // ==========================================
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'kd_layanan' => [
                'rules'  => 'required|is_unique[layanan.kd_layanan]',
                'errors' => [
                    'required'  => 'Kode layanan harus diisi.',
                    'is_unique' => 'Kode layanan sudah terdaftar. Gunakan kode lain.'
                ]
            ],
            'nama_layanan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama layanan harus diisi.']
            ],
            'kategori' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kategori layanan harus dipilih/diisi.']
            ],
            'harga' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Harga layanan harus diisi.',
                    'numeric'  => 'Harga harus berupa angka.'
                ]
            ]
        ])) {
            return redirect()->to('/layanan/create')->withInput();
        }

        $this->layananModel->save([
            'kd_layanan'   => $this->request->getPost('kd_layanan'),
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'kategori'     => $this->request->getPost('kategori'),
            'harga'        => $this->request->getPost('harga'),
            'is_active'    => $this->request->getPost('is_active') ?? 1 // Default aktif (1) jika kosong
        ]);

        session()->setFlashdata('pesan', 'Data layanan medis berhasil ditambahkan.');
        return redirect()->to('/layanan');
    }

    // ==========================================
    // 4. EDIT: Menampilkan Form Ubah Layanan
    // ==========================================
    public function edit($id)
    {
        $data = [
            'title'      => 'Ubah Data Layanan | MedikaSistem',
            'validation' => \Config\Services::validation(),
            'layanan'    => $this->layananModel->find($id)
        ];

        if (empty($data['layanan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Layanan dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('layanan/edit', $data);
    }

    // ==========================================
    // 5. UPDATE: Menyimpan Perubahan Data Layanan
    // ==========================================
    public function update($id)
    {
        $layananLama = $this->layananModel->find($id);
        $ruleKdLayanan = ($layananLama['kd_layanan'] == $this->request->getPost('kd_layanan')) ? 'required' : 'required|is_unique[layanan.kd_layanan]';

        if (!$this->validate([
            'kd_layanan' => [
                'rules'  => $ruleKdLayanan,
                'errors' => [
                    'required'  => 'Kode layanan harus diisi.',
                    'is_unique' => 'Kode layanan sudah terdaftar.'
                ]
            ],
            'nama_layanan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama layanan harus diisi.']
            ],
            'kategori' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kategori layanan harus dipilih/diisi.']
            ],
            'harga' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Harga layanan harus diisi.',
                    'numeric'  => 'Harga harus berupa angka.'
                ]
            ]
        ])) {
            return redirect()->to('/layanan/edit/' . $id)->withInput();
        }

        $this->layananModel->save([
            'id'           => $id,
            'kd_layanan'   => $this->request->getPost('kd_layanan'),
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'kategori'     => $this->request->getPost('kategori'),
            'harga'        => $this->request->getPost('harga'),
            'is_active'    => $this->request->getPost('is_active') // 1 (Aktif) atau 0 (Tidak Aktif)
        ]);

        session()->setFlashdata('pesan', 'Data layanan medis berhasil diperbarui.');
        return redirect()->to('/layanan');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Layanan
    // ==========================================
    public function delete($id)
    {
        $this->layananModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data layanan medis berhasil dihapus.');
        return redirect()->to('/layanan');
    }
}