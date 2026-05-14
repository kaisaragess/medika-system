<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Input Layanan Medis Pasien</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle"></i> <strong>Sistem Otomatis:</strong> Total harga tagihan akan dihitung secara otomatis oleh sistem berdasarkan harga layanan dikali Qty.
                </div>

                <form action="/transaksi_layanan/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="id_pendaftaran" class="form-label">Pilih Pasien (Pendaftaran)</label>
                        <select class="form-select <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" id="id_pendaftaran" name="id_pendaftaran" autofocus>
                            <option value="">-- Cari Nama Pasien --</option>
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= old('id_pendaftaran') == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pendaftaran'); ?></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label for="id_layanan" class="form-label">Jenis Layanan / Tindakan</label>
                            <select class="form-select <?= ($validation->hasError('id_layanan')) ? 'is-invalid' : ''; ?>" id="id_layanan" name="id_layanan">
                                <option value="">-- Pilih Layanan --</option>
                                <?php foreach($layanan as $lyn): ?>
                                    <option value="<?= $lyn['id']; ?>" <?= old('id_layanan') == $lyn['id'] ? 'selected' : ''; ?>>
                                        <?= $lyn['nama_layanan']; ?> (Rp <?= number_format($lyn['harga'], 0, ',', '.'); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('id_layanan'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <label for="qty" class="form-label">Jumlah (Qty)</label>
                            <input type="number" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : ''; ?>" id="qty" name="qty" value="<?= old('qty') ? old('qty') : '1'; ?>" min="1">
                            <div class="invalid-feedback"><?= $validation->getError('qty'); ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/transaksi_layanan" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambahkan ke Tagihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>