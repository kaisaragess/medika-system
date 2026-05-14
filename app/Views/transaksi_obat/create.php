<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Input Pemberian Obat</h5>
            </div>
            <div class="card-body">
                <form action="/transaksi_obat/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-4">
                        <label for="id_pendaftaran" class="form-label">Pilih Pasien</label>
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

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="id_obat" class="form-label">Pilih Obat</label>
                            <select class="form-select <?= ($validation->hasError('id_obat')) ? 'is-invalid' : ''; ?>" id="id_obat" name="id_obat">
                                <option value="">-- Pilih Obat dari Inventori --</option>
                                <?php foreach($obat as $obt): ?>
                                    <!-- Menampilkan stok agar apoteker tahu -->
                                    <option value="<?= $obt['id']; ?>" <?= old('id_obat') == $obt['id'] ? 'selected' : ''; ?>>
                                        <?= $obt['nama_obat']; ?> (Sisa Stok: <?= $obt['qty']; ?>) - Rp <?= number_format($obt['harga'], 0, ',', '.'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('id_obat'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <label for="qty" class="form-label">Jumlah (Qty)</label>
                            <input type="number" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : ''; ?>" id="qty" name="qty" value="<?= old('qty') ? old('qty') : '1'; ?>" min="1">
                            <div class="invalid-feedback"><?= $validation->getError('qty'); ?></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="aturan_pakai" class="form-label">Aturan Pakai</label>
                        <input type="text" class="form-control <?= ($validation->hasError('aturan_pakai')) ? 'is-invalid' : ''; ?>" id="aturan_pakai" name="aturan_pakai" value="<?= old('aturan_pakai'); ?>" placeholder="Misal: 3 x 1 Sesudah Makan">
                        <div class="invalid-feedback"><?= $validation->getError('aturan_pakai'); ?></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/transaksi_obat" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan ke Tagihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>