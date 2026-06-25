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
        $keyword = $this->request->getVar('keyword');

        $data = [
            'title'     => 'Riwayat Transaksi Apotek',
            'transaksi' => $this->transaksiObatModel->getTransaksiLengkap($keyword), // Mengambil data join pasien
            'keyword'   => $keyword
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
                                                    ->whereIn('pendaftaran.status', ['Antri', 'Diperiksa'])
                                                    ->findAll(),
            'daftar_obat' => $obatModel->findAll() 
        ];

        return view('transaksi_obat/create', $data);
    }
    // Memproses penyimpanan transaksi obat ke database (Store)
    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'id_pendaftaran' => 'required',
            'id_obat.*'      => 'required',
            'qty.*'          => 'required|integer|greater_than[0]',
            'aturan_pakai.*' => 'required'
        ])) {
            return redirect()->to('/transaksi_obat/create')->withInput()->with('error', 'Mohon lengkapi data obat dengan benar.');
        }

        $obatModel = new \App\Models\ObatModel();
        
        $idPendaftaran = $this->request->getPost('id_pendaftaran');
        $idObatArr = $this->request->getPost('id_obat');
        $qtyArr = $this->request->getPost('qty');
        $aturanPakaiArr = $this->request->getPost('aturan_pakai');

        $db = \Config\Database::connect();
        $db->transStart();

        for($i = 0; $i < count($idObatArr); $i++) {
            $idObat = $idObatArr[$i];
            $qty = $qtyArr[$i];
            $aturanPakai = $aturanPakaiArr[$i];

            $obat = $obatModel->find($idObat);
            if($obat) {
                $tagihan_obat = $obat['harga'] * $qty;

                $data = [
                    'id_pendaftaran' => $idPendaftaran,
                    'id_obat'        => $idObat,
                    'qty'            => $qty,
                    'aturan_pakai'   => $aturanPakai,
                    'tagihan_obat'   => $tagihan_obat
                ];

                $this->transaksiObatModel->insert($data);

                // kurangi stok obat
                $obatModel->update($idObat, ['qty' => $obat['qty'] - $qty]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi.');
        }

        return redirect()->to('/transaksi_obat')->with('pesan', 'Transaksi obat berhasil ditambahkan ke tagihan pasien!');
    }

    // Menampilkan Form Ubah Transaksi Obat (Edit)
    public function edit($id)
    {
        $obatModel = new \App\Models\ObatModel();

        $data = [
            'title'       => 'Ubah Penebusan Obat',
            'validation'  => \Config\Services::validation(),
            'transaksi'   => $this->transaksiObatModel->find($id),
            'pendaftaran' => $this->pendaftaranModel->select('pendaftaran.*, pasien.nama as nama_pasien')
                                                    ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                                    ->findAll(),
            'daftar_obat' => $obatModel->findAll() 
        ];

        if (empty($data['transaksi'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data transaksi obat dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('transaksi_obat/edit', $data);
    }

    // Memproses perubahan transaksi obat (Update)
    public function update($id)
    {
        // Validasi input
        if (!$this->validate([
            'id_pendaftaran' => 'required',
            'id_obat'        => 'required',
            'qty'            => 'required|integer|greater_than[0]',
            'aturan_pakai'   => 'required'
        ])) {
            return redirect()->to('/transaksi_obat/edit/' . $id)->withInput();
        }

        // Ambil data obat untuk menghitung harga
        $obatModel = new \App\Models\ObatModel();
        $idObat = $this->request->getPost('id_obat');
        $qtyBaru = $this->request->getPost('qty');
        $obat = $obatModel->find($idObat);
        $tagihan_obat = $obat['harga'] * $qtyBaru;

        // Logika kembalikan stok lama, lalu kurangi stok baru
        $transaksiLama = $this->transaksiObatModel->find($id);
        if ($transaksiLama['id_obat'] == $idObat) {
            $selisihQty = $qtyBaru - $transaksiLama['qty'];
            $obatModel->update($idObat, ['qty' => $obat['qty'] - $selisihQty]);
        } else {
            // Jika ganti obat
            $obatLama = $obatModel->find($transaksiLama['id_obat']);
            $obatModel->update($transaksiLama['id_obat'], ['qty' => $obatLama['qty'] + $transaksiLama['qty']]);
            $obatModel->update($idObat, ['qty' => $obat['qty'] - $qtyBaru]);
        }

        $data = [
            'id'             => $id,
            'id_pendaftaran' => $this->request->getPost('id_pendaftaran'),
            'id_obat'        => $idObat,
            'qty'            => $qtyBaru,
            'aturan_pakai'   => $this->request->getPost('aturan_pakai'),
            'tagihan_obat'   => $tagihan_obat
        ];

        $this->transaksiObatModel->save($data);

        return redirect()->to('/transaksi_obat')->with('pesan', 'Transaksi obat berhasil diperbarui!');
    }

    // Menghapus Data Transaksi Obat (Delete)
    public function delete($id)
    {
        $transaksiLama = $this->transaksiObatModel->find($id);
        if ($transaksiLama) {
            $obatModel = new \App\Models\ObatModel();
            $obat = $obatModel->find($transaksiLama['id_obat']);
            // Kembalikan stok
            $obatModel->update($transaksiLama['id_obat'], ['qty' => $obat['qty'] + $transaksiLama['qty']]);
            
            $this->transaksiObatModel->delete($id);
        }
        
        session()->setFlashdata('pesan', 'Data transaksi obat berhasil dihapus dari tagihan.');
        return redirect()->to('/transaksi_obat');
    }
}