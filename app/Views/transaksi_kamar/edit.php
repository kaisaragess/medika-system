
<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="fw-bold mb-0">Edit Data Rawat Inap</h5>
            </div>
            <div class="card-body p-4">
                <form action="/transaksi_kamar/update/<?= $transaksi['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <input type="hidden" name="id_kamar_lama" value="<?= $transaksi['id_kamar']; ?>">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">No. Pendaftaran</label>
                            <input type="text" class="form-control bg-light fw-bold" value="<?= $transaksi['no_pendaftaran']; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status Rawat</label>
                            <select class="form-select" name="status">
                                <option value="Dirawat" <?= ($transaksi['status'] == 'Dirawat') ? 'selected' : ''; ?>>Dirawat</option>
                                <option value="Pulang" <?= ($transaksi['status'] == 'Pulang') ? 'selected' : ''; ?>>Pulang</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ubah Kamar</label>
                        <select class="form-select" name="id_kamar" required>
                            <?php foreach($daftar_kamar as $kamar): ?>
                                <?php if($kamar['status'] == 'Tersedia' || $kamar['id'] == $transaksi['id_kamar']): ?>
                                    <option value="<?= $kamar['id']; ?>" <?= ($kamar['id'] == $transaksi['id_kamar']) ? 'selected' : ''; ?>>
                                        <?= $kamar['kd_kmr']; ?> - Kelas <?= $kamar['kelas']; ?> 
                                        <?= ($kamar['id'] == $transaksi['id_kamar']) ? '(Kamar Saat Ini)' : ''; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="/transaksi_kamar" class="btn btn-light border fw-bold">Batal</a>
                        <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>