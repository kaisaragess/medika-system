<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="fw-bold mb-0">Check-in Kamar Rawat Inap</h5>
            </div>
            <div class="card-body p-4">
                <form action="/transaksi_kamar/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Pasien</label>
                        <select class="form-select" name="id_pendaftaran" required>
                            <option value="">-- Pilih Pasien dari Antrean --</option>
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>">[<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama_pasien']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Kamar (Yang Tersedia)</label>
                        <select class="form-select" name="id_kamar" required>
                            <option value="">-- Pilih Kamar --</option>
                            <?php foreach($daftar_kamar as $kamar): ?>
                                <option value="<?= $kamar['id']; ?>">
                                    <?= $kamar['kd_kmr']; ?> - Kelas <?= $kamar['kelas']; ?> (Rp <?= number_format($kamar['harga_per_malam'], 0, ',', '.'); ?>/malam)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Tanggal Masuk</label>
                        <input type="date" class="form-control" name="tgl_masuk" value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="/transaksi_kamar" class="btn btn-light border fw-bold">Batal</a>
                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save"></i> Proses Check-in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>