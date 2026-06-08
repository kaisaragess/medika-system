<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Transaksi Apotek (Resep Obat)</h2>
            <a href="/transaksi_obat/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Berikan Obat</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 offset-md-6">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan No Pendaftaran..." name="keyword" value="<?= esc($keyword ?? ''); ?>">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="bi bi-search"></i> Cari</button>
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

        <!-- Pesan Error jika stok tidak cukup (biasanya dikirim dari Controller) -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error'); ?>
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
                                <th>Nama Obat</th>
                                <th>Aturan Pakai</th>
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
                                    <td><?= $t['nama_obat']; ?></td>
                                    <td><?= $t['aturan_pakai']; ?></td>
                                    <td class="text-center"><?= $t['qty']; ?> <?= $t['satuan']; ?></td>
                                    <td class="text-primary fw-bold">Rp <?= number_format($t['tagihan_obat'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <a href="/transaksi_obat/edit/<?= $t['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form action="/transaksi_obat/delete/<?= $t['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan obat ini?');"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($transaksi)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">Belum ada transaksi obat.</td>
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