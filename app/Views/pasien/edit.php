<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Data Pasien</h5>
            </div>
            <div class="card-body">
                <!-- Arahkan form ke method update beserta ID pasien -->
                <form action="/pasien/update/<?= $pasien['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" id="nik" name="nik" value="<?= (old('nik')) ? old('nik') : $pasien['nik']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nik'); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $pasien['nama']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="L" <?= ($pasien['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?= ($pasien['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= (old('tgl_lahir')) ? old('tgl_lahir') : $pasien['tgl_lahir']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Aktif" <?= (old('status') ? old('status') : ($pasien['status'] ?? 'Aktif')) == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Nonaktif" <?= (old('status') ? old('status') : ($pasien['status'] ?? 'Aktif')) == 'Nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. Telepon / WA</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= (old('no_telp')) ? old('no_telp') : $pasien['no_telp']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= (old('alamat')) ? old('alamat') : $pasien['alamat']; ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pasien" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>