<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="fw-bold mb-0">Ubah Profil Pegawai</h5>
            </div>
            <div class="card-body p-4">
                <form action="/pegawai/update/<?= $pegawai['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?= $pegawai['nama']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Status Akun</label>
                            <select class="form-select" name="is_active">
                                <option value="1" <?= $pegawai['is_active'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?= $pegawai['is_active'] == 0 ? 'selected' : ''; ?>>Non-Aktif / Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="2" required><?= $pegawai['alamat']; ?></textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Username</label>
                            <input type="text" class="form-control" name="username" value="<?= $pegawai['username']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Password Baru</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak diubah">
                            <small class="text-muted" style="font-size: 0.7rem;">Abaikan kolom ini jika hanya ingin mengubah data profil.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pegawai" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-warning px-4">Perbarui Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>