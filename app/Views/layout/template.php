<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'MedikaSistem'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* CSS untuk mengatur Layout Sidebar */
        body {
            background-color: #f4f6f9;
            overflow-x: hidden;
        }
        #sidebar {
            min-width: 280px;
            max-width: 280px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s;
        }
        #main-content {
            margin-left: 280px; /* Memberi ruang agar konten tidak tertutup sidebar */
            width: calc(100% - 280px);
            min-height: 100vh;
            transition: all 0.3s;
        }
        .nav-link {
            color: #c2c7d0;
            margin-bottom: 5px;
            border-radius: 8px;
            transition: 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <div id="sidebar" class="bg-dark text-white d-flex flex-column p-3 shadow">
            <a href="/" class="d-flex align-items-center mb-4 mt-2 text-white text-decoration-none">
                <i class="bi bi-hospital fs-3 text-primary me-2"></i>
                <span class="fs-4 fw-bold">Medika<span class="text-primary">Sistem</span></span>
            </a>
            
            <hr class="text-secondary mt-0">

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link active">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                
                <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold" style="font-size: 12px; letter-spacing: 1px;">Transaksi Utama</li>
                
                <li>
                    <a href="/pendaftaran" class="nav-link">
                        <i class="bi bi-person-lines-fill"></i> Antrean & Pendaftaran
                    </a>
                </li>
                <li>
                    <a href="/transaksi_kamar" class="nav-link">
                        <i class="bi bi-file-medical"></i> Rawat Inap / Kamar
                    </a>
                </li>
                <li>
                    <a href="/transaksi_obat" class="nav-link">
                        <i class="bi bi-capsule"></i> Transaksi Apotek
                    </a>
                </li>

                <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold" style="font-size: 12px; letter-spacing: 1px;">Data Master</li>

                <li>
                    <a href="/pasien" class="nav-link">
                        <i class="bi bi-people"></i> Database Pasien
                    </a>
                </li>
                <li>
                    <a href="/obat" class="nav-link">
                        <i class="bi bi-box-seam"></i> Master Obat
                    </a>
                </li>
                <li>
                    <a href="/kamar" class="nav-link">
                        <i class="bi bi-door-open"></i> Master Kamar
                    </a>
                </li>
                <li>
                    <a href="/pasien" class="nav-link">
                        <i class="bi bi-people"></i> Master Pasien
                    </a>
                </li>
                <li>
                    <a href="/pegawai" class="nav-link">
                        <i class="bi bi-person-gear"></i> Manajemen Pegawai
                    </a>
                </li>
                <li>
                    <a href="/layanan" class="nav-link">
                        <i class="bi bi-clipboard2-pulse"></i> Master Layanan/Tarif
                    </a>
                </li>
            </ul>
                


            <hr class="text-secondary">
            
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name=Admin+Medika&background=0d6efd&color=fff" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>Admin Medika</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger fw-bold" href="/logout"><i class="bi bi-box-arrow-left"></i> Sign out</a></li>
                </ul>
            </div>
        </div>

        <div id="main-content" class="p-4 p-md-5">
            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>