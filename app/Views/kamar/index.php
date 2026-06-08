<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Kamar Inap</h2>
            <a href="/kamar/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Kamar</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 offset-md-6">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan Kode Kamar..." name="keyword" value="<?= esc($keyword ?? ''); ?>">
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
                                <th>Kode Kamar</th>
                                <th>Kelas</th>
                                <th>Harga / Malam</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($kamar as $k) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><span class="badge bg-secondary"><?= $k['kd_kmr']; ?></span></td>
                                    <td><?= $k['kelas']; ?></td>
                                    <td>Rp <?= number_format($k['harga_per_malam'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if($k['status'] == 'Tersedia'): ?>
                                            <span class="badge bg-success">Tersedia</span>
                                        <?php elseif($k['status'] == 'Terisi'): ?>
                                            <span class="badge bg-danger">Terisi</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Perbaikan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/kamar/edit/<?= $k['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form action="/kamar/delete/<?= $k['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kamar ini?');"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($kamar)) : ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Data kamar belum tersedia.</td>
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