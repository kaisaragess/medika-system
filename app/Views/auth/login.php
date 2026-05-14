<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem | MedikaSistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { 
            background-color: #f4f6f9; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            padding: 20px;
        }
        .login-card { 
            border-radius: 1rem; 
            border: none; 
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); 
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-hospital" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="fw-bold">MedikaSistem</h4>
                        <p class="text-muted small">Silakan login untuk mengakses portal pegawai</p>
                    </div>

                    <!-- Notifikasi Error/Sukses dari Controller -->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger small py-2 text-center">
                            <i class="bi bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success small py-2 text-center">
                            <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/auth/process" method="post">
                        <?= csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" name="username" required autofocus placeholder="Masukkan username">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 bg-light" name="password" required placeholder="Masukkan password">
                            </div>
                        </div>
                        
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">Login ke Sistem</button>
                        </div>
                    </form>

                    <!-- Tombol Menuju Halaman Register -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="small text-muted mb-1">Belum memiliki akun pegawai?</p>
                        <a href="/register" class="text-decoration-none fw-bold small"><i class="bi bi-person-plus"></i> Ajukan Akses Pendaftaran</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>