<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="fw-bold mb-0">Edit Data Kunjungan Pasien</h5>
            </div>
            <div class="card-body p-4">
                <form action="/pendaftaran/update/<?= $pendaftaran['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Waktu Pendaftaran</label>
                            <input type="text" class="form-control bg-light" value="<?= $pendaftaran['waktu_daftar']; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Status Kunjungan</label>
                            <select class="form-select border-warning" name="status">
                                <option value="Antri" <?= ($pendaftaran['status'] == 'Antri') ? 'selected' : ''; ?>>Sedang Antri</option>
                                <option value="Diperiksa" <?= ($pendaftaran['status'] == 'Diperiksa') ? 'selected' : ''; ?>>Diperiksa Dokter</option>
                                <option value="Selesai" <?= ($pendaftaran['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                <option value="Batal" <?= ($pendaftaran['status'] == 'Batal') ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pasien</label>
                        <select class="form-select" name="id_pasien" required>
                            <?php foreach ($pasien as $p) : ?>
                                <option value="<?= $p['id']; ?>" <?= ($pendaftaran['id_pasien'] == $p['id']) ? 'selected' : ''; ?>>
                                    <?= $p['nik']; ?> - <?= $p['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tujuan Poliklinik</label>
                        <select class="form-select" name="id_poli" required>
                            <?php foreach ($poli as $pl) : ?>
                                <option value="<?= $pl['id']; ?>" <?= ($pendaftaran['id_poli'] == $pl['id']) ? 'selected' : ''; ?>>
                                    [<?= $pl['kode_poli']; ?>] <?= $pl['nama_poli']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Keluhan Awal</label>
                        <textarea class="form-control" name="keluhan_awal" rows="3" required><?= (old('keluhan_awal')) ? old('keluhan_awal') : $pendaftaran['keluhan_awal']; ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pendaftaran" class="btn btn-light border fw-bold">Batal</a>
                        <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>