<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Data Poliklinik</h5>
            </div>
            <div class="card-body">
                <form action="/poliklinik/update/<?= $poliklinik['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="nama_poli" class="form-label">Nama Poliklinik</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama_poli')) ? 'is-invalid' : ''; ?>" id="nama_poli" name="nama_poli" value="<?= (old('nama_poli')) ? old('nama_poli') : $poliklinik['nama_poli']; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('nama_poli'); ?></div>
                    </div>

                    <div class="mb-4">
                        <label for="ruangan" class="form-label">Nama / Nomor Ruangan</label>
                        <input type="text" class="form-control <?= ($validation->hasError('ruangan')) ? 'is-invalid' : ''; ?>" id="ruangan" name="ruangan" value="<?= (old('ruangan')) ? old('ruangan') : $poliklinik['ruangan']; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('ruangan'); ?></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/poliklinik" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>