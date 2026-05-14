<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Data Layanan Medis</h5>
            </div>
            <div class="card-body">
                <form action="/layanan/update/<?= $layanan['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kd_layanan" class="form-label">Kode Layanan</label>
                            <input type="text" class="form-control <?= ($validation->hasError('kd_layanan')) ? 'is-invalid' : ''; ?>" id="kd_layanan" name="kd_layanan" value="<?= (old('kd_layanan')) ? old('kd_layanan') : $layanan['kd_layanan']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('kd_layanan'); ?></div>
                        </div>
                        <div class="col-md-8">
                            <label for="nama_layanan" class="form-label">Nama Layanan / Tindakan</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_layanan')) ? 'is-invalid' : ''; ?>" id="nama_layanan" name="nama_layanan" value="<?= (old('nama_layanan')) ? old('nama_layanan') : $layanan['nama_layanan']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_layanan'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kategori" class="form-label">Kategori</label>
                            <?php $kategori = (old('kategori')) ? old('kategori') : $layanan['kategori']; ?>
                            <select class="form-select <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>" id="kategori" name="kategori">
                                <option value="Konsultasi" <?= $kategori == 'Konsultasi' ? 'selected' : ''; ?>>Konsultasi</option>
                                <option value="Pemeriksaan Lab" <?= $kategori == 'Pemeriksaan Lab' ? 'selected' : ''; ?>>Pemeriksaan Lab</option>
                                <option value="Radiologi" <?= $kategori == 'Radiologi' ? 'selected' : ''; ?>>Radiologi</option>
                                <option value="Tindakan Medis" <?= $kategori == 'Tindakan Medis' ? 'selected' : ''; ?>>Tindakan Medis</option>
                                <option value="Lainnya" <?= $kategori == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('kategori'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="harga" class="form-label">Tarif Layanan (Rp)</label>
                            <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" value="<?= (old('harga')) ? old('harga') : $layanan['harga']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('harga'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Status Layanan</label>
                            <?php $is_active = (old('is_active') !== null) ? old('is_active') : $layanan['is_active']; ?>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" <?= $is_active == 1 ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?= $is_active == 0 ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/layanan" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Perbarui Layanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>