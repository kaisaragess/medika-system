<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Tambah Data Kamar</h5>
            </div>
            <div class="card-body">
                <form action="/kamar/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="kd_kmr" class="form-label">Kode Kamar</label>
                        <input type="text"
                            class="form-control <?= ($validation->hasError('kd_kmr')) ? 'is-invalid' : ''; ?>"
                            id="kd_kmr" name="kd_kmr" value="<?= old('kd_kmr'); ?>" autofocus
                            placeholder="Misal: VIP-01 atau 111">
                        <div class="invalid-feedback"><?= $validation->getError('kd_kmr'); ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas Kamar</label>
                        <select class="form-select <?= ($validation->hasError('kelas')) ? 'is-invalid' : ''; ?>"
                            id="kelas" name="kelas">
                            <option value="" disabled <?= old('kelas') == '' ? 'selected' : ''; ?>>Pilih Kelas...</option>
                            <option value="VVIP" <?= old('kelas') == 'VVIP' ? 'selected' : ''; ?>>VVIP</option>
                            <option value="VIP" <?= old('kelas') == 'VIP' ? 'selected' : ''; ?>>VIP</option>
                            <option value="Kelas 1" <?= old('kelas') == 'Kelas 1' ? 'selected' : ''; ?>>Kelas 1</option>
                            <option value="Kelas 2" <?= old('kelas') == 'Kelas 2' ? 'selected' : ''; ?>>Kelas 2</option>
                            <option value="Kelas 3" <?= old('kelas') == 'Kelas 3' ? 'selected' : ''; ?>>Kelas 3</option>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('kelas'); ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="harga_per_malam" class="form-label">Harga per Malam (Rp)</label>
                        <input type="number"
                            class="form-control <?= ($validation->hasError('harga_per_malam')) ? 'is-invalid' : ''; ?>"
                            id="harga_per_malam" name="harga_per_malam" value="<?= old('harga_per_malam'); ?>">
                        <div class="invalid-feedback"><?= $validation->getError('harga_per_malam'); ?></div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status Awal</label>
                        <select class="form-select <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>"
                            id="status" name="status">
                            <option value="Tersedia" <?= old('status') == 'Tersedia' ? 'selected' : ''; ?>>Tersedia
                            </option>
                            <option value="Terisi" <?= old('status') == 'Terisi' ? 'selected' : ''; ?>>Terisi</option>
                            <option value="Perbaikan" <?= old('status') == 'Perbaikan' ? 'selected' : ''; ?>>Perbaikan
                            </option>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('status'); ?></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/kamar" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Kamar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>