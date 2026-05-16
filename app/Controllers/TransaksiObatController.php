<?php

namespace App\Controllers;

use App\Models\TransaksiObatModel;
use App\Models\PendaftaranModel;
use App\Models\ObatModel; // Pastikan Anda memiliki model master obat

class TransaksiObatController extends BaseController
{
    protected $transaksiObatModel;
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->transaksiObatModel = new TransaksiObatModel();
        $this->pendaftaranModel = new PendaftaranModel();
    }

    // Menampilkan halaman utama transaksi obat (Index)
    public function index()
    {
        $data = [
            'title'     => 'Riwayat Transaksi Apotek',
            'transaksi' => $this->transaksiObatModel->getTransaksiLengkap() // Mengambil data join pasien
        ];

        return view('transaksi_obat/index', $data);
    }

    // Menampilkan form tambah transaksi obat (Create)
    public function create()
    {
        $obatModel = new \App\Models\ObatModel();

        $data = [
            'title'       => 'Input Penebusan Obat',
            'validation'  => \Config\Services::validation(), // <-- Tambahkan baris ini
            'pendaftaran' => $this->pendaftaranModel->select('pendaftaran.*, pasien.nama as nama_pasien')
                                                    ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                                    ->where('pendaftaran.status', 'Selesai')
                                                    ->findAll(),
            'daftar_obat' => $obatModel->findAll() 
        ];

        return view('transaksi_obat/create', $data);
    }
    // Memproses penyimpanan transaksi obat ke database (Store)
    public function store()
    {
        // Membuat nomor transaksi apotek otomatis (Format: NOTA-YYYYMMDD-XXXX)
        $noTransaksi = 'NOTA-' . date('Ymd') . '-' . rand(1000, 9999);

        $data = [
            'no_transaksi'      => $noTransaksi,
            'id_pendaftaran'    => $this->request->getPost('id_pendaftaran'),
            'tgl_transaksi'     => date('Y-m-d H:i:s'),
            'total_biaya'       => $this->request->getPost('total_biaya'),
            'status_pembayaran' => $this->request->getPost('status_pembayaran') ?? 'Belum Lunas'
        ];

        $this->transaksiObatModel->save($data);

        return redirect()->to('/transaksi_obat')->with('pesan', 'Transaksi obat ' . $noTransaksi . ' berhasil disimpan!');
    }

    // Menampilkan detail item obat yang dibeli (Detail)
    public function detail($id)
    {
        $data = [
            'title'     => 'Detail Transaksi Apotek',
            'transaksi' => $this->transaksiObatModel->find($id)
            // Jika Anda memiliki tabel detail_transaksi_obat, Anda bisa melakukan join di sini
        ];

        return view('transaksi_obat/detail', $data);
    }
}