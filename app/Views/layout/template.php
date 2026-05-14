<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menampilkan judul dinamis dari Controller -->
    <title><?= $title ?? 'MedikaSistem'; ?></title>
    
    <!-- Memanggil CSS Bootstrap dari folder lokal public/bootstrap/css/ -->
    <link href="<?= base_url('bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- Memanggil Bootstrap Icons (Tetap pakai CDN karena ringan, atau bisa diunduh terpisah nanti) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
</head>
<body class="bg-light">

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/"><i class="bi bi-hospital"></i> MedikaSistem</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Menu Transaksi Utama -->
                    <li class="nav-item">
                        <a class="nav-link" href="/pendaftaran">Pendaftaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/rekam_medis">Rekam Medis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transaksi_layanan">Layanan Medis</a>
                    </li>
                    
                    <!-- Menu Dropdown Data Master -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Data Master
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/pasien">Data Pasien</a></li>
                            <li><a class="dropdown-item" href="/obat">Data Obat</a></li>
                            <li><a class="dropdown-item" href="/layanan">Data Layanan</a></li>
                            <li><a class="dropdown-item" href="/kamar">Data Kamar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/pegawai">Data Pegawai</a></li>
                            <li><a class="dropdown-item" href="/poliklinik">Data Poliklinik</a></li>
                        </ul>
                    </li>
                </ul>
                <a href="/logout" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?');">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- ================= KONTEN UTAMA ================= -->
    <div class="container mt-4">
        <!-- Di sinilah konten dari file view lain akan disuntikkan oleh CI4 -->
        <?= $this->renderSection('content'); ?>
    </div>

    <!-- ================= FOOTER ================= -->
    <footer class="text-center mt-5 mb-4 text-muted">
        <small>&copy; <?= date('Y'); ?> MedikaSistem. All rights reserved.</small>
    </footer>

    <!-- Memanggil Javascript Bootstrap dari folder lokal public/bootstrap/js/ -->
    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>