<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Transaksi Layanan</h5>
            </div>
            <div class="card-body">
                <form action="/transaksi_layanan/update/<?= $transaksi['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="id_pendaftaran" class="form-label">Pasien (Pendaftaran)</label>
                        <?php $id_pendaftaran = (old('id_pendaftaran')) ? old('id_pendaftaran') : $transaksi['id_pendaftaran']; ?>
                        <select class="form-select select2 <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" id="id_pendaftaran" name="id_pendaftaran">
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= $id_pendaftaran == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pendaftaran'); ?></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label for="id_layanan" class="form-label">Jenis Layanan / Tindakan</label>
                            <?php $id_layanan = (old('id_layanan')) ? old('id_layanan') : $transaksi['id_layanan']; ?>
                            <select class="form-select select2 <?= ($validation->hasError('id_layanan')) ? 'is-invalid' : ''; ?>" id="id_layanan" name="id_layanan">
                                <?php foreach($layanan as $lyn): ?>
                                    <option value="<?= $lyn['id']; ?>" <?= $id_layanan == $lyn['id'] ? 'selected' : ''; ?>>
                                        <?= $lyn['nama_layanan']; ?> (Rp <?= number_format($lyn['harga'], 0, ',', '.'); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('id_layanan'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <label for="qty" class="form-label">Jumlah (Qty)</label>
                            <input type="number" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : ''; ?>" id="qty" name="qty" value="<?= (old('qty')) ? old('qty') : $transaksi['qty']; ?>" min="1">
                            <div class="invalid-feedback"><?= $validation->getError('qty'); ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/transaksi_layanan" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
});
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>