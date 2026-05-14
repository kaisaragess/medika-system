<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Data Obat</h5>
            </div>
            <div class="card-body">
                <form action="/obat/update/<?= $obat['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kd_obat" class="form-label">Kode Obat</label>
                            <input type="text" class="form-control <?= ($validation->hasError('kd_obat')) ? 'is-invalid' : ''; ?>" id="kd_obat" name="kd_obat" value="<?= (old('kd_obat')) ? old('kd_obat') : $obat['kd_obat']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('kd_obat'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_obat')) ? 'is-invalid' : ''; ?>" id="nama_obat" name="nama_obat" value="<?= (old('nama_obat')) ? old('nama_obat') : $obat['nama_obat']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_obat'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select class="form-select" id="jenis" name="jenis">
                                <?php $jenis = (old('jenis')) ? old('jenis') : $obat['jenis']; ?>
                                <option value="Tablet" <?= $jenis == 'Tablet' ? 'selected' : ''; ?>>Tablet</option>
                                <option value="Sirup" <?= $jenis == 'Sirup' ? 'selected' : ''; ?>>Sirup</option>
                                <option value="Kapsul" <?= $jenis == 'Kapsul' ? 'selected' : ''; ?>>Kapsul</option>
                                <option value="Salep" <?= $jenis == 'Salep' ? 'selected' : ''; ?>>Salep</option>
                                <option value="Injeksi" <?= $jenis == 'Injeksi' ? 'selected' : ''; ?>>Injeksi</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="dosis" class="form-label">Dosis</label>
                            <input type="text" class="form-control" id="dosis" name="dosis" value="<?= (old('dosis')) ? old('dosis') : $obat['dosis']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" value="<?= (old('satuan')) ? old('satuan') : $obat['satuan']; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" value="<?= (old('harga')) ? old('harga') : $obat['harga']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('harga'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <label for="qty" class="form-label">Stok Obat (Qty)</label>
                            <input type="number" class="form-control" id="qty" name="qty" value="<?= (old('qty')) ? old('qty') : $obat['qty']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="expired" class="form-label">Tanggal Expired</label>
                            <input type="date" class="form-control" id="expired" name="expired" value="<?= (old('expired')) ? old('expired') : $obat['expired']; ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/obat" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Perbarui Obat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>