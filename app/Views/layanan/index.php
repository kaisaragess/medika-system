<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Layanan Medis</h2>
            <a href="/layanan/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Layanan</a>
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
                                <th width="5%">No</th>
                                <th>Kode Layanan</th>
                                <th>Nama Layanan/Tindakan</th>
                                <th>Kategori</th>
                                <th>Tarif (Rp)</th>
                                <th>Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($layanan as $l) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><span class="badge bg-secondary"><?= $l['kd_layanan']; ?></span></td>
                                    <td class="fw-bold"><?= $l['nama_layanan']; ?></td>
                                    <td><?= $l['kategori']; ?></td>
                                    <td>Rp <?= number_format($l['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if($l['is_active'] == 1): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/layanan/edit/<?= $l['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form action="/layanan/delete/<?= $l['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus layanan medis ini?');"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($layanan)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Data layanan medis belum tersedia.</td>
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