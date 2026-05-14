<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Ubah Data Rekam Medis</h5>
            </div>
            <div class="card-body">
                <form action="/rekam_medis/update/<?= $rekam_medis['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Kode Rekam Medis</label>
                            <input type="text" class="form-control bg-light" value="<?= $rekam_medis['kd_rekam_medis']; ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_periksa" class="form-label">Tanggal Periksa</label>
                            <input type="date" class="form-control" id="tanggal_periksa" name="tanggal_periksa" value="<?= (old('tanggal_periksa')) ? old('tanggal_periksa') : $rekam_medis['tanggal_periksa']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="id_pegawai" class="form-label">Dokter Pemeriksa</label>
                            <?php $id_pegawai = (old('id_pegawai')) ? old('id_pegawai') : $rekam_medis['id_pegawai']; ?>
                            <select class="form-select" id="id_pegawai" name="id_pegawai">
                                <?php foreach($dokter as $dkt): ?>
                                    <option value="<?= $dkt['id']; ?>" <?= $id_pegawai == $dkt['id'] ? 'selected' : ''; ?>>
                                        <?= $dkt['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="id_pendaftaran" class="form-label">Pasien</label>
                        <?php $id_pendaftaran = (old('id_pendaftaran')) ? old('id_pendaftaran') : $rekam_medis['id_pendaftaran']; ?>
                        <select class="form-select" id="id_pendaftaran" name="id_pendaftaran">
                            <?php foreach($pendaftaran as $psn): ?>
                                <option value="<?= $psn['id']; ?>" <?= $id_pendaftaran == $psn['id'] ? 'selected' : ''; ?>>
                                    [<?= $psn['no_pendaftaran']; ?>] - <?= $psn['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="keluhan" class="form-label">Keluhan Pasien</label>
                            <textarea class="form-control <?= ($validation->hasError('keluhan')) ? 'is-invalid' : ''; ?>" id="keluhan" name="keluhan" rows="3"><?= (old('keluhan')) ? old('keluhan') : $rekam_medis['keluhan']; ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('keluhan'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="diagnosa" class="form-label">Hasil Diagnosa</label>
                            <textarea class="form-control" id="diagnosa" name="diagnosa" rows="3"><?= (old('diagnosa')) ? old('diagnosa') : $rekam_medis['diagnosa']; ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label for="tindakan_medis" class="form-label">Tindakan Medis yang Diberikan</label>
                            <textarea class="form-control" id="tindakan_medis" name="tindakan_medis" rows="2"><?= (old('tindakan_medis')) ? old('tindakan_medis') : $rekam_medis['tindakan_medis']; ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="tekanan_darah" class="form-label">Tekanan Darah (Tensi)</label>
                            <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" value="<?= (old('tekanan_darah')) ? old('tekanan_darah') : $rekam_medis['tekanan_darah']; ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/rekam_medis" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Perbarui Rekam Medis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>