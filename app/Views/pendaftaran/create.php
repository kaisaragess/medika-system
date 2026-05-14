<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Pendaftaran Pasien Baru</h5>
            </div>
            <div class="card-body">
                <form action="/pendaftaran/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="no_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                        <!-- Input readonly karena digenerate otomatis dari Controller -->
                        <input type="text" class="form-control fw-bold text-primary bg-light" id="no_pendaftaran" name="no_pendaftaran" value="<?= $no_pendaftaran; ?>" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="id_pasien" class="form-label">Pilih Pasien</label>
                        <select class="form-select <?= ($validation->hasError('id_pasien')) ? 'is-invalid' : ''; ?>" id="id_pasien" name="id_pasien" autofocus>
                            <option value="">-- Cari Nama Pasien --</option>
                            <?php foreach($pasien as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= old('id_pasien') == $psn['id'] ? 'selected' : ''; ?>>
                                    <?= $psn['nik']; ?> - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pasien'); ?></div>
                        <div class="form-text mt-2">
                            Pasien belum terdaftar? <a href="/pasien/create">Klik di sini untuk daftar pasien baru</a>.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pendaftaran" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Daftarkan Antrean</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>