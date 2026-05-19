<?php

namespace App\Controllers;

use App\Models\TransaksiLayananModel;
use App\Models\PendaftaranModel;
use App\Models\LayananModel;

class TransaksiLayananController extends BaseController
{
    protected $transaksiLayananModel;
    protected $pendaftaranModel;
    protected $layananModel;

    public function __construct()
    {
        // Inisialisasi ketiga model
        $this->transaksiLayananModel = new TransaksiLayananModel();
        $this->pendaftaranModel = new PendaftaranModel();
        $this->layananModel = new LayananModel();
    }

    // ==========================================
    // 1. READ: Menampilkan Daftar Transaksi Layanan
    // ==========================================
    public function index()
    {
        // JOIN untuk menampilkan No Pendaftaran, Nama Pasien, dan Nama Layanan
        $transaksi = $this->transaksiLayananModel
            ->select('transaksi_layanan.*, pendaftaran.no_pendaftaran, pasien.nama as nama_pasien, layanan.nama_layanan')
            ->join('pendaftaran', 'pendaftaran.id = transaksi_layanan.id_pendaftaran')
            ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
            ->join('layanan', 'layanan.id = transaksi_layanan.id_layanan')
            ->orderBy('transaksi_layanan.id', 'DESC')
            ->findAll();

        $data = [
            'title'     => 'Transaksi Layanan Medis | MedikaSistem',
            'transaksi' => $transaksi
        ];

        return view('transaksi_layanan/index', $data);
    }

    // ==========================================
    // 2. CREATE: Menampilkan Form Tambah Layanan
    // ==========================================
    public function create()
    {
        $data = [
            'title'       => 'Input Layanan Pasien | MedikaSistem',
            'validation'  => \Config\Services::validation(),
            // Tampilkan pasien yang tidak batal
            'pendaftaran' => $this->pendaftaranModel->select('pendaftaran.id, pendaftaran.no_pendaftaran, pasien.nama')
                                                    ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                                    ->whereIn('pendaftaran.status', ['Antri', 'Diperiksa'])
                                                    ->findAll(),
            // Hanya tampilkan layanan yang sedang aktif (is_active = 1)
            'layanan'     => $this->layananModel->where('is_active', 1)->findAll()
        ];

        return view('transaksi_layanan/create', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data dan Menghitung Harga Otomatis
    // ==========================================
    public function store()
    {
        if (!$this->validate([
            'id_pendaftaran' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Data pendaftaran/pasien harus dipilih.']
            ],
            'id_layanan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Layanan medis harus dipilih.']
            ],
            'qty' => [
                'rules'  => 'required|integer|greater_than[0]',
                'errors' => [
                    'required'     => 'Jumlah (Qty) harus diisi.',
                    'integer'      => 'Qty harus berupa angka bulat.',
                    'greater_than' => 'Qty minimal adalah 1.'
                ]
            ]
        ])) {
            return redirect()->to('/transaksi_layanan/create')->withInput();
        }

        // Ambil data layanan dari database untuk mengetahui harga per item-nya
        $id_layanan = $this->request->getPost('id_layanan');
        $layanan = $this->layananModel->find($id_layanan);
        
        // Kalkulasi Total Harga (Harga x Qty)
        $qty = $this->request->getPost('qty');
        $total_harga = $layanan['harga'] * $qty;

        $this->transaksiLayananModel->save([
            'id_pendaftaran' => $this->request->getPost('id_pendaftaran'),
            'id_layanan'     => $id_layanan,
            'qty'            => $qty,
            'total_harga'    => $total_harga // Disimpan hasil kalkulasi otomatisnya
        ]);

        session()->setFlashdata('pesan', 'Tindakan/Layanan medis berhasil ditambahkan ke tagihan pasien.');
        return redirect()->to('/transaksi_layanan');
    }

    // ==========================================
    // 4. EDIT: Menampilkan Form Ubah Transaksi
    // ==========================================
    public function edit($id)
    {
        $data = [
            'title'       => 'Ubah Transaksi Layanan | MedikaSistem',
            'validation'  => \Config\Services::validation(),
            'transaksi'   => $this->transaksiLayananModel->find($id),
            'pendaftaran' => $this->pendaftaranModel->select('pendaftaran.id, pendaftaran.no_pendaftaran, pasien.nama')
                                                    ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                                    ->findAll(),
            'layanan'     => $this->layananModel->findAll()
        ];

        if (empty($data['transaksi'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data transaksi layanan dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('transaksi_layanan/edit', $data);
    }

    // ==========================================
    // 5. UPDATE: Menyimpan Perubahan dan Hitung Ulang
    // ==========================================
    public function update($id)
    {
        if (!$this->validate([
            'qty' => [
                'rules'  => 'required|integer|greater_than[0]',
                'errors' => [
                    'required'     => 'Jumlah (Qty) harus diisi.',
                    'integer'      => 'Qty harus berupa angka bulat.',
                    'greater_than' => 'Qty minimal adalah 1.'
                ]
            ]
        ])) {
            return redirect()->to('/transaksi_layanan/edit/' . $id)->withInput();
        }

        // Hitung ulang harga jika layanan atau qty diubah
        $id_layanan = $this->request->getPost('id_layanan');
        $layanan = $this->layananModel->find($id_layanan);
        
        $qty = $this->request->getPost('qty');
        $total_harga = $layanan['harga'] * $qty;

        $this->transaksiLayananModel->save([
            'id'             => $id,
            'id_pendaftaran' => $this->request->getPost('id_pendaftaran'),
            'id_layanan'     => $id_layanan,
            'qty'            => $qty,
            'total_harga'    => $total_harga
        ]);

        session()->setFlashdata('pesan', 'Transaksi layanan berhasil diperbarui.');
        return redirect()->to('/transaksi_layanan');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Transaksi
    // ==========================================
    public function delete($id)
    {
        $this->transaksiLayananModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data transaksi layanan berhasil dihapus dari tagihan.');
        return redirect()->to('/transaksi_layanan');
    }
}