<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Isi Rekam Medis Pasien</h5>
            </div>
            <div class="card-body">
                <form action="/rekam_medis/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kd_rekam_medis" class="form-label">Kode Rekam Medis</label>
                            <input type="text" class="form-control bg-light fw-bold text-primary" id="kd_rekam_medis" name="kd_rekam_medis" value="<?= $kd_rekam_medis; ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_periksa" class="form-label">Tanggal Periksa</label>
                            <input type="date" class="form-control <?= ($validation->hasError('tanggal_periksa')) ? 'is-invalid' : ''; ?>" id="tanggal_periksa" name="tanggal_periksa" value="<?= date('Y-m-d'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('tanggal_periksa'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <label for="id_pegawai" class="form-label">Dokter Pemeriksa</label>
                            <select class="form-select <?= ($validation->hasError('id_pegawai')) ? 'is-invalid' : ''; ?>" id="id_pegawai" name="id_pegawai">
                                <option value="">-- Pilih Dokter --</option>
                                <?php foreach($dokter as $dkt): ?>
                                    <option value="<?= $dkt['id']; ?>" <?= old('id_pegawai') == $dkt['id'] ? 'selected' : ''; ?>>
                                        <?= $dkt['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('id_pegawai'); ?></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="id_pendaftaran" class="form-label">Pasien yang Diperiksa (Dari Antrean)</label>
                        <select class="form-select <?= ($validation->hasError('id_pendaftaran')) ? 'is-invalid' : ''; ?>" id="id_pendaftaran" name="id_pendaftaran" autofocus>
                            <option value="">-- Pilih Antrean Pasien --</option>
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= old('id_pendaftaran') == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('id_pendaftaran'); ?></div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="keluhan" class="form-label">Keluhan Pasien</label>
                            <textarea class="form-control <?= ($validation->hasError('keluhan')) ? 'is-invalid' : ''; ?>" id="keluhan" name="keluhan" rows="3"><?= old('keluhan'); ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('keluhan'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="diagnosa" class="form-label">Hasil Diagnosa</label>
                            <textarea class="form-control" id="diagnosa" name="diagnosa" rows="3"><?= old('diagnosa'); ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label for="tindakan_medis" class="form-label">Tindakan Medis yang Diberikan</label>
                            <textarea class="form-control" id="tindakan_medis" name="tindakan_medis" rows="2"><?= old('tindakan_medis'); ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="tekanan_darah" class="form-label">Tekanan Darah (Tensi)</label>
                            <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" value="<?= old('tekanan_darah'); ?>" placeholder="Misal: 120/80 mmHg">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/rekam_medis" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>