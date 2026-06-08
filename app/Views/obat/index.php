<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Obat & Inventori</h2>
            <a href="/obat/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Obat</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 offset-md-6">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan Kode Obat..." name="keyword" value="<?= esc($keyword ?? ''); ?>">
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

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Obat</th>
                                <th>Nama Obat</th>
                                <th>Jenis</th>
                                <th>Stok (Qty)</th>
                                <th>Harga</th>
                                <th>Expired Date</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($obat as $o) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><span class="badge bg-secondary"><?= $o['kd_obat']; ?></span></td>
                                    <td><?= $o['nama_obat']; ?></td>
                                    <td><?= $o['jenis']; ?></td>
                                    <td>
                                        <!-- Indikator warna jika stok menipis -->
                                        <?php if($o['qty'] < 10): ?>
                                            <span class="text-danger fw-bold"><?= $o['qty']; ?> <?= $o['satuan']; ?></span>
                                        <?php else: ?>
                                            <?= $o['qty']; ?> <?= $o['satuan']; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>Rp <?= number_format($o['harga'], 0, ',', '.'); ?></td>
                                    <td><?= $o['expired']; ?></td>
                                    <td class="text-center">
                                        <a href="/obat/edit/<?= $o['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        
                                        <form action="/obat/delete/<?= $o['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus obat ini dari inventori?');"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($obat)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">Inventori obat masih kosong.</td>
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