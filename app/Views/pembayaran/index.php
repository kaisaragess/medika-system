<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Pembayaran Kasir</h2>
            <a href="/pembayaran/create" class="btn btn-primary"><i class="bi bi-cash-coin"></i> Proses Pembayaran Baru</a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="" method="get" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold">Mulai Tanggal</label>
                        <input type="date" class="form-control" name="start_date" value="<?= esc($start_date ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="end_date" value="<?= esc($end_date ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Pencarian</label>
                        <input type="text" class="form-control" placeholder="Cari No. Tagihan..." name="keyword" value="<?= esc($keyword ?? ''); ?>">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1" type="submit"><i class="bi bi-filter"></i> Filter</button>
                        <a href="/pembayaran/cetak_laporan?start_date=<?= esc($start_date ?? ''); ?>&end_date=<?= esc($end_date ?? ''); ?>&keyword=<?= esc($keyword ?? ''); ?>" target="_blank" class="btn btn-secondary flex-grow-1" title="Cetak Laporan Hasil Filter"><i class="bi bi-printer"></i> Cetak</a>
                    </div>
                </form>
            </div>
        </div>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No. Tagihan</th>
                                <th>Tgl Bayar</th>
                                <th>Pasien (No. Daftar)</th>
                                <th>Total Tagihan</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th class="text-center">Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pembayaran as $p) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><span class="badge bg-dark"><?= $p['no_tagihan']; ?></span></td>
                                    <td><?= date('d/m/Y H:i', strtotime($p['tanggal_bayar'])); ?></td>
                                    <td class="fw-bold"><?= $p['nama_pasien']; ?><br><small class="text-muted"><?= $p['no_pendaftaran']; ?></small></td>
                                    <td class="text-danger fw-bold">Rp <?= number_format($p['total_bayar'], 0, ',', '.'); ?></td>
                                    <td><?= $p['metode_pembayaran']; ?></td>
                                    <td>
                                        <?php if($p['status_pembayaran'] == 'Lunas'): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Lunas</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Belum Lunas</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/pembayaran/cetak/<?= $p['id']; ?>" class="btn btn-sm btn-info text-white" target="_blank" title="Cetak Struk/Kwitansi"><i class="bi bi-printer"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($pembayaran)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">Belum ada data pembayaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>