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
        $allPoli = $poliModel->findAll();
        
        $uniquePoli = [];
        $spesialisasiMap = [];
        
        // Mengelompokkan data berdasarkan nama_poli
        foreach($allPoli as $p) {
            $nama = strtoupper($p['nama_poli']); // Jadikan huruf besar agar seragam (UMUM, ANAK, GIGI)
            
            // Masukkan nama poli ke array unik jika belum ada
            if (!in_array($nama, $uniquePoli)) {
                $uniquePoli[] = $nama;
            }
            
            // Masukkan detail spesialisasi ke dalam kelompok poli tersebut
            $spesialisasiMap[$nama][] = [
                'id' => $p['id'],
                'spesialisasi' => $p['daftar_spesialisasi'],
                'kode_poli' => $p['kode_poli']
            ];
        }
        
        $data = [
            'unique_poli' => $uniquePoli,
            'spesialisasi_map' => json_encode($spesialisasiMap) 
        ];
        
        return view('auth/register', $data);
    }

    public function processRegister()
    {
        // 1. Validasi Input Super Ketat
        $rules = [
            'username'   => [
                'rules'  => 'required|is_unique[pegawai.username]',
                'errors' => ['is_unique' => 'Username ini sudah digunakan.']
            ],
            'nomor_telp' => [
                'rules'  => 'required|numeric|min_length[10]|max_length[13]',
                'errors' => ['numeric' => 'Nomor telepon hanya boleh berisi angka.']
            ],
            'password'   => [
                // Minimal 8 karakter, wajib ada huruf besar, huruf kecil, angka, dan simbol
                'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/]',
                'errors' => [
                    'min_length'  => 'Password minimal harus 8 karakter.',
                    'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial (@$!%*?&#).'
                ]
            ],
            'konfirmasi_password' => [
                'rules'  => 'required|matches[password]',
                'errors' => ['matches' => 'Konfirmasi password tidak cocok dengan password di atas.']
            ]
        ];

        if (!$this->validate($rules)) {
            // Mengirimkan error spesifik dari validator
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $pegawaiModel = new \App\Models\PegawaiModel();
        
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
            'is_active'    => 0 
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