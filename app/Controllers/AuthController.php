<?php

namespace App\Controllers;

use App\Models\PegawaiModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    public function process()
    {
        $pegawaiModel = new PegawaiModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $pegawaiModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                
                // CEK STATUS APPROVAL ADMIN DI SINI
                if ($user['is_active'] == 0) {
                    return redirect()->back()->with('error', 'Akun Anda sedang menunggu persetujuan (ACC) dari Super Admin. Silakan hubungi bagian IT.');
                }

                $token = bin2hex(random_bytes(32));
                $pegawaiModel->update($user['id'], ['token' => $token]);

                $ses_data = [
                    'id_pegawai' => $user['id'],
                    'nama'       => $user['nama'],
                    'username'   => $user['username'],
                    'role'       => $user['role'],
                    'token'      => $token,
                    'isLoggedIn' => TRUE
                ];
                session()->set($ses_data);
                return redirect()->to('/')->with('pesan', 'Selamat datang kembali, ' . $user['nama']);
            } else {
                return redirect()->back()->with('error', 'Password yang Anda masukkan salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }

    // --- FITUR REGISTRASI ---
   public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $poliModel = new \App\Models\PoliklinikModel();
        $poliklinik = $poliModel->findAll();
        
        // Kita pecah string spesialisasi dari tabel poli menjadi array
        $groupedSpesialisasi = [];
        foreach($poliklinik as $p) {
            // Cek apakah daftar_spesialisasi ada isinya
            if (!empty($p['daftar_spesialisasi'])) {
                // Pecah string berdasarkan koma, dan hilangkan spasi berlebih
                $spesialisasiArray = array_map('trim', explode(',', $p['daftar_spesialisasi']));
                $groupedSpesialisasi[$p['id']] = $spesialisasiArray;
            } else {
                // Jika kosong, beri nilai default
                $groupedSpesialisasi[$p['id']] = ['Dokter Umum']; 
            }
        }
        
        $data = [
            'poliklinik' => $poliklinik,
            'spesialisasi_map' => json_encode($groupedSpesialisasi) 
        ];
        
        return view('auth/register', $data);
    }

    public function processRegister()
    {
        // 1. Validasi Input Ketat
        if (!$this->validate([
            'username'   => 'required|is_unique[pegawai.username]',
            'nomor_telp' => 'required|numeric|min_length[10]|max_length[13]'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Validasi Gagal: Pastikan Username belum dipakai dan Nomor Telepon berisi 10 hingga 13 digit angka.');
        }

        $pegawaiModel = new \App\Models\PegawaiModel();
        
        // 2. Siapkan data untuk disimpan
        // Jika bukan Dokter, kosongkan id_poli dan spesialisasi
        $role = $this->request->getPost('role');
        $idPoli = ($role == 'Dokter') ? $this->request->getPost('id_poli') : null;
        $spesialisasi = ($role == 'Dokter') ? $this->request->getPost('spesialisasi') : null;

        $data = [
            'nama'         => $this->request->getPost('nama'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $role,
            'nomor_telp'   => $this->request->getPost('nomor_telp'),
            'alamat'       => $this->request->getPost('alamat'),
            'id_poli'      => empty($idPoli) ? null : $idPoli,
            'spesialisasi' => empty($spesialisasi) ? null : $spesialisasi,
            'is_active'    => 0 // 0 = Belum di ACC Admin
        ];

        $pegawaiModel->save($data);

        return redirect()->to('/login')->with('pesan', 'Registrasi berhasil! Akun Anda sedang direview oleh Super Admin.');
    }

    public function logout()
    {
        $session = session();
        if ($session->get('id_pegawai')) {
            $pegawaiModel = new PegawaiModel();
            $pegawaiModel->update($session->get('id_pegawai'), ['token' => null]);
        }
        $session->destroy();
        return redirect()->to('/login')->with('pesan', 'Anda telah berhasil logout.');
    }
}