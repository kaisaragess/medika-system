<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Header Welcome & Waktu -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Overview Analytics</h3>
        <p class="text-muted mb-0">Pantau performa MedikaSistem secara real-time.</p>
    </div>
    <div class="text-end d-none d-md-block">
        <p class="mb-0 fw-bold text-primary fs-5" id="jam-digital"></p>
        <p class="text-muted small mb-0"><?= date('l, d F Y'); ?></p>
    </div>
</div>

<!-- 4 Kartu Ringkasan dengan Indikator Tren -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 5px solid #0d6efd !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted fw-bold text-uppercase small">Total Pasien Bulan Ini</div>
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3"><i class="bi bi-people fs-5"></i></div>
                </div>
                <h2 class="fw-bold mb-1">1,284</h2>
                <p class="text-success small mb-0"><i class="bi bi-arrow-up-right-circle"></i> +12.5% <span class="text-muted">dari bulan lalu</span></p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 5px solid #ffc107 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted fw-bold text-uppercase small">Antrean Aktif</div>
                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-3"><i class="bi bi-clipboard2-pulse fs-5"></i></div>
                </div>
                <h2 class="fw-bold mb-1">42</h2>
                <p class="text-danger small mb-0"><i class="bi bi-arrow-up-right-circle"></i> +5.2% <span class="text-muted">lonjakan hari ini</span></p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 5px solid #198754 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted fw-bold text-uppercase small">Pendapatan Hari Ini</div>
                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-3"><i class="bi bi-wallet2 fs-5"></i></div>
                </div>
                <h2 class="fw-bold mb-1">Rp 8.4M</h2>
                <p class="text-success small mb-0"><i class="bi bi-check-circle"></i> Sesuai target harian</p>
            </div>
        </div>
    </div>

    <!-- Area Khusus Prediksi Sistem Cerdas (Machine Learning Mockup) -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 rounded-4 bg-dark text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="fw-bold text-uppercase small text-info"><i class="bi bi-cpu"></i> Prediksi ML Sistem</div>
                </div>
                <h5 class="fw-bold mb-2">Risiko Lonjakan Pasien</h5>
                <div class="progress mb-2 bg-secondary" style="height: 8px;">
                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: 78%"></div>
                </div>
                <p class="small text-light opacity-75 mb-0">Probabilitas tinggi pada Poli Umum (14:00 - 16:00).</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Kolom Kiri: Bar Progress Kapasitas -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold"><i class="bi bi-bar-chart-steps text-primary"></i> Utilisasi Fasilitas & Inventori</h5>
            </div>
            <div class="card-body mt-2">
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold text-muted small">Kapasitas Kamar Inap (Terisi)</span>
                        <span class="fw-bold small text-dark">85%</span>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 85%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold text-muted small">Ketersediaan Stok Obat Kritis</span>
                        <span class="fw-bold small text-dark">42%</span>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 42%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold text-muted small">Beban Kerja Tenaga Medis / Dokter</span>
                        <span class="fw-bold small text-dark">60%</span>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%;"></div>
                    </div>
                </div>

                <!-- Tombol Action Cepat bergaya modern -->
                <div class="row mt-5">
                    <div class="col-sm-4 mb-2">
                        <a href="/pendaftaran/create" class="btn btn-outline-primary w-100 rounded-3 py-2 fw-bold"><i class="bi bi-plus-lg"></i> Pasien Baru</a>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <a href="/rekam_medis/create" class="btn btn-outline-success w-100 rounded-3 py-2 fw-bold"><i class="bi bi-clipboard-check"></i> Rekam Medis</a>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <a href="/transaksi_layanan/create" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-bold"><i class="bi bi-receipt"></i> Kasir</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Aktivitas Terakhir (Timeline) -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="bi bi-activity text-danger"></i> Log Aktivitas</h5>
                <span class="badge bg-primary rounded-pill">Live</span>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item px-0 pt-0 border-0 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3">
                                <i class="bi bi-cash"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Pembayaran Selesai</h6>
                                <p class="mb-0 text-muted small">Tagihan INV-0092 lunas via QRIS.</p>
                                <small class="text-muted" style="font-size: 11px;">Baru saja</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0 border-0 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-info bg-opacity-10 text-info p-2 rounded-circle me-3">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Pemeriksaan Dokter</h6>
                                <p class="mb-0 text-muted small">Poli Gigi selesai memeriksa antrean 12.</p>
                                <small class="text-muted" style="font-size: 11px;">15 menit yang lalu</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0 border-0 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle me-3">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Peringatan Sistem</h6>
                                <p class="mb-0 text-muted small">Stok Paracetamol < 10 strip.</p>
                                <small class="text-muted" style="font-size: 11px;">1 jam yang lalu</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0 border-0">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Pasien Baru Terdaftar</h6>
                                <p class="mb-0 text-muted small">Budi Santoso mendaftar ke Poli Umum.</p>
                                <small class="text-muted" style="font-size: 11px;">2 jam yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Tambahan untuk Jam Digital -->
<script>
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('jam-digital').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
<?= $this->endSection(); ?>