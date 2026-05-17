<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\DetailPembayaranModel;
use App\Models\PendaftaranModel;
use App\Models\TransaksiObatModel;
use App\Models\TransaksiLayananModel;
use App\Models\TransaksiKamarModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class PembayaranController extends BaseController
{
    protected $pembayaranModel;
    protected $detailPembayaranModel;
    protected $pendaftaranModel;
    protected $transaksiObatModel;
    protected $transaksiLayananModel;
    protected $transaksiKamarModel;

    public function __construct()
    {
        $this->pembayaranModel       = new PembayaranModel();
        $this->detailPembayaranModel = new DetailPembayaranModel();
        $this->pendaftaranModel      = new PendaftaranModel();
        $this->transaksiObatModel    = new TransaksiObatModel();
        $this->transaksiLayananModel = new TransaksiLayananModel();
        $this->transaksiKamarModel   = new TransaksiKamarModel();
    }

    public function index()
    {
        // Get all pembayaran with related pasien data
        $db = \Config\Database::connect();
        $builder = $db->table('pembayaran p');
        $builder->select('p.*, pd.no_pendaftaran, ps.nama as nama_pasien');
        $builder->join('pendaftaran pd', 'pd.id = p.id_pendaftaran');
        $builder->join('pasien ps', 'ps.id = pd.id_pasien');
        $builder->orderBy('p.tgl_bayar', 'DESC');
        
        $pembayaran = $builder->get()->getResultArray();
        
        // Map tgl_bayar to tanggal_bayar for the view
        foreach ($pembayaran as &$p) {
            $p['tanggal_bayar'] = $p['tgl_bayar'];
            $p['metode_pembayaran'] = $p['metode_bayar'];
        }

        $data = [
            'pembayaran' => $pembayaran
        ];

        return view('pembayaran/index', $data);
    }

    public function create()
    {
        // Only show pendaftaran that have been 'Selesai' and haven't been paid completely yet
        // For simplicity, we just fetch 'Selesai' status
        $db = \Config\Database::connect();
        $builder = $db->table('pendaftaran pd');
        $builder->select('pd.id, pd.no_pendaftaran, ps.nama');
        $builder->join('pasien ps', 'ps.id = pd.id_pasien');
        $builder->where('pd.status', 'Selesai');
        // Filter out those already fully paid
        $builder->whereNotIn('pd.id', function($builder) {
            return $builder->select('id_pendaftaran')->from('pembayaran')->where('status_pembayaran', 'Lunas');
        });
        
        $pendaftaran = $builder->get()->getResultArray();

        $data = [
            'pendaftaran' => $pendaftaran,
            'no_tagihan'  => 'INV-' . date('YmdHis'),
            'validation'  => \Config\Services::validation()
        ];

        return view('pembayaran/create', $data);
    }

    public function store()
    {
        $rules = [
            'id_pendaftaran' => 'required',
            'metode_pembayaran' => 'required',
            'status_pembayaran' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/pembayaran/create')->withInput()->with('validation', $this->validator);
        }

        $idPendaftaran = $this->request->getPost('id_pendaftaran');
        $noTagihan = $this->request->getPost('no_tagihan');
        $tanggalBayar = $this->request->getPost('tanggal_bayar');
        $metodePembayaran = $this->request->getPost('metode_pembayaran');
        $statusPembayaran = $this->request->getPost('status_pembayaran');

        // 1. Calculate Obat
        // Kita join dengan tabel obat untuk mendapatkan nama obat
        $db = \Config\Database::connect();
        $builderObat = $db->table('transaksi_obat to');
        $builderObat->select('to.*, o.nama_obat');
        $builderObat->join('obat o', 'o.id = to.id_obat');
        $builderObat->where('to.id_pendaftaran', $idPendaftaran);
        $transObat = $builderObat->get()->getResultArray();
        
        $totalObat = 0;
        foreach ($transObat as $to) {
            $totalObat += $to['tagihan_obat'];
        }

        // 2. Calculate Layanan
        // Kita join dengan tabel layanan untuk mendapatkan nama layanan
        $builderLayanan = $db->table('transaksi_layanan tl');
        $builderLayanan->select('tl.*, l.nama_layanan, l.harga as harga_satuan');
        $builderLayanan->join('layanan l', 'l.id = tl.id_layanan');
        $builderLayanan->where('tl.id_pendaftaran', $idPendaftaran);
        $transLayanan = $builderLayanan->get()->getResultArray();
        
        $totalLayanan = 0;
        foreach ($transLayanan as $tl) {
            $totalLayanan += $tl['total_harga'];
        }

        // 3. Calculate Kamar
        // Kita join dengan tabel kamar
        $builderKamar = $db->table('transaksi_kamar tk');
        $builderKamar->select('tk.*, k.kd_kmr, k.kelas');
        $builderKamar->join('kamar k', 'k.id = tk.id_kamar');
        $builderKamar->where('tk.id_pendaftaran', $idPendaftaran);
        $transKamar = $builderKamar->get()->getResultArray();
        
        $totalKamar = 0;
        foreach ($transKamar as $tk) {
            $totalKamar += $tk['total_biaya'];
        }

        $grandTotal = $totalObat + $totalLayanan + $totalKamar;

        $db->transStart();

        // Insert to pembayaran
        $dataPembayaran = [
            'id_pendaftaran'    => $idPendaftaran,
            'no_tagihan'        => $noTagihan,
            'id_pegawai'        => session()->get('id_pegawai'),
            'tgl_bayar'         => $tanggalBayar,
            'metode_bayar'      => $metodePembayaran,
            'total_bayar'       => $grandTotal,
            'status_pembayaran' => $statusPembayaran
        ];
        
        $this->pembayaranModel->insert($dataPembayaran);
        $idPembayaran = $this->pembayaranModel->getInsertID();

        // Insert to detail_pembayaran (Individual Items)
        foreach ($transObat as $to) {
            if ($to['tagihan_obat'] > 0) {
                $this->detailPembayaranModel->insert([
                    'id_pembayaran' => $idPembayaran,
                    'jenis_item'    => 'Obat',
                    'nama_item'     => 'Resep Obat: ' . $to['nama_obat'],
                    'biaya'         => $to['tagihan_obat'] / $to['qty'],
                    'qty'           => $to['qty'],
                    'subtotal'      => $to['tagihan_obat']
                ]);
            }
        }
        
        foreach ($transLayanan as $tl) {
            if ($tl['total_harga'] > 0) {
                $this->detailPembayaranModel->insert([
                    'id_pembayaran' => $idPembayaran,
                    'jenis_item'    => 'Layanan',
                    'nama_item'     => 'Tindakan/Layanan: ' . $tl['nama_layanan'],
                    'biaya'         => $tl['harga_satuan'],
                    'qty'           => $tl['qty'],
                    'subtotal'      => $tl['total_harga']
                ]);
            }
        }

        foreach ($transKamar as $tk) {
            if ($tk['total_biaya'] > 0) {
                // Hitung jumlah hari
                $tglMasuk = new \DateTime($tk['tgl_masuk']);
                $tglKeluar = new \DateTime($tk['tgl_keluar']);
                $diff = $tglMasuk->diff($tglKeluar);
                $hari = $diff->days == 0 ? 1 : $diff->days;
                
                $this->detailPembayaranModel->insert([
                    'id_pembayaran' => $idPembayaran,
                    'jenis_item'    => 'Kamar',
                    'nama_item'     => 'Rawat Inap: Kamar ' . $tk['kd_kmr'] . ' (' . $tk['kelas'] . ')',
                    'biaya'         => $tk['total_biaya'] / $hari,
                    'qty'           => $hari,
                    'subtotal'      => $tk['total_biaya']
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pembayaran.');
        }

        return redirect()->to('/pembayaran')->with('pesan', 'Pembayaran kasir berhasil diproses.');
    }

    public function cetak($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembayaran p');
        $builder->select('p.*, pd.no_pendaftaran, ps.nama as nama_pasien');
        $builder->join('pendaftaran pd', 'pd.id = p.id_pendaftaran');
        $builder->join('pasien ps', 'ps.id = pd.id_pasien');
        $builder->where('p.id', $id);
        $pembayaran = $builder->get()->getRowArray();

        if (!$pembayaran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $pembayaran['tanggal_bayar'] = $pembayaran['tgl_bayar'];
        $pembayaran['metode_pembayaran'] = $pembayaran['metode_bayar'];

        $detailPembayaran = $this->detailPembayaranModel->where('id_pembayaran', $id)->findAll();

        $data = [
            'pembayaran' => $pembayaran,
            'detail'     => $detailPembayaran
        ];

        // Load HTML view for PDF
        $html = view('pembayaran/cetak', $data);

        // Instantiate Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Courier');
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream("Kwitansi_" . $pembayaran['no_tagihan'] . ".pdf", ["Attachment" => false]);
        exit();
    }
}
