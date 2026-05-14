<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-dark">
                <h5 class="card-title mb-0">Ubah Status Kunjungan</h5>
            </div>
            <div class="card-body">
                <form action="/pendaftaran/update/<?= $pendaftaran['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Nomor Pendaftaran</label>
                        <input type="text" class="form-control bg-light" value="<?= $pendaftaran['no_pendaftaran']; ?>" readonly disabled>
                    </div>

                    <div class="mb-3">
                        <label for="id_pasien" class="form-label">Nama Pasien</label>
                        <!-- Menyimpan id_pasien (hidden) agar lolos validasi required controller -->
                        <input type="hidden" name="id_pasien" value="<?= $pendaftaran['id_pasien']; ?>">
                        <select class="form-select bg-light" disabled>
                            <?php foreach($pasien as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= $pendaftaran['id_pasien'] == $psn['id'] ? 'selected' : ''; ?>>
                                    <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold">Update Status Pendaftaran</label>
                        <?php $status = (old('status')) ? old('status') : $pendaftaran['status']; ?>
                        <select class="form-select <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" id="status" name="status">
                            <option value="Antri" <?= $status == 'Antri' ? 'selected' : ''; ?>>Antri</option>
                            <option value="Diperiksa" <?= $status == 'Diperiksa' ? 'selected' : ''; ?>>Diperiksa</option>
                            <option value="Selesai" <?= $status == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="Batal" <?= $status == 'Batal' ? 'selected' : ''; ?>>Batal / Pulang</option>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('status'); ?></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pendaftaran" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-info">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>