<?php

namespace App\Controllers;

class HistoriController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Kita gunakan query builder untuk melakukan multi-JOIN dari tabel pendaftaran sebagai pusatnya.
        $builder = $db->table('pendaftaran pd');
        $builder->select('
            pd.id as id_pendaftaran,
            pd.no_pendaftaran,
            pd.tgl_daftar as tanggal,
            pd.status as status_pendaftaran,
            ps.id as id_pasien,
            ps.nik,
            ps.nama as nama_pasien,
            pl.nama_poli,
            rm.kd_rekam_medis,
            rm.diagnosa,
            rm.tindakan_medis,
            rm.file as pdf_rekam_medis
        ');
        
        // Join Pasien
        $builder->join('pasien ps', 'ps.id = pd.id_pasien');
        // Join Poliklinik
        $builder->join('poliklinik pl', 'pl.id = pd.id_poli');
        // Join Rekam Medis (LEFT JOIN karena pendaftaran mungkin belum punya rekam medis)
        $builder->join('rekam_medis rm', 'rm.id_pendaftaran = pd.id', 'left');
        
        // Urutkan dari kunjungan terbaru
        $builder->orderBy('pd.tgl_daftar', 'DESC');
        
        $histori = $builder->get()->getResultArray();

        // Ambil semua rekam medis untuk setiap pasien agar bisa dipilih di dropdown histori
        $builderRm = $db->table('rekam_medis rm');
        $builderRm->select('rm.*, pd.id_pasien, pd.no_pendaftaran');
        $builderRm->join('pendaftaran pd', 'pd.id = rm.id_pendaftaran');
        $builderRm->orderBy('rm.tanggal_periksa', 'DESC');
        $semuaRm = $builderRm->get()->getResultArray();

        $rekamMedisPasien = [];
        foreach($semuaRm as $rm) {
            $rekamMedisPasien[$rm['id_pasien']][] = $rm;
        }

        $data = [
            'title'   => 'Histori Kunjungan & Rekam Medis',
            'histori' => $histori,
            'rekamMedisPasien' => $rekamMedisPasien
        ];

        return view('histori/index', $data);
    }
}
