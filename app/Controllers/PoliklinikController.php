<?php

namespace App\Controllers;

use App\Models\PoliklinikModel;

class PoliklinikController extends BaseController
{
    protected $poliklinikModel;

    public function __construct()
    {
        $this->poliklinikModel = new PoliklinikModel();
    }

    // ==========================================
    // 1. READ: Menampilkan Daftar Poliklinik
    // ==========================================
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $poliklinik = $this->poliklinikModel->like('kode_poli', $keyword)->findAll();
        } else {
            $poliklinik = $this->poliklinikModel->findAll();
        }

        $data = [
            'title'      => 'Data Poliklinik | MedikaSistem',
            'poliklinik' => $poliklinik,
            'keyword'    => $keyword
        ];

        return view('poliklinik/index', $data);
    }

    // ==========================================
    // 2. CREATE: Menampilkan Form Tambah Poli
    // ==========================================
    public function create()
    {
        $data = [
            'title'      => 'Tambah Data Poliklinik | MedikaSistem',
            'validation' => \Config\Services::validation()
        ];

        return view('poliklinik/create', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data Poli Baru
    // ==========================================
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'nama_poli' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama poliklinik harus diisi.']
            ],
            'daftar_spesialisasi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Daftar spesialisasi harus diisi.']
            ],
            'kode_poli' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kode poliklinik harus diisi.']
            ]
        ])) {
            return redirect()->to('/poliklinik/create')->withInput();
        }

        $this->poliklinikModel->save([
            'nama_poli' => $this->request->getPost('nama_poli'),
            'daftar_spesialisasi' => $this->request->getPost('daftar_spesialisasi'),
            'kode_poli' => $this->request->getPost('kode_poli')
        ]);

        session()->setFlashdata('pesan', 'Data poliklinik berhasil ditambahkan.');
        return redirect()->to('/poliklinik');
    }

    // ==========================================
    // 4. EDIT: Menampilkan Form Ubah Poli
    // ==========================================
    public function edit($id)
    {
        $data = [
            'title'      => 'Ubah Data Poliklinik | MedikaSistem',
            'validation' => \Config\Services::validation(),
            'poliklinik' => $this->poliklinikModel->find($id)
        ];

        if (empty($data['poliklinik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Poliklinik dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('poliklinik/edit', $data);
    }

    // ==========================================
    // 5. UPDATE: Menyimpan Perubahan Data Poli
    // ==========================================
    public function update($id)
    {
        if (!$this->validate([
            'nama_poli' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama poliklinik harus diisi.']
            ],
            'daftar_spesialisasi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Daftar spesialisasi harus diisi.']
            ],
            'kode_poli' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kode poliklinik harus diisi.']
            ]
        ])) {
            return redirect()->to('/poliklinik/edit/' . $id)->withInput();
        }

        $this->poliklinikModel->save([
            'id'        => $id,
            'nama_poli' => $this->request->getPost('nama_poli'),
            'daftar_spesialisasi' => $this->request->getPost('daftar_spesialisasi'),
            'kode_poli'   => $this->request->getPost('kode_poli')
        ]);

        session()->setFlashdata('pesan', 'Data poliklinik berhasil diperbarui.');
        return redirect()->to('/poliklinik');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Poli
    // ==========================================
    public function delete($id)
    {
        $this->poliklinikModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data poliklinik berhasil dihapus.');
        return redirect()->to('/poliklinik');
    }
}