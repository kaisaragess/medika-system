<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Data Master Poliklinik & Spesialisasi</h4>
    <a href="/poliklinik/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Spesialisasi</a>
</div>

<div class="row mb-3">
    <div class="col-md-6 offset-md-6">
        <form action="" method="get">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari berdasarkan Kode Poliklinik..." name="keyword" value="<?= esc($keyword ?? ''); ?>">
                <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>
    </div>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success border-0 shadow-sm"><?= session()->getFlashdata('pesan'); ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3" width="5%">No</th>
                        <th width="10%">Kode</th>
                        <th width="10%">Lantai</th>
                        <th>Kategori Poli</th>
                        <th>Nama Spesialisasi</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($poliklinik as $p) : ?>
                        <tr>
                            <td class="ps-3"><?= $i++; ?></td>
                            <td><span class="badge bg-primary  fw-bold"><?= $p['kode_poli']; ?></span></td>
                            <td>
                                <span class="badge bg-secondary ">Lantai <?= substr($p['kode_poli'], 0, 1); ?></span>
                            </td>
                            <td class="text-uppercase fw-bold text-primary"><?= $p['nama_poli']; ?></td>
                            <td><?= $p['daftar_spesialisasi']; ?></td>
                            <td class="text-center">
                                <a href="/poliklinik/edit/<?= $p['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="/poliklinik/delete/<?= $p['id']; ?>" method="get" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data spesialisasi ini?');"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>