<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history"></i> Buku Besar Histori Kunjungan</h2>
            <button class="btn btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Laporan</button>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-primary text-nowrap">
                            <tr>
                                <th class="ps-3">Tgl Kunjungan</th>
                                <th>No Pendaftaran</th>
                                <th>Data Pasien</th>
                                <th>Poliklinik</th>
                                <th>Diagnosa Medis</th>
                                <th>Status / Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($histori)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada rekam jejak histori apapun di sistem.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($histori as $h): ?>
                                    <tr>
                                        <td class="ps-3 text-nowrap">
                                            <?= date('d M Y', strtotime($h['tanggal'])); ?><br>
                                            <small class="text-muted"><?= date('H:i', strtotime($h['tanggal'])); ?> WIB</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $h['no_pendaftaran']; ?></span>
                                            <?php if($h['kd_rekam_medis']): ?>
                                                <br><small class="text-info fw-bold">RM: <?= $h['kd_rekam_medis']; ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= $h['nama_pasien']; ?></strong><br>
                                            <small class="text-muted">NIK: <?= $h['nik']; ?></small>
                                        </td>
                                        <td><span class="badge bg-light text-dark border"><?= $h['nama_poli']; ?></span></td>
                                        <td>
                                            <?php if($h['diagnosa']): ?>
                                                <span class="text-danger fw-bold"><?= $h['diagnosa']; ?></span>
                                                <?php if($h['tindakan_medis']): ?>
                                                    <br><small class="text-muted">Tindakan: <?= $h['tindakan_medis']; ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">Belum ada diagnosa</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($h['status_pendaftaran'] == 'Selesai'): ?>
                                                <span class="badge bg-success mb-1">Selesai</span>
                                            <?php elseif($h['status_pendaftaran'] == 'Batal'): ?>
                                                <span class="badge bg-danger mb-1">Dibatalkan</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark mb-1">Dalam Antrean</span>
                                            <?php endif; ?>
                                            
                                            <!-- Tombol PDF jika ada -->
                                            <?php if($h['pdf_rekam_medis']): ?>
                                                <br>
                                                <a href="<?= base_url('uploads/rekam_medis/' . $h['pdf_rekam_medis']); ?>" target="_blank" class="btn btn-sm btn-outline-info text-nowrap mt-1">
                                                    <i class="bi bi-file-earmark-pdf"></i> Lihat PDF
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-muted small text-center py-3">
                <i class="bi bi-info-circle"></i> Tabel ini merangkum seluruh aktivitas dari tabel pendaftaran yang digabungkan (JOIN) dengan riwayat medis akhir pasien.
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling khusus cetak */
    @media print {
        #sidebar, .navbar, .btn-outline-secondary, .card-footer, .nav-link {
            display: none !important;
        }
        #main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card { border: none !important; box-shadow: none !important; }
        .table-responsive { overflow: visible !important; }
    }
</style>
<?= $this->endSection(); ?>
