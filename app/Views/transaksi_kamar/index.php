<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Manajemen Rawat Inap</h4>
                <p class="text-muted small">Kelola data check-in dan check-out kamar pasien.</p>
            </div>
            <a href="/transaksi_kamar/create" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle"></i> Check-in Pasien</a>
        </div>

        <?php if(session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" width="5%">No</th>
                                <th>No. Inap</th>
                                <th>Nama Pasien</th>
                                <th>Kamar & Kelas</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Keluar</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($transaksi as $t) : ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $i++; ?></td>
                                    <td><span class="badge bg-secondary"><?= $t['no_pendaftaran']; ?></span></td>
                                    <td class="fw-bold text-primary"><?= $t['nama_pasien']; ?></td>
                                    <td><span class="fw-bold"><?= $t['kd_kmr']; ?></span><br><small class="text-muted">Kelas <?= $t['kelas']; ?></small></td>
                                    <td><?= date('d M Y H:i', strtotime($t['tgl_masuk'])); ?></td>
                                    <td><?= ($t['tgl_keluar']) ? date('d M Y H:i', strtotime($t['tgl_keluar'])) : '-'; ?></td>
                                    <td class="fw-bold">Rp <?= number_format($t['total_biaya'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if($t['status'] == 'Dirawat'): ?>
                                            <span class="badge bg-warning text-dark px-3 rounded-pill">Dirawat</span>
                                        <?php else: ?>
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">Pulang</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <?php if($t['status'] == 'Dirawat'): ?>
                                            <form action="/transaksi_kamar/checkout/<?= $t['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-success fw-bold" onclick="return confirm('Proses checkout pasien ini? Total tagihan akan dihitung otomatis.')"><i class="bi bi-box-arrow-right"></i> Checkout</button>
                                            </form>
                                        <?php endif; ?>
                                        <a href="/transaksi_kamar/edit/<?= $t['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>