<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Poliklinik</h2>
            <a href="/poliklinik/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Poliklinik</a>
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
                                <th>Nama Poliklinik</th>
                                <th>Nama / Nomor Ruangan</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($poliklinik as $p) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td class="fw-bold text-primary"><?= $p['nama_poli']; ?></td>
                                    <td><?= $p['ruangan']; ?></td>
                                    <td class="text-center">
                                        <a href="/poliklinik/edit/<?= $p['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form action="/poliklinik/delete/<?= $p['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus poliklinik ini?');"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($poliklinik)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Data poliklinik belum tersedia.</td>
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