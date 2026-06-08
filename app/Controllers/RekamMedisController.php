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
        $keyword = $this->request->getVar('keyword');

        // Menggunakan JOIN berlapis agar tampil: No Pendaftaran, Nama Pasien, dan Nama Dokter
        $query = $this->rekamMedisModel->select('rekam_medis.*, pendaftaran.no_pendaftaran, pasien.nama as nama_pasien, pegawai.nama as nama_dokter')
                                            ->join('pendaftaran', 'pendaftaran.id = rekam_medis.id_pendaftaran')
                                            ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                            ->join('pegawai', 'pegawai.id = rekam_medis.id_pegawai');

        if ($keyword) {
            $query = $query->like('rekam_medis.kd_rekam_medis', $keyword);
        }

        $rekamMedis = $query->orderBy('rekam_medis.tanggal_periksa', 'DESC')->findAll();

        $data = [
            'title'       => 'Data Rekam Medis | MedikaSistem',
            'rekam_medis' => $rekamMedis,
            'keyword'     => $keyword
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
        $pendaftaranAktif = $this->pendaftaranModel->select('pendaftaran.id, pendaftaran.no_pendaftaran, pendaftaran.keluhan_awal, pasien.nama')
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
            ],
            'file' => [
                'rules'  => 'max_size[file,5120]|ext_in[file,pdf]',
                'errors' => [
                    'max_size' => 'Ukuran file PDF maksimal 5MB.',
                    'ext_in'   => 'Format file harus berupa PDF.'
                ]
            ]
        ])) {
            return redirect()->to('/rekam_medis/create')->withInput();
        }

        // Upload File Logic
        $filePdf = $this->request->getFile('file');
        $namaFile = null;

        if ($filePdf && $filePdf->isValid() && !$filePdf->hasMoved()) {
            $namaFile = $filePdf->getRandomName();
            $filePdf->move(FCPATH . 'uploads/rekam_medis', $namaFile);
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
            'file'            => $namaFile
        ]);

        // Ubah status pendaftaran menjadi 'Diperiksa' (bukan Selesai, karena belum bayar)
        $this->pendaftaranModel->save([
            'id'     => $this->request->getPost('id_pendaftaran'),
            'status' => 'Diperiksa'
        ]);

        session()->setFlashdata('pesan', 'Rekam medis berhasil disimpan dan status pasien diperbarui menjadi Diperiksa.');
        return redirect()->to('/rekam_medis');
    }

    // ==========================================
    // X. READ: Menampilkan Detail Rekam Medis
    // ==========================================
    public function detail($id)
    {
        $rekamMedis = $this->rekamMedisModel->select('rekam_medis.*, pendaftaran.no_pendaftaran, pasien.nama as nama_pasien, pegawai.nama as nama_dokter')
                                            ->join('pendaftaran', 'pendaftaran.id = rekam_medis.id_pendaftaran')
                                            ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                                            ->join('pegawai', 'pegawai.id = rekam_medis.id_pegawai')
                                            ->find($id);

        if (empty($rekamMedis)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rekam medis dengan ID ' . $id . ' tidak ditemukan.');
        }

        $data = [
            'title'       => 'Detail Rekam Medis | MedikaSistem',
            'rekam_medis' => $rekamMedis
        ];

        return view('rekam_medis/detail', $data);
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
            'pendaftaran' => $this->pendaftaranModel->select('pendaftaran.id, pendaftaran.no_pendaftaran, pendaftaran.keluhan_awal, pasien.nama')
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
            ],
            'file' => [
                'rules'  => 'max_size[file,5120]|ext_in[file,pdf]',
                'errors' => [
                    'max_size' => 'Ukuran file PDF maksimal 5MB.',
                    'ext_in'   => 'Format file harus berupa PDF.'
                ]
            ]
        ])) {
            return redirect()->to('/rekam_medis/edit/' . $id)->withInput();
        }

        $rekamMedisLama = $this->rekamMedisModel->find($id);
        $filePdf = $this->request->getFile('file');
        $namaFile = $rekamMedisLama['file']; // default tetap pakai file lama

        // Jika ada file baru yang diupload
        if ($filePdf && $filePdf->isValid() && !$filePdf->hasMoved()) {
            $namaFile = $filePdf->getRandomName();
            $filePdf->move(FCPATH . 'uploads/rekam_medis', $namaFile);
            
            // Hapus file lama jika ada
            if ($rekamMedisLama['file'] && file_exists(FCPATH . 'uploads/rekam_medis/' . $rekamMedisLama['file'])) {
                unlink(FCPATH . 'uploads/rekam_medis/' . $rekamMedisLama['file']);
            }
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
            'file'            => $namaFile
        ]);

        session()->setFlashdata('pesan', 'Rekam medis berhasil diperbarui.');
        return redirect()->to('/rekam_medis');
    }

    // ==========================================
    // 6. DELETE: Menghapus Data Rekam Medis
    // ==========================================
    public function delete($id)
    {
        $rekamMedis = $this->rekamMedisModel->find($id);
        
        // Hapus file fisik jika ada
        if ($rekamMedis && $rekamMedis['file'] && file_exists(FCPATH . 'uploads/rekam_medis/' . $rekamMedis['file'])) {
            unlink(FCPATH . 'uploads/rekam_medis/' . $rekamMedis['file']);
        }

        $this->rekamMedisModel->delete($id);
        
        session()->setFlashdata('pesan', 'Rekam medis berhasil dihapus.');
        return redirect()->to('/rekam_medis');
    }
}