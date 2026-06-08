<?php

namespace App\Controllers;

use App\Models\ObatModel;

class ObatController extends BaseController
{
    protected $obatModel;

    public function __construct()
    {
        // Memanggil ObatModel
        $this->obatModel = new ObatModel();
    }

    // read
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $obat = $this->obatModel->like('kd_obat', $keyword)->findAll();
        } else {
            $obat = $this->obatModel->findAll();
        }

        $data = [
            'title'   => 'Daftar Obat | MedikaSistem',
            'obat'    => $obat,
            'keyword' => $keyword
        ];

        return view('obat/index', $data);
    }

    // create
    public function create()
    {
        $data = [
            'title'      => 'Tambah Data Obat | MedikaSistem',
            'validation' => \Config\Services::validation() // Mengirim pesan error jika validasi gagal
        ];

        return view('obat/create', $data);
    }

    // store data obat baru
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'kd_obat' => [
                'rules'  => 'required|is_unique[obat.kd_obat]',
                'errors' => [
                    'required'  => 'Kode obat harus diisi.',
                    'is_unique' => 'Kode obat sudah terdaftar. Gunakan kode lain.'
                ]
            ],
            'nama_obat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama obat harus diisi.']
            ],
            'harga' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Harga obat harus diisi.',
                    'numeric'  => 'Harga obat harus berupa angka tanpa titik/koma selain desimal.'
                ]
            ],
            'qty' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah stok (qty) harus diisi.',
                    'integer'  => 'Jumlah stok harus berupa bilangan bulat.'
                ]
            ]
        ])) {
            // Jika gagal, kembalikan ke form beserta input lama
            return redirect()->to('/obat/create')->withInput();
        }

        // Jika berhasil, simpan ke database
        $this->obatModel->save([
            'kd_obat'   => $this->request->getPost('kd_obat'),
            'nama_obat' => $this->request->getPost('nama_obat'),
            'jenis'     => $this->request->getPost('jenis'),
            'dosis'     => $this->request->getPost('dosis'),
            'satuan'    => $this->request->getPost('satuan'),
            'harga'     => $this->request->getPost('harga'),
            'qty'       => $this->request->getPost('qty'),
            'expired'   => $this->request->getPost('expired')
        ]);

        session()->setFlashdata('pesan', 'Data obat berhasil ditambahkan ke inventori.');
        return redirect()->to('/obat');
    }

    // edit data obat
    public function edit($id)
    {
        $data = [
            'title'      => 'Ubah Data Obat | MedikaSistem',
            'validation' => \Config\Services::validation(),
            'obat'       => $this->obatModel->find($id)
        ];

        // Mencegah error jika ID di URL diubah manual dan tidak ada di database
        if (empty($data['obat'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Obat dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('obat/edit', $data);
    }

    // simpan update
    public function update($id)
    {
        // Cek data lama agar validasi unique kode obat tidak error jika kodenya tidak diubah
        $obatLama = $this->obatModel->find($id);
        $ruleKdObat = ($obatLama['kd_obat'] == $this->request->getPost('kd_obat')) ? 'required' : 'required|is_unique[obat.kd_obat]';

        if (!$this->validate([
            'kd_obat' => [
                'rules'  => $ruleKdObat,
                'errors' => [
                    'required'  => 'Kode obat harus diisi.',
                    'is_unique' => 'Kode obat sudah terdaftar.'
                ]
            ],
            'nama_obat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama obat harus diisi.']
            ],
            'harga' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Harga obat harus diisi.',
                    'numeric'  => 'Harga obat harus berupa angka.'
                ]
            ]
        ])) {
            return redirect()->to('/obat/edit/' . $id)->withInput();
        }

        // Menyimpan perubahan
        $this->obatModel->save([
            'id'        => $id, // Penting! Jika ada ID, CI4 akan melakukan UPDATE. Jika tidak, akan menjadi INSERT.
            'kd_obat'   => $this->request->getPost('kd_obat'),
            'nama_obat' => $this->request->getPost('nama_obat'),
            'jenis'     => $this->request->getPost('jenis'),
            'dosis'     => $this->request->getPost('dosis'),
            'satuan'    => $this->request->getPost('satuan'),
            'harga'     => $this->request->getPost('harga'),
            'qty'       => $this->request->getPost('qty'),
            'expired'   => $this->request->getPost('expired')
        ]);

        session()->setFlashdata('pesan', 'Data obat berhasil diperbarui.');
        return redirect()->to('/obat');
    }

    // delete data obat
    public function delete($id)
    {
        $this->obatModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data obat berhasil dihapus dari inventori.');
        return redirect()->to('/obat');
    }
}