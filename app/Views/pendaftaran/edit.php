<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="fw-bold mb-0">Edit Status Kunjungan Pasien</h5>
            </div>
            <div class="card-body p-4">
                <form action="/pendaftaran/update/<?= $pendaftaran['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-4">
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-muted small">No. Pendaftaran</label>
                            <input type="text" class="form-control bg-light fw-bold text-primary" value="<?= $pendaftaran['no_pendaftaran']; ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small">Tanggal & Waktu</label>
                            <input type="text" class="form-control bg-light" value="<?= $pendaftaran['tgl_daftar']; ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Ubah Status</label>
                            <select class="form-select border-warning fw-bold" name="status">
                                <option value="Antri" <?= ($pendaftaran['status'] == 'Antri') ? 'selected' : ''; ?>>Antri</option>
                                <option value="Diperiksa" <?= ($pendaftaran['status'] == 'Diperiksa') ? 'selected' : ''; ?>>Diperiksa</option>
                                <option value="Selesai" <?= ($pendaftaran['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                <option value="Batal" <?= ($pendaftaran['status'] == 'Batal') ? 'selected' : ''; ?>>Batal</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="id_pasien" value="<?= $pendaftaran['id_pasien']; ?>">
                    <input type="hidden" name="id_poli" value="<?= $pendaftaran['id_poli']; ?>">

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