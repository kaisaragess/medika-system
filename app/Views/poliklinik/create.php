<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Tambah Spesialisasi Baru</h5>
            </div>
            <div class="card-body">
                <form action="/poliklinik/store" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Unik (3 Digit)</label>
                        <input type="text" class="form-control" name="kode_poli" maxlength="3" placeholder="Contoh: 122" required autofocus>
                        <div class="form-text">Digit 1: Lantai, Digit 2: Poli, Digit 3: Spesialis.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Poliklinik</label>
                        <select class="form-select" name="nama_poli" required>
                            <option value="umum">UMUM</option>
                            <option value="anak">ANAK</option>
                            <option value="gigi">GIGI</option>
                            <option value="kandungan">KANDUNGAN</option>
                            <option value="penyakit dalam">PENYAKIT DALAM</option>
                            <option value="mata">MATA</option>
                            <option value="tht">THT</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Spesialisasi</label>
                        <input type="text" class="form-control" name="daftar_spesialisasi" placeholder="Contoh: Bedah Anak" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Data Master</button>
                        <a href="/poliklinik" class="btn btn-light border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>