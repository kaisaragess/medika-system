<?php

namespace App\Controllers;

use App\Models\RekamMedisModel;
use App\Models\PendaftaranModel;
use App\Models\PegawaiModel;

class RekamMedisController extends BaseController
{
    protected $rekamMedisModel;
    protected $pendaftaranModel;
    protected $pegawaiModel;

    public function __construct()
    {
        // Inisialisasi ketiga model
        $this->rekamMedisModel = new RekamMedisModel();
        $this->pendaftaranModel = new PendaftaranModel();
        $this->pegawaiModel = new PegawaiModel();
    }

    // ==========================================
    // 1. READ: Menampilkan Daftar Rekam Medis
    // ==========================================
    public function index()
    {
        // Menggunakan JOIN berlapis agar tampil: No Pendaftaran, Nama Pasien, dan Nama Dokter
        $rekamMedis = $this->rekamMedisModel->select('rekam_medis.*, pendaftaran.no_pendaftaran, pasien.nama as nama_pasien, pegawai.nama as nama_dokter')
                                            ->join('pendaftaran', 'pendaftaran.id = rekam_medis.id_pendaftaran')
                                            ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                            ->join('pegawai', 'pegawai.id = rekam_medis.id_pegawai')
                                            ->orderBy('rekam_medis.tanggal_periksa', 'DESC')
                                            ->findAll();

        $data = [
            'title'       => 'Data Rekam Medis | MedikaSistem',
            'rekam_medis' => $rekamMedis
        ];

        return view('rekam_medis/index', $data);
    }

    // ==========================================
    // 2. CREATE: Menampilkan Form Isi Rekam Medis
    // ==========================================
    public function create()
    {
        // Membuat Kode Rekam Medis Otomatis (Contoh: RM-20260514-001)
        $kd_rekam_medis_otomatis = 'RM-' . date('Ymd') . '-' . rand(100, 999);

        // Ambil data pendaftaran (gabung dengan pasien agar namanya muncul di dropdown)
        // Kita hanya mengambil yang statusnya 'Antri' atau 'Diperiksa' agar dropdown tidak kepanjangan
        $pendaftaranAktif = $this->pendaftaranModel->select('pendaftaran.id, pendaftaran.no_pendaftaran, pasien.nama')
                                                   ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                                   ->whereIn('pendaftaran.status', ['Antri', 'Diperiksa'])
                                                   ->findAll();

        $data = [
            'title'          => 'Isi Rekam Medis | MedikaSistem',
            'validation'     => \Config\Services::validation(),
            'kd_rekam_medis' => $kd_rekam_medis_otomatis,
            'pendaftaran'    => $pendaftaranAktif,
            'dokter'         => $this->pegawaiModel->where('role', 'Dokter')->findAll() // Hanya tampilkan pegawai yang role-nya Dokter
        ];

        return view('rekam_medis/create', $data);
    }

    // ==========================================
    // 3. STORE: Menyimpan Data Rekam Medis
    // ==========================================
    public function store()
    {
        if (!$this->validate([
            'id_pendaftaran' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Data pendaftaran pasien harus dipilih.']
            ],
            'id_pegawai' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Dokter pemeriksa harus dipilih.']
            ],
            'tanggal_periksa' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal periksa harus diisi.']
            ],
            'keluhan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Keluhan pasien harus diisi.']
            ]
        ])) {
            return redirect()->to('/rekam_medis/create')->withInput();
        }

        // Simpan ke database
        $this->rekamMedisModel->save([
            'kd_rekam_medis'  => $this->request->getPost('kd_rekam_medis'),
            'id_pendaftaran'  => $this->request->getPost('id_pendaftaran'),
            'id_pegawai'      => $this->request->getPost('id_pegawai'),
            'tanggal_periksa' => $this->request->getPost('tanggal_periksa'),
            'keluhan'         => $this->request->getPost('keluhan'),
            'diagnosa'        => $this->request->getPost('diagnosa'),
            'tindakan_medis'  => $this->request->getPost('tindakan_medis'),
            'tekanan_darah'   => $this->request->getPost('tekanan_darah'),
            'file'            => $this->request->getPost('file') // Untuk sementara berupa teks link/nama file. Jika butuh upload file asli, logikanya perlu ditambah nanti.
        ]);

        // Opsional & Keren: Otomatis ubah status pendaftaran menjadi 'Selesai' setelah rekam medis diisi
        $this->pendaftaranModel->save([
            'id'     => $this->request->getPost('id_pendaftaran'),
            'status' => 'Selesai'
        ]);

        session()->setFlashdata('pesan', 'Rekam medis berhasil disimpan dan status pasien diperbarui.');
        return redirect()->to('/rekam_medis');
    }

    // ==========================================
    // 4. EDIT: Menampilkan Form Ubah Rekam Medis
    // ==========================================
    public function edit($id)
    {
        $data = [
            'title'       => 'Ubah Rekam Medis | MedikaSistem',
            'validation'  => \Config\Services::validation(),
            'rekam_medis' => $this->rekamMedisModel->find($id),
            // Saat edit, tampilkan semua pendaftaran (tidak hanya yang aktif)
            'pendaftaran' => $this->pendaftaranModel->select('pendaftaran.id, pendaftaran.no_pendaftaran, pasien.nama')
                                                    ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                                    ->findAll(),
            'dokter'      => $this->pegawaiModel->where('role', 'Dokter')->findAll()
        ];

        if (empty($data['rekam_medis'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rekam medis dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('rekam_medis/edit', $data);
    }

    // ==========================================
    // 5. UPDATE: Menyimpan Perubahan Rekam Medis
    // ==========================================
    public function update($id)
    {
        if (!$this->validate([
            'keluhan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Keluhan pasien harus diisi.']
            ]
        ])) {
            return redirect()->to('/rekam_medis/edit/' . $id)->withInput();
        }

        $this->rekamMedisModel->save([
            'id'              => $id,
            'id_pendaftaran'  => $this->request->getPost('id_pendaftaran'),
            'id_pegawai'      => $this->request->getPost('id_pegawai'),
            'tanggal_periksa' => $this->request->getPost('tanggal_periksa'),
            'keluhan'         => $this->request->getPost('keluhan'),
            'diagnosa'        => $this->request->getPost('diagnosa'),
            'tindakan_medis'  => $this->request->getPost('tindakan_medis'),
            'tekanan_darah'   => $this->request->getPost('tekanan_darah'),
            'file'            => $this->request->getPost('file')
        ]);

        session()->setFlashdata('pesan', 'Rekam medis berhasil diperbarui.');
        return redirect()->to('/rekam_medis');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Rekam Medis
    // ==========================================
    public function delete($id)
    {
        $this->rekamMedisModel->delete($id);
        
        session()->setFlashdata('pesan', 'Rekam medis berhasil dihapus.');
        return redirect()->to('/rekam_medis');
    }
}