<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Tambah Data Pegawai</h5>
            </div>
            <div class="card-body">
                <form action="/pegawai/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap (Sertakan Gelar jika ada)</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>" autofocus>
                        <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role / Jabatan</label>
                            <select class="form-select <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" id="role" name="role">
                                <option value="" disabled <?= old('role') == '' ? 'selected' : ''; ?>>Pilih Role...</option>
                                <option value="Dokter" <?= old('role') == 'Dokter' ? 'selected' : ''; ?>>Dokter</option>
                                <option value="Perawat" <?= old('role') == 'Perawat' ? 'selected' : ''; ?>>Perawat</option>
                                <option value="Apoteker" <?= old('role') == 'Apoteker' ? 'selected' : ''; ?>>Apoteker</option>
                                <option value="Kasir" <?= old('role') == 'Kasir' ? 'selected' : ''; ?>>Kasir</option>
                                <option value="Admin" <?= old('role') == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('role'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="spesialisasi" class="form-label">Spesialisasi <small class="text-muted">(Opsional, khusus dokter)</small></label>
                            <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" value="<?= old('spesialisasi'); ?>" placeholder="Misal: Spesialis Anak">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_poli" class="form-label">Poliklinik <small class="text-muted">(Kosongkan jika bukan dokter poli)</small></label>
                            <select class="form-select" id="id_poli" name="id_poli">
                                <option value="">-- Pilih Poliklinik --</option>
                                <?php foreach($poliklinik as $poli): ?>
                                    <option value="<?= $poli['id']; ?>" <?= old('id_poli') == $poli['id'] ? 'selected' : ''; ?>>
                                        <?= $poli['nama_poli']; ?> (<?= $poli['ruangan']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_telp" class="form-label">No. Telepon / WA</label>
                            <input type="text" class="form-control" id="nomor_telp" name="nomor_telp" value="<?= old('nomor_telp'); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= old('alamat'); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pegawai" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Pegawai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>