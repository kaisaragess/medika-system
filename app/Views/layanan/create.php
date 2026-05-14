<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Tambah Data Layanan Medis</h5>
            </div>
            <div class="card-body">
                <form action="/layanan/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kd_layanan" class="form-label">Kode Layanan</label>
                            <input type="text" class="form-control <?= ($validation->hasError('kd_layanan')) ? 'is-invalid' : ''; ?>" id="kd_layanan" name="kd_layanan" value="<?= old('kd_layanan'); ?>" autofocus placeholder="Misal: LYN-001">
                            <div class="invalid-feedback"><?= $validation->getError('kd_layanan'); ?></div>
                        </div>
                        <div class="col-md-8">
                            <label for="nama_layanan" class="form-label">Nama Layanan / Tindakan</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_layanan')) ? 'is-invalid' : ''; ?>" id="nama_layanan" name="nama_layanan" value="<?= old('nama_layanan'); ?>" placeholder="Misal: Konsultasi Dokter Umum">
                            <div class="invalid-feedback"><?= $validation->getError('nama_layanan'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>" id="kategori" name="kategori">
                                <option value="" disabled <?= old('kategori') == '' ? 'selected' : ''; ?>>Pilih Kategori...</option>
                                <option value="Konsultasi" <?= old('kategori') == 'Konsultasi' ? 'selected' : ''; ?>>Konsultasi</option>
                                <option value="Pemeriksaan Lab" <?= old('kategori') == 'Pemeriksaan Lab' ? 'selected' : ''; ?>>Pemeriksaan Lab</option>
                                <option value="Radiologi" <?= old('kategori') == 'Radiologi' ? 'selected' : ''; ?>>Radiologi</option>
                                <option value="Tindakan Medis" <?= old('kategori') == 'Tindakan Medis' ? 'selected' : ''; ?>>Tindakan Medis</option>
                                <option value="Lainnya" <?= old('kategori') == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('kategori'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="harga" class="form-label">Tarif Layanan (Rp)</label>
                            <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" value="<?= old('harga'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('harga'); ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/layanan" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Layanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>