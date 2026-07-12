<?php

namespace App\Controllers;

use App\Models\PasienModel;

class PasienController extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
    }

    // read
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $pasien = $this->pasienModel->like('nik', $keyword)->findAll();
        } else {
            $pasien = $this->pasienModel->findAll();
        }

        $data = [
            'title'   => 'Daftar Pasien | MedikaSistem',
            'pasien'  => $pasien,
            'keyword' => $keyword
        ];

        return view('pasien/index', $data);
    }

    // create
    public function create()
    {
        $data = [
            'title'      => 'Tambah Pasien Baru | MedikaSistem',
            'validation' => \Config\Services::validation() // Mengirim data error validasi ke form
        ];

        return view('pasien/create', $data);
    }

    // store data pasien baru
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'nik'  => [
                'rules'  => 'required|is_unique[pasien.nik]',
                'errors' => [
                    'required'  => 'NIK harus diisi.',
                    'is_unique' => 'NIK sudah terdaftar di sistem.'
                ]
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama pasien harus diisi.'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembalikan ke halaman tambah pasien dengan input lama
            return redirect()->to('/pasien/create')->withInput();
        }

        // Jika berhasil, simpan ke database
        $this->pasienModel->save([
            'nik'           => $this->request->getPost('nik'),
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_telp'       => $this->request->getPost('no_telp'),
            'status'        => $this->request->getPost('status') ?? 'Aktif'
        ]);

        session()->setFlashdata('pesan', 'Data pasien berhasil ditambahkan.');
        return redirect()->to('/pasien');
    }

    // edit
    public function edit($id)
    {
        $data = [
            'title'      => 'Ubah Data Pasien | MedikaSistem',
            'validation' => \Config\Services::validation(),
            'pasien'     => $this->pasienModel->find($id)
        ];

        // Jika data tidak ditemukan
        if (empty($data['pasien'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pasien dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('pasien/edit', $data);
    }

    // update
    public function update($id)
    {
        // Cek data lama untuk validasi NIK (agar tidak error is_unique saat update nama saja)
        $pasienLama = $this->pasienModel->find($id);
        $ruleNIK = ($pasienLama['nik'] == $this->request->getPost('nik')) ? 'required' : 'required|is_unique[pasien.nik]';

        if (!$this->validate([
            'nik'  => [
                'rules'  => $ruleNIK,
                'errors' => [
                    'required'  => 'NIK harus diisi.',
                    'is_unique' => 'NIK sudah terdaftar di sistem.'
                ]
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama pasien harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to('/pasien/edit/' . $id)->withInput();
        }

        $this->pasienModel->save([
            'id'            => $id, 
            'nik'           => $this->request->getPost('nik'),
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_telp'       => $this->request->getPost('no_telp'),
            'status'        => $this->request->getPost('status') ?? 'Aktif'
        ]);

        session()->setFlashdata('pesan', 'Data pasien berhasil diubah.');
        return redirect()->to('/pasien');
    }


}