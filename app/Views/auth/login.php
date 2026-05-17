<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem | MedikaSistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; 
            margin: 0;
            overflow-x: hidden;
        }
        .split-container { 
            display: flex; 
            min-height: 100vh; 
        }
        .split-image { 
            flex: 1.2; 
            background: url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=2000&auto=format&fit=crop') no-repeat center center; 
            background-size: cover; 
            position: relative;
        }
        .split-image::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.7) 0%, rgba(11, 23, 39, 0.8) 100%);
        }
        .split-image-text {
            position: absolute;
            bottom: 8%;
            left: 8%;
            color: white;
            z-index: 10;
            max-width: 600px;
        }
        .split-form { 
            flex: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 40px;
            background-color: #ffffff;
            box-shadow: -10px 0 30px rgba(0,0,0,0.05);
            z-index: 5;
        }
        .login-wrapper { 
            width: 100%; 
            max-width: 420px; 
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            background-color: #f4f6f9;
            border: 1px solid #e9ecef;
        }
        .form-control:focus {
            background-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .input-group-text {
            background-color: #f4f6f9;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .btn-primary {
            padding: 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }
        .icon-box {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            border-radius: 20px;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
        }
        @media (max-width: 992px) {
            .split-image { display: none; }
            .split-form { background-color: #f4f6f9; }
            .login-wrapper { 
                background: white; 
                padding: 40px; 
                border-radius: 20px; 
                box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            }
        }
    </style>
</head>
<body>

<div class="split-container">
    <div class="split-image d-none d-lg-block">
        <div class="split-image-text">
            <h1 class="display-4 fw-bold mb-3">Layanan Kesehatan Masa Depan</h1>
            <p class="fs-5 opacity-75">Kelola data pasien, rekam medis, farmasi, dan administrasi klinik Anda dalam satu ekosistem yang terintegrasi dan aman.</p>
        </div>
    </div>
    
    <div class="split-form">
        <div class="login-wrapper">
            <div class="icon-box">
                <i class="bi bi-hospital fs-1"></i>
            </div>
            <h2 class="fw-bold mb-1">Selamat Datang!</h2>
            <p class="text-muted mb-4">Silakan masuk ke akun MedikaSistem Anda.</p>

            <!-- Notifikasi Error/Sukses -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger small py-2 d-flex align-items-center rounded-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success small py-2 d-flex align-items-center rounded-3">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <form action="/auth/process" method="post">
                <?= csrf_field(); ?>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Username</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-person text-primary"></i></span>
                        <input type="text" class="form-control border-start-0" name="username" required autofocus placeholder="Masukkan username">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-lock text-primary"></i></span>
                        <input type="password" class="form-control border-start-0" name="password" required placeholder="Masukkan password">
                    </div>
                </div>
                
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary">Login ke Sistem</button>
                </div>
            </form>

            <div class="text-center mt-4 pt-4 border-top">
                <p class="small text-muted mb-2">Pegawai baru? Belum memiliki akun?</p>
                <a href="/register" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold"><i class="bi bi-person-plus me-1"></i> Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>