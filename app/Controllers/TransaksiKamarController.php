<?php

namespace App\Controllers;

use App\Models\TransaksiKamarModel;
use App\Models\PendaftaranModel;
use App\Models\KamarModel; 

class TransaksiKamarController extends BaseController
{
    protected $transaksiKamarModel;
    protected $pendaftaranModel;
    protected $kamarModel;

    public function __construct()
    {
        $this->transaksiKamarModel = new TransaksiKamarModel();
        $this->pendaftaranModel = new PendaftaranModel();
        $this->kamarModel = new KamarModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');

        // Tambahkan pendaftaran.no_pendaftaran di bagian select
        $query = $this->transaksiKamarModel->select('transaksi_kamar.*, pendaftaran.no_pendaftaran, pasien.nama as nama_pasien, kamar.kd_kmr, kamar.kelas, kamar.harga_per_malam')
                                            ->join('pendaftaran', 'pendaftaran.id = transaksi_kamar.id_pendaftaran')
                                            ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                            ->join('kamar', 'kamar.id = transaksi_kamar.id_kamar');

        if ($keyword) {
            $query = $query->like('pendaftaran.no_pendaftaran', $keyword);
        }

        $transaksi = $query->orderBy('transaksi_kamar.status', 'ASC')->findAll();

        $data = [
            'title'     => 'Manajemen Rawat Inap',
            'transaksi' => $transaksi,
            'keyword'   => $keyword
        ];

        return view('transaksi_kamar/index', $data);
    }
    public function create()
    {
        $data = [
            'title'       => 'Check-in Kamar Pasien',
            'pendaftaran' => $this->pendaftaranModel->select('pendaftaran.*, pasien.nama as nama_pasien')
                                                    ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                                    ->findAll(),
            // PERBAIKAN 2: Menggunakan kolom 'status' (bukan status_kamar) untuk mencari kamar yang Tersedia
            'daftar_kamar'=> $this->kamarModel->where('status', 'Tersedia')->findAll() 
        ];

        return view('transaksi_kamar/create', $data);
    }

    public function store()
        {
            // Hapus pembuatan $noInap, langsung gunakan id_pendaftaran
            $idKamar = $this->request->getPost('id_kamar');

            $data = [
                'id_pendaftaran' => $this->request->getPost('id_pendaftaran'),
                'id_kamar'       => $idKamar,
                'tgl_masuk'      => $this->request->getPost('tgl_masuk') . ' ' . date('H:i:s'),
                'status'         => 'Dirawat',
                'total_biaya'    => 0
            ];

            $this->transaksiKamarModel->save($data);
            $this->kamarModel->update($idKamar, ['status' => 'Terisi']);

            return redirect()->to('/transaksi_kamar')->with('pesan', 'Pasien berhasil masuk ke kamar!');
        }

    public function checkout($id)
    {
        $transaksi = $this->transaksiKamarModel->join('kamar', 'kamar.id = transaksi_kamar.id_kamar')->find($id);
        
        $tglMasuk = new \DateTime($transaksi['tgl_masuk']);
        $tglKeluar = new \DateTime(date('Y-m-d H:i:s'));
        
        $durasi = $tglMasuk->diff($tglKeluar)->days;
        if ($durasi == 0) $durasi = 1;

        $totalBiaya = $durasi * $transaksi['harga_per_malam'];

        $this->transaksiKamarModel->update($id, [
            'tgl_keluar'  => date('Y-m-d H:i:s'),
            'total_biaya' => $totalBiaya,
            'status'      => 'Pulang'
        ]);

        // PERBAIKAN 4: Kembalikan status kamar master menjadi 'Tersedia'
        $this->kamarModel->update($transaksi['id_kamar'], ['status' => 'Tersedia']);

        return redirect()->to('/transaksi_kamar')->with('pesan', 'Pasien telah check-out. Total biaya inap: Rp ' . number_format($totalBiaya, 0, ',', '.'));
    }

    // Fungsi untuk menampilkan form Edit
    public function edit($id)
        {
            $data = [
                'title'        => 'Edit Data Rawat Inap',
                // Gunakan join agar kita bisa menarik no_pendaftaran untuk ditampilkan di form edit
                'transaksi'    => $this->transaksiKamarModel->select('transaksi_kamar.*, pendaftaran.no_pendaftaran')
                                                            ->join('pendaftaran', 'pendaftaran.id = transaksi_kamar.id_pendaftaran')
                                                            ->where('transaksi_kamar.id', $id)
                                                            ->first(),
                'daftar_kamar' => $this->kamarModel->findAll() 
            ];

            return view('transaksi_kamar/edit', $data);
        }

    // Fungsi untuk memproses penyimpanan Edit
    public function update($id)
    {
        $idKamarBaru = $this->request->getPost('id_kamar');
        $idKamarLama = $this->request->getPost('id_kamar_lama');

        $data = [
            'id_kamar' => $idKamarBaru,
            'status'   => $this->request->getPost('status')
        ];

        $this->transaksiKamarModel->update($id, $data);

        // Jika kamar diubah, update status master kamarnya
        if ($idKamarBaru != $idKamarLama) {
            $this->kamarModel->update($idKamarLama, ['status' => 'Tersedia']); // Kosongkan yang lama
            $this->kamarModel->update($idKamarBaru, ['status' => 'Terisi']);   // Isi yang baru
        }

        // Jika status diubah jadi pulang manual, kosongkan kamarnya
        if ($this->request->getPost('status') == 'Pulang') {
            $this->kamarModel->update($idKamarBaru, ['status' => 'Tersedia']);
        }

        return redirect()->to('/transaksi_kamar')->with('pesan', 'Data rawat inap berhasil diperbarui!');
    }
}