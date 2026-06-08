<?php

namespace App\Controllers;

use App\Models\KamarModel;

class KamarController extends BaseController
{
    protected $kamarModel;

    public function __construct()
    {
        $this->kamarModel = new KamarModel();
    }

    // ==========================================
    // 1. READ: Menampilkan Daftar Kamar
    // ==========================================
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $kamar = $this->kamarModel->like('kd_kmr', $keyword)->findAll();
        } else {
            $kamar = $this->kamarModel->findAll();
        }

        $data = [
            'title'   => 'Data Kamar | MedikaSistem',
            'kamar'   => $kamar,
            'keyword' => $keyword
        ];

        return view('kamar/index', $data);
    }

    // ==========================================
    // 2. CREATE: Menampilkan Form Tambah Kamar
    // ==========================================
    public function create()
    {
        $data = [
            'title'      => 'Tambah Data Kamar | MedikaSistem',
            'validation' => \Config\Services::validation()
        ];

        return view('kamar/create', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data Kamar Baru
    // ==========================================
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'kd_kmr' => [
                'rules'  => 'required|is_unique[kamar.kd_kmr]',
                'errors' => [
                    'required'  => 'Kode kamar harus diisi.',
                    'is_unique' => 'Kode kamar sudah ada. Gunakan kode lain.'
                ]
            ],
            'kelas' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kelas kamar harus dipilih.']
            ],
            'harga_per_malam' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Harga per malam harus diisi.',
                    'numeric'  => 'Harga harus berupa angka.'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Status kamar harus dipilih.']
            ]
        ])) {
            return redirect()->to('/kamar/create')->withInput();
        }

        $this->kamarModel->save([
            'kd_kmr'          => $this->request->getPost('kd_kmr'),
            'kelas'           => $this->request->getPost('kelas'),
            'harga_per_malam' => $this->request->getPost('harga_per_malam'),
            'status'          => $this->request->getPost('status')
        ]);

        session()->setFlashdata('pesan', 'Data kamar berhasil ditambahkan.');
        return redirect()->to('/kamar');
    }

    // ==========================================
    // 4. EDIT: Menampilkan Form Ubah Kamar
    // ==========================================
    public function edit($id)
    {
        $data = [
            'title'      => 'Ubah Data Kamar | MedikaSistem',
            'validation' => \Config\Services::validation(),
            'kamar'      => $this->kamarModel->find($id)
        ];

        if (empty($data['kamar'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kamar dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('kamar/edit', $data);
    }

    // ==========================================
    // 5. UPDATE: Menyimpan Perubahan Data Kamar
    // ==========================================
    public function update($id)
    {
        $kamarLama = $this->kamarModel->find($id);
        $ruleKdKmr = ($kamarLama['kd_kmr'] == $this->request->getPost('kd_kmr')) ? 'required' : 'required|is_unique[kamar.kd_kmr]';

        if (!$this->validate([
            'kd_kmr' => [
                'rules'  => $ruleKdKmr,
                'errors' => [
                    'required'  => 'Kode kamar harus diisi.',
                    'is_unique' => 'Kode kamar sudah ada.'
                ]
            ],
            'kelas' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kelas kamar harus dipilih.']
            ],
            'harga_per_malam' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Harga per malam harus diisi.',
                    'numeric'  => 'Harga harus berupa angka.'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Status kamar harus dipilih.']
            ]
        ])) {
            return redirect()->to('/kamar/edit/' . $id)->withInput();
        }

        $this->kamarModel->save([
            'id'              => $id,
            'kd_kmr'          => $this->request->getPost('kd_kmr'),
            'kelas'           => $this->request->getPost('kelas'),
            'harga_per_malam' => $this->request->getPost('harga_per_malam'),
            'status'          => $this->request->getPost('status')
        ]);

        session()->setFlashdata('pesan', 'Data kamar berhasil diperbarui.');
        return redirect()->to('/kamar');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Kamar
    // ==========================================
    public function delete($id)
    {
        $this->kamarModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data kamar berhasil dihapus.');
        return redirect()->to('/kamar');
    }
}