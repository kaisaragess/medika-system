<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Rekam Medis</h2>
            <a href="/rekam_medis/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Isi Rekam Medis Baru</a>
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
                                <th>Kode RM</th>
                                <th>Tgl Periksa</th>
                                <th>Nama Pasien</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($rekam_medis as $rm) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><span class="badge bg-secondary"><?= $rm['kd_rekam_medis']; ?></span></td>
                                    <td><?= date('d/m/Y', strtotime($rm['tanggal_periksa'])); ?></td>
                                    <td class="fw-bold"><?= $rm['nama_pasien']; ?> </td>
                                    <td class="text-center">
                                        <a href="/rekam_medis/detail/<?= $rm['id']; ?>" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                                        <a href="/rekam_medis/edit/<?= $rm['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form action="/rekam_medis/delete/<?= $rm['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data rekam medis ini?');"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($rekam_medis)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Belum ada data rekam medis.</td>
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