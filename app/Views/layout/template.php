<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'MedikaSistem'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        :root {
            --primary-color: #0056B3;
            --secondary-color: #0B877D;
            --tertiary-color: #E2E8F0;
            --app-bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-primary: #1E293B;
            --text-secondary: #64748B;

            /* Override Bootstrap 5 theme colors globally */
            --bs-primary: #0056B3;
            --bs-primary-rgb: 0, 86, 179;
            --bs-success: #10B981;
            --bs-success-rgb: 16, 185, 129;
            --bs-danger: #EF4444;
            --bs-danger-rgb: 239, 68, 68;
            --bs-warning: #F59E0B;
            --bs-warning-rgb: 245, 158, 11;
        }

        body {
            background-color: var(--app-bg);
            color: var(--text-primary);
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
        }

        /* Sidebar Styling (White Theme) */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s;
            overflow-y: auto;
            background-color: #FFFFFF !important;
            border-right: 1px solid var(--tertiary-color);
            color: var(--text-primary) !important;
        }

        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        #main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            transition: all 0.3s;
            padding: 24px 32px !important;
        }

        /* Navigation Links */
        .nav-link {
            color: var(--text-secondary) !important;
            margin-bottom: 5px;
            border-radius: 8px;
            transition: 0.2s;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: var(--app-bg);
            color: var(--primary-color) !important;
        }

        .nav-link.active {
            background-color: var(--primary-color) !important;
            color: #FFFFFF !important;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Card Styles */
        .card {
            border-radius: 8px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
            border: none;
            background-color: var(--card-bg);
        }

        .card-header,
        .card-title {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }

        /* Input and Form Styles */
        .form-control,
        .form-select {
            border-radius: 4px;
            border-color: #CBD5E1;
            color: var(--text-primary);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 86, 179, 0.25);
        }

        label {
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* Table Styles */
        .table {
            color: var(--text-primary);
            font-size: 14px;
        }

        .table thead th {
            background-color: #F1F5F9;
            color: var(--text-secondary);
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            border-bottom: 1px solid var(--tertiary-color);
        }

        .table tbody tr {
            border-bottom: 1px solid var(--tertiary-color);
        }

        .table-hover tbody tr:hover {
            background-color: #F8FAFC !important;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #004494;
            border-color: #004494;
        }

        .btn-success {
            background-color: #10B981;
            border-color: #10B981;
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }

        .btn-danger {
            background-color: #EF4444;
            border-color: #EF4444;
        }

        .btn-danger:hover {
            background-color: #DC2626;
            border-color: #DC2626;
        }

        .btn-warning {
            background-color: #F59E0B;
            border-color: #F59E0B;
            color: white;
        }

        .btn-warning:hover {
            background-color: #D97706;
            border-color: #D97706;
            color: white;
        }

        /* Typography Helper Classes */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .text-success {
            color: #10B981 !important;
        }

        .text-danger {
            color: #EF4444 !important;
        }

        .text-warning {
            color: #F59E0B !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        .text-dark {
            color: var(--text-primary) !important;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <div id="sidebar" class="d-flex flex-column p-3 shadow-sm">
            <a href="/" class="d-flex align-items-center mb-4 mt-2 text-dark text-decoration-none">
                <i class="bi bi-hospital fs-3 text-primary me-2"></i>
                <span class="fs-4 fw-bold">Medika<span class="text-primary">Sistem</span></span>
            </a>

            <hr class="text-secondary mt-0">

            <?php $role = session()->get('role') ?? 'Admin'; ?>

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link active">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>

                <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold"
                    style="font-size: 12px; letter-spacing: 1px;">Transaksi Utama</li>

                <?php if (in_array($role, ['Admin', 'Perawat', 'Dokter'])): ?>
                    <li>
                        <a href="/pendaftaran" class="nav-link">
                            <i class="bi bi-person-lines-fill"></i> Antrean & Pendaftaran
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role'), ['Admin', 'Dokter', 'Perawat'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/rekam_medis">
                            <i class="bi bi-file-earmark-medical me-2"></i> Rekam Medis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/histori">
                            <i class="bi bi-clock-history me-2"></i> Histori Kunjungan
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array($role, ['Admin', 'Perawat'])): ?>
                    <li>
                        <a href="/transaksi_kamar" class="nav-link">
                            <i class="bi bi-file-medical"></i> Rawat Inap / Kamar
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array($role, ['Admin', 'Apoteker'])): ?>
                    <li>
                        <a href="/transaksi_obat" class="nav-link">
                            <i class="bi bi-capsule"></i> Transaksi Apotek
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array($role, ['Admin', 'Kasir'])): ?>
                    <li>
                        <a href="/transaksi_layanan" class="nav-link">
                            <i class="bi bi-receipt-cutoff"></i> Transaksi Layanan
                        </a>
                    </li>
                    <li>
                        <a href="/pembayaran" class="nav-link">
                            <i class="bi bi-cash-coin"></i> Kasir / Pembayaran
                        </a>
                    </li>
                <?php endif; ?>

                <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold"
                    style="font-size: 12px; letter-spacing: 1px;">Data Master</li>

                <?php if (in_array($role, ['Admin', 'Perawat'])): ?>
                    <li>
                        <a href="/pasien" class="nav-link">
                            <i class="bi bi-people"></i> Master Pasien
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array($role, ['Admin', 'Apoteker'])): ?>
                    <li>
                        <a href="/obat" class="nav-link">
                            <i class="bi bi-box-seam"></i> Master Farmasi
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'Admin'): ?>
                    <li>
                        <a href="/kamar" class="nav-link">
                            <i class="bi bi-door-open"></i> Master Kamar
                        </a>
                    </li>
                    <li>
                        <a href="/layanan" class="nav-link">
                            <i class="bi bi-clipboard2-pulse"></i> Master Layanan/Tarif
                        </a>
                    </li>
                    <li>
                        <a href="/poliklinik" class="nav-link">
                            <i class="bi bi-hospital"></i> Master Poliklinik
                        </a>
                    </li>
                    <li>
                        <a href="/pegawai" class="nav-link">
                            <i class="bi bi-person-gear"></i> Manajemen Pegawai
                        </a>
                    </li>
                <?php endif; ?>
            </ul>



            <hr class="text-secondary">

            <div class="dropdown">
                <?php $namaUser = session()->get('nama') ?? 'Guest'; ?>
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($namaUser); ?>&background=0d6efd&color=fff"
                        alt="" width="32" height="32" class="rounded-circle me-2">
                    <div>
                        <strong><?= esc($namaUser); ?></strong><br>
                        <small class="text-info"><?= esc($role); ?></small>
                    </div>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item text-danger fw-bold" href="/logout"><i class="bi bi-box-arrow-left"></i>
                            Sign out</a></li>
                </ul>
            </div>
        </div>

        <div id="main-content" class="p-4 p-md-5">
            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>