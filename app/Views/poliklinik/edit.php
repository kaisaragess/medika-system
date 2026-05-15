<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Ubah Data Spesialisasi</h5>
            </div>
            <div class="card-body">
                <form action="/poliklinik/update/<?= $poliklinik['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Unik</label>
                        <input type="text" class="form-control" name="kode_poli" value="<?= $poliklinik['kode_poli']; ?>" maxlength="3" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Poliklinik</label>
                        <select class="form-select" name="nama_poli" required>
                            <?php $options = ['umum', 'anak', 'gigi', 'kandungan', 'penyakit dalam', 'mata', 'tht']; ?>
                            <?php foreach($options as $opt): ?>
                                <option value="<?= $opt; ?>" <?= ($poliklinik['nama_poli'] == $opt) ? 'selected' : ''; ?>><?= strtoupper($opt); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Spesialisasi</label>
                        <input type="text" class="form-control" name="daftar_spesialisasi" value="<?= $poliklinik['daftar_spesialisasi']; ?>" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning fw-bold">Perbarui Data</button>
                        <a href="/poliklinik" class="btn btn-light border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>