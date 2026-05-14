<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Tambah Data Poliklinik</h5>
            </div>
            <div class="card-body">
                <form action="/poliklinik/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="nama_poli" class="form-label">Nama Poliklinik</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama_poli')) ? 'is-invalid' : ''; ?>" id="nama_poli" name="nama_poli" value="<?= old('nama_poli'); ?>" autofocus placeholder="Misal: Poli Umum">
                        <div class="invalid-feedback"><?= $validation->getError('nama_poli'); ?></div>
                    </div>

                    <div class="mb-4">
                        <label for="ruangan" class="form-label">Nama / Nomor Ruangan</label>
                        <input type="text" class="form-control <?= ($validation->hasError('ruangan')) ? 'is-invalid' : ''; ?>" id="ruangan" name="ruangan" value="<?= old('ruangan'); ?>" placeholder="Misal: Ruang 101 atau Gedung A">
                        <div class="invalid-feedback"><?= $validation->getError('ruangan'); ?></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/poliklinik" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>