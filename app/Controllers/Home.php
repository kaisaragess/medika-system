<?php

namespace App\Controllers;

use App\Models\PoliklinikModel;
use App\Models\PendaftaranModel;

class Home extends BaseController
{
    public function index()
    {
        $poliModel = new PoliklinikModel();
        $pendaftaranModel = new PendaftaranModel();

        // Get unique polyclinics
        $semuaPoli = $poliModel->findAll();
        $poliUnik = [];
        $namaPoliTerdaftar = [];

        foreach ($semuaPoli as $pl) {
            if (!in_array($pl['nama_poli'], $namaPoliTerdaftar)) {
                $poliUnik[] = $pl;
                $namaPoliTerdaftar[] = $pl['nama_poli'];
            }
        }

        $hariIni = date('Y-m-d');
        $kuotaAntrean = [];

        foreach ($poliUnik as $poli) {
            $jumlahAntreanHariIni = $pendaftaranModel->where('id_poli', $poli['id'])
                                                     ->like('tgl_daftar', $hariIni)
                                                     ->countAllResults();
            $sisa = 10 - $jumlahAntreanHariIni;
            if ($sisa < 0) $sisa = 0;

            $kuotaAntrean[] = [
                'nama_poli'  => $poli['nama_poli'],
                'sisa_tiket' => $sisa,
                'terisi'     => $jumlahAntreanHariIni,
                'persentase' => ($jumlahAntreanHariIni / 10) * 100
            ];
        }

        // Data yang dikirim ke View
        $data = [
            'title' => 'Dashboard | MedikaSistem',
            'kuota_antrean' => $kuotaAntrean
        ];

        return view('dashboard', $data);
    }
}