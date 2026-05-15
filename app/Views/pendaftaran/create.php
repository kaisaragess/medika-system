<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Pendaftaran Kunjungan Baru</h4>
            <a href="/pendaftaran" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali ke Antrean</a>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger border-0 shadow-sm"><i class="bi bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-info border-0 shadow-sm"><i class="bi bi-info-circle-fill"></i> <?= session()->getFlashdata('pesan'); ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="/pendaftaran/review" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Pasien</label>
                        <select class="form-select" name="id_pasien" required autofocus>
                            <option value="">-- Cari dan Pilih Pasien --</option>
                            <?php foreach ($pasien as $p) : ?>
                                <?php 
                                    // Cek apakah ada data sementara atau old input
                                    $selectedPasien = (isset($temp_data['id_pasien']) && $temp_data['id_pasien'] == $p['id']) || (old('id_pasien') == $p['id']) ? 'selected' : ''; 
                                ?>
                                <option value="<?= $p['id']; ?>" <?= $selectedPasien; ?>>
                                    <?= $p['nik']; ?> - <?= $p['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text small"><a href="/pasien/create" target="_blank">Pasien belum terdaftar? Tambah Pasien Baru</a></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tujuan Poliklinik</label>
                        <select class="form-select" name="id_poli" required>
                            <option value="">-- Pilih Poliklinik --</option>
                            <?php foreach ($poli as $pl) : ?>
                                <?php 
                                    // Cek apakah ada data sementara atau old input
                                    $selectedPoli = (isset($temp_data['id_poli']) && $temp_data['id_poli'] == $pl['id']) || (old('id_poli') == $pl['id']) ? 'selected' : ''; 
                                ?>
                                <option value="<?= $pl['id']; ?>" <?= $selectedPoli; ?>>
                                    [<?= $pl['kode_poli']; ?>] <?= $pl['nama_poli']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Keluhan Awal</label>
                        <textarea class="form-control" name="keluhan_awal" rows="3" placeholder="Tuliskan keluhan yang dirasakan pasien..." required><?= isset($temp_data['keluhan_awal']) ? $temp_data['keluhan_awal'] : old('keluhan_awal'); ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-arrow-right-circle"></i> Lanjutkan ke Review Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>