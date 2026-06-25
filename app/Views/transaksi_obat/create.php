<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Input Pemberian Obat</h5>
            </div>
            <div class="card-body">
                <form action="/transaksi_obat/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-4">
                        <label for="id_pendaftaran" class="form-label">Pilih Pasien</label>
                        <select class="form-select <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" id="id_pendaftaran" name="id_pendaftaran" autofocus>
                            <option value="">-- Cari Nama Pasien --</option>
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= old('id_pendaftaran') == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama_pasien']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pendaftaran'); ?></div>
                    </div>

                    <div id="obat-container">
                        <div class="row mb-3 obat-row border rounded p-3 bg-light position-relative mx-0">
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Pilih Obat</label>
                                <select class="form-select select-obat <?= ($validation->hasError('id_obat.*')) ? 'is-invalid' : ''; ?>" name="id_obat[]" required>
                                    <option value="">-- Pilih Obat dari Inventori --</option>
                                    <?php foreach($daftar_obat as $obt): ?>
                                        <option value="<?= $obt['id']; ?>">
                                            <?= $obt['nama_obat']; ?> (Sisa Stok: <?= $obt['qty']; ?>) - Rp <?= number_format($obt['harga'], 0, ',', '.'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Jumlah (Qty)</label>
                                <input type="number" class="form-control <?= ($validation->hasError('qty.*')) ? 'is-invalid' : ''; ?>" name="qty[]" value="1" min="1" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Aturan Pakai</label>
                                <input type="text" class="form-control <?= ($validation->hasError('aturan_pakai.*')) ? 'is-invalid' : ''; ?>" name="aturan_pakai[]" placeholder="Misal: 3 x 1 Sesudah Makan" required>
                            </div>
                            <div class="col-md-1 mb-2 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-danger btn-remove-obat" style="display:none;" title="Hapus Obat Ini"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-tambah-obat"><i class="bi bi-plus-circle"></i> Tambah Obat Lain</button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/transaksi_obat" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan ke Tagihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
    initSelect2('.select-obat');

    const container = document.getElementById('obat-container');
    const btnTambah = document.getElementById('btn-tambah-obat');

    btnTambah.addEventListener('click', function() {
        // Destroy select2 on the original select to clone it properly
        $('.select-obat').select2('destroy');

        const row = container.querySelector('.obat-row').cloneNode(true);
        // Reset nilai input
        row.querySelector('select').value = '';
        row.querySelector('input[type="number"]').value = '1';
        row.querySelector('input[type="text"]').value = '';
        
        // Hilangkan validasi error yang ikut ter-clone jika ada
        row.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Tampilkan tombol hapus
        row.querySelector('.btn-remove-obat').style.display = 'block';
        
        container.appendChild(row);

        // Re-initialize all select-obat
        initSelect2('.select-obat');
    });

    container.addEventListener('click', function(e) {
        const btnRemove = e.target.closest('.btn-remove-obat');
        if(btnRemove) {
            // Cek jika baris lebih dari 1
            if(container.querySelectorAll('.obat-row').length > 1) {
                // Destroy select2 on the row to be removed to prevent memory leaks (optional but good practice)
                const selectToRemove = btnRemove.closest('.obat-row').querySelector('.select-obat');
                if ($(selectToRemove).hasClass("select2-hidden-accessible")) {
                    $(selectToRemove).select2('destroy');
                }
                btnRemove.closest('.obat-row').remove();
            }
        }
    });
});
</script>
<?= $this->endSection(); ?>