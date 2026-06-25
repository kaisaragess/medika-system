<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Input Layanan Medis Pasien</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle"></i> <strong>Sistem Otomatis:</strong> Total harga tagihan akan dihitung secara otomatis oleh sistem berdasarkan harga layanan dikali Qty.
                </div>

                <form action="/transaksi_layanan/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="id_pendaftaran" class="form-label">Pilih Pasien (Pendaftaran)</label>
                        <select class="form-select <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" id="id_pendaftaran" name="id_pendaftaran" autofocus>
                            <option value="">-- Cari Nama Pasien --</option>
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= old('id_pendaftaran') == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pendaftaran'); ?></div>
                    </div>

                    <div id="layanan-container">
                        <div class="row mb-3 layanan-row border rounded p-3 bg-light position-relative mx-0">
                            <div class="col-md-7 mb-2">
                                <label class="form-label">Jenis Layanan / Tindakan</label>
                                <select class="form-select select-layanan <?= ($validation->hasError('id_layanan.*')) ? 'is-invalid' : ''; ?>" name="id_layanan[]" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    <?php foreach($layanan as $lyn): ?>
                                        <option value="<?= $lyn['id']; ?>">
                                            <?= $lyn['nama_layanan']; ?> (Rp <?= number_format($lyn['harga'], 0, ',', '.'); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Jumlah (Qty)</label>
                                <input type="number" class="form-control <?= ($validation->hasError('qty.*')) ? 'is-invalid' : ''; ?>" name="qty[]" value="1" min="1" required>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 btn-remove-layanan" style="width: 32px; display: none;" title="Hapus Layanan"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button type="button" class="btn btn-outline-success btn-sm" id="btn-tambah-layanan">
                            <i class="bi bi-plus-circle"></i> Tambah Layanan Lain
                        </button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/transaksi_layanan" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambahkan ke Tagihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts'); ?>
<script>
function initSelect2(element) {
    $(element).select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 on the first load
    initSelect2('#id_pendaftaran');
    initSelect2('.select-layanan');

    const container = document.getElementById('layanan-container');
    const btnTambah = document.getElementById('btn-tambah-layanan');

    btnTambah.addEventListener('click', function() {
        // Destroy select2 on the original select to clone it properly
        $('.select-layanan').select2('destroy');

        const row = container.querySelector('.layanan-row').cloneNode(true);
        // Reset nilai input
        row.querySelector('select').value = '';
        row.querySelector('input[type="number"]').value = '1';
        
        // Hilangkan validasi error yang ikut ter-clone jika ada
        row.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Tampilkan tombol hapus
        row.querySelector('.btn-remove-layanan').style.display = 'block';
        
        container.appendChild(row);

        // Re-initialize all select-layanan
        initSelect2('.select-layanan');
    });

    container.addEventListener('click', function(e) {
        const btnRemove = e.target.closest('.btn-remove-layanan');
        if(btnRemove) {
            // Cek jika baris lebih dari 1
            if(container.querySelectorAll('.layanan-row').length > 1) {
                const selectToRemove = btnRemove.closest('.layanan-row').querySelector('.select-layanan');
                if ($(selectToRemove).hasClass("select2-hidden-accessible")) {
                    $(selectToRemove).select2('destroy');
                }
                btnRemove.closest('.layanan-row').remove();
            }
        }
    });
});
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>