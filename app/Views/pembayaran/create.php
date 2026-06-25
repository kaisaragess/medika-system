<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Proses Pembayaran (Kasir)</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Sistem akan menjumlahkan secara otomatis seluruh tagihan <strong>Layanan/Tindakan</strong> dan <strong>Resep Obat</strong> pasien yang dipilih.
                </div>

                <form action="/pembayaran/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Tagihan/Kwitansi</label>
                            <input type="text" class="form-control bg-light fw-bold" name="no_tagihan" value="<?= $no_tagihan; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal & Waktu</label>
                            <input type="datetime-local" class="form-control" name="tanggal_bayar" value="<?= date('Y-m-d\TH:i'); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="id_pendaftaran" class="form-label fw-bold">Pilih Pasien yang Akan Pulang / Bayar</label>
                        <select class="form-select <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" id="id_pendaftaran" name="id_pendaftaran" autofocus>
                            <option value="">-- Cari Pasien (Status: Selesai Diperiksa) --</option>
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= old('id_pendaftaran') == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pendaftaran'); ?></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Rincian Biaya</label>
                        <div id="rincian_biaya" class="border rounded p-3 bg-light">
                            <div class="alert alert-secondary mb-0">Pilih pasien untuk melihat rincian biaya.</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="metode_pembayaran">
                                <option value="Tunai">Tunai / Cash</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="Kartu Debit/Kredit">Kartu Debit / Kredit</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Asuransi/BPJS">Asuransi / BPJS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Pembayaran</label>
                            <select class="form-select" name="status_pembayaran">
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas / Cicil</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pembayaran" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-calculator"></i> Hitung & Simpan Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pendaftaranSelect = document.getElementById('id_pendaftaran');
    const rincianContainer = document.getElementById('rincian_biaya');
    
    // trigger change if already selected
    if(pendaftaranSelect.value) {
        pendaftaranSelect.dispatchEvent(new Event('change'));
    }

    pendaftaranSelect.addEventListener('change', function() {
        const id = this.value;
        if (!id) {
            rincianContainer.innerHTML = '<div class="alert alert-secondary mb-0">Pilih pasien untuk melihat rincian biaya.</div>';
            return;
        }
        
        rincianContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary spinner-border-sm" role="status"></div><p class="mt-2 mb-0">Memuat rincian...</p></div>';
        
        fetch('/pembayaran/get_biaya/' + id)
            .then(response => response.json())
            .then(data => {
                let html = '<div class="table-responsive"><table class="table table-bordered table-sm mb-0 bg-white">';
                html += '<thead class="table-light"><tr><th>Item</th><th>Qty/Hari</th><th>Biaya</th><th>Subtotal</th></tr></thead><tbody>';
                
                // Layanan
                if (data.trans_layanan.length > 0) {
                    html += '<tr><td colspan="4" class="fw-bold bg-light">Tindakan / Layanan</td></tr>';
                    data.trans_layanan.forEach(item => {
                        html += `<tr>
                            <td>${item.nama_layanan}</td>
                            <td>${item.qty}</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(item.harga_satuan)}</td>
                            <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(item.total_harga)}</td>
                        </tr>`;
                    });
                }
                
                // Obat
                if (data.trans_obat.length > 0) {
                    html += '<tr><td colspan="4" class="fw-bold bg-light">Resep Obat</td></tr>';
                    data.trans_obat.forEach(item => {
                        const hargaSatuan = item.tagihan_obat / item.qty;
                        html += `<tr>
                            <td>${item.nama_obat}</td>
                            <td>${item.qty}</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(hargaSatuan)}</td>
                            <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(item.tagihan_obat)}</td>
                        </tr>`;
                    });
                }
                
                // Kamar
                if (data.trans_kamar.length > 0) {
                    html += '<tr><td colspan="4" class="fw-bold bg-light">Rawat Inap</td></tr>';
                    data.trans_kamar.forEach(item => {
                        const biayaPerHari = item.total_biaya / item.hari;
                        html += `<tr>
                            <td>Kamar ${item.kd_kmr} (${item.kelas})</td>
                            <td>${item.hari} Hari</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(biayaPerHari)}</td>
                            <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(item.total_biaya)}</td>
                        </tr>`;
                    });
                }
                
                if (data.grand_total === 0) {
                    html += '<tr><td colspan="4" class="text-center text-muted">Tidak ada tagihan untuk pasien ini.</td></tr>';
                }
                
                html += '</tbody>';
                html += `<tfoot>
                    <tr class="table-primary">
                        <th colspan="3" class="text-end">Grand Total</th>
                        <th class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(data.grand_total)}</th>
                    </tr>
                </tfoot>`;
                html += '</table></div>';
                
                rincianContainer.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching biaya:', error);
                rincianContainer.innerHTML = '<div class="alert alert-danger mb-0">Gagal memuat rincian biaya.</div>';
            });
    });
});
</script>
<?= $this->endSection(); ?>