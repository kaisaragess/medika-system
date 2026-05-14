<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Transaksi Layanan Medis</h2>
            <a href="/transaksi_layanan/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Input Layanan Pasien</a>
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
                                <th>No Pendaftaran</th>
                                <th>Nama Pasien</th>
                                <th>Layanan / Tindakan</th>
                                <th class="text-center">Qty</th>
                                <th>Total Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($transaksi as $t) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><span class="badge bg-secondary"><?= $t['no_pendaftaran']; ?></span></td>
                                    <td class="fw-bold"><?= $t['nama_pasien']; ?></td>
                                    <td><?= $t['nama_layanan']; ?></td>
                                    <td class="text-center"><?= $t['qty']; ?></td>
                                    <td class="text-primary fw-bold">Rp <?= number_format($t['total_harga'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <a href="/transaksi_layanan/edit/<?= $t['id']; ?>" class="btn btn-sm btn-warning" title="Edit Qty/Layanan"><i class="bi bi-pencil"></i></a>
                                        <form action="/transaksi_layanan/delete/<?= $t['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan/menghapus layanan ini dari tagihan?');" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($transaksi)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Belum ada transaksi layanan medis.</td>
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