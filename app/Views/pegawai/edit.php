<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Data Pegawai</h5>
            </div>
            <div class="card-body">
                <form action="/pegawai/update/<?= $pegawai['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $pegawai['nama']; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role / Jabatan</label>
                            <?php $role = (old('role')) ? old('role') : $pegawai['role']; ?>
                            <select class="form-select <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" id="role" name="role">
                                <option value="Dokter" <?= $role == 'Dokter' ? 'selected' : ''; ?>>Dokter</option>
                                <option value="Perawat" <?= $role == 'Perawat' ? 'selected' : ''; ?>>Perawat</option>
                                <option value="Apoteker" <?= $role == 'Apoteker' ? 'selected' : ''; ?>>Apoteker</option>
                                <option value="Kasir" <?= $role == 'Kasir' ? 'selected' : ''; ?>>Kasir</option>
                                <option value="Admin" <?= $role == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('role'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="spesialisasi" class="form-label">Spesialisasi</label>
                            <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" value="<?= (old('spesialisasi')) ? old('spesialisasi') : $pegawai['spesialisasi']; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_poli" class="form-label">Poliklinik</label>
                            <?php $id_poli = (old('id_poli')) ? old('id_poli') : $pegawai['id_poli']; ?>
                            <select class="form-select" id="id_poli" name="id_poli">
                                <option value="">-- Kosong (Bukan Dokter Poli) --</option>
                                <?php foreach($poliklinik as $poli): ?>
                                    <option value="<?= $poli['id']; ?>" <?= $id_poli == $poli['id'] ? 'selected' : ''; ?>>
                                        <?= $poli['nama_poli']; ?> (<?= $poli['ruangan']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_telp" class="form-label">No. Telepon / WA</label>
                            <input type="text" class="form-control" id="nomor_telp" name="nomor_telp" value="<?= (old('nomor_telp')) ? old('nomor_telp') : $pegawai['nomor_telp']; ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= (old('alamat')) ? old('alamat') : $pegawai['alamat']; ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pegawai" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Perbarui Pegawai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>