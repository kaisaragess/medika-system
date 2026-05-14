<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Data yang dikirim ke View
        $data = [
            'title' => 'Dashboard | MedikaSistem'
            // Nanti kamu bisa menambahkan query untuk menghitung total pasien, dll di sini
            // 'total_pasien' => $pasienModel->countAll(),
        ];

        return view('dashboard', $data);
    }
}