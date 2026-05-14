<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Proses Pembayaran (Kasir)</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Sistem akan menjumlahkan secara otomatis seluruh tagihan <strong>Layanan/Tindakan</strong> dan <strong>Resep Obat</strong> pasien yang dipilih.
                </div>

                <form action="/pembayaran/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Tagihan/Kwitansi</label>
                            <input type="text" class="form-control bg-light fw-bold" name="no_tagihan" value="<?= $no_tagihan; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal & Waktu</label>
                            <input type="datetime-local" class="form-control" name="tanggal_bayar" value="<?= date('Y-m-d\TH:i'); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="id_pendaftaran" class="form-label fw-bold">Pilih Pasien yang Akan Pulang / Bayar</label>
                        <select class="form-select <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" id="id_pendaftaran" name="id_pendaftaran" autofocus>
                            <option value="">-- Cari Pasien (Status: Selesai Diperiksa) --</option>
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= old('id_pendaftaran') == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pendaftaran'); ?></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="metode_pembayaran">
                                <option value="Tunai">Tunai / Cash</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="Kartu Debit/Kredit">Kartu Debit / Kredit</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Asuransi/BPJS">Asuransi / BPJS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Pembayaran</label>
                            <select class="form-select" name="status_pembayaran">
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas / Cicil</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pembayaran" class="btn btn-secondary">Batal</a>
                        <!-- Kasir klik tombol ini, lalu Controller yang akan menghitung Grand Total-nya -->
                        <button type="submit" class="btn btn-success"><i class="bi bi-calculator"></i> Hitung & Simpan Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>