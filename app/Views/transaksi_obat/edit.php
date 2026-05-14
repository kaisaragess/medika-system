<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Data Resep Obat</h5>
            </div>
            <div class="card-body">
                <form action="/transaksi_obat/update/<?= $transaksi['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <!-- Input hidden untuk menyimpan Qty lama, berguna jika Controller butuh mengembalikan stok -->
                    <input type="hidden" name="qty_lama" value="<?= $transaksi['qty']; ?>">
                    <input type="hidden" name="id_obat_lama" value="<?= $transaksi['id_obat']; ?>">

                    <div class="mb-4">
                        <label class="form-label">Pasien</label>
                        <?php $id_pendaftaran = (old('id_pendaftaran')) ? old('id_pendaftaran') : $transaksi['id_pendaftaran']; ?>
                        <select class="form-select <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" name="id_pendaftaran">
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= $id_pendaftaran == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Pilih Obat</label>
                            <?php $id_obat = (old('id_obat')) ? old('id_obat') : $transaksi['id_obat']; ?>
                            <select class="form-select <?= ($validation->hasError('id_obat')) ? 'is-invalid' : ''; ?>" name="id_obat">
                                <?php foreach($obat as $obt): ?>
                                    <option value="<?= $obt['id']; ?>" <?= $id_obat == $obt['id'] ? 'selected' : ''; ?>>
                                        <?= $obt['nama_obat']; ?> - Rp <?= number_format($obt['harga'], 0, ',', '.'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah (Qty)</label>
                            <input type="number" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : ''; ?>" name="qty" value="<?= (old('qty')) ? old('qty') : $transaksi['qty']; ?>" min="1">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Aturan Pakai</label>
                        <input type="text" class="form-control <?= ($validation->hasError('aturan_pakai')) ? 'is-invalid' : ''; ?>" name="aturan_pakai" value="<?= (old('aturan_pakai')) ? old('aturan_pakai') : $transaksi['aturan_pakai']; ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/transaksi_obat" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Perbarui Resep</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>