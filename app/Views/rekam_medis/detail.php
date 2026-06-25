<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-file-earmark-medical"></i> Detail Rekam Medis</h5>
                <span class="badge bg-light text-info fs-6"><?= $rekam_medis['kd_rekam_medis']; ?></span>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Nomor Registrasi (Antrean)</th>
                            <td>: <span class="fw-bold text-primary"><?= $rekam_medis['no_pendaftaran']; ?></span></td>
                        </tr>
                        <tr>
                            <th>Nama Pasien</th>
                            <td>: <?= $rekam_medis['nama_pasien']; ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Periksa</th>
                            <td>: <?= date('d F Y', strtotime($rekam_medis['tanggal_periksa'])); ?></td>
                        </tr>
                        <tr>
                            <th>Dokter Pemeriksa</th>
                            <td>: <strong><?= $rekam_medis['nama_dokter']; ?></strong></td>
                        </tr>
                        <tr>
                            <th>Tekanan Darah (Tensi)</th>
                            <td>: <?= $rekam_medis['tekanan_darah'] ? $rekam_medis['tekanan_darah'] : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Keluhan Pasien</th>
                            <td>: <br><span class="text-muted d-block mt-1"><?= nl2br($rekam_medis['keluhan']); ?></span></td>
                        </tr>
                        <tr>
                            <th>Diagnosa Dokter</th>
                            <td>: <br><span class="text-danger d-block mt-1 fw-semibold"><?= $rekam_medis['diagnosa'] ? nl2br($rekam_medis['diagnosa']) : 'Belum ada diagnosa'; ?></span></td>
                        </tr>
                        <tr>
                            <th>Tindakan Medis</th>
                            <td>: <br><span class="text-muted d-block mt-1"><?= $rekam_medis['tindakan_medis'] ? nl2br($rekam_medis['tindakan_medis']) : '-'; ?></span></td>
                        </tr>
                        <tr>
                            <th>Dokumen/Foto Terlampir</th>
                            <td>: 
                                <?php if($rekam_medis['file']): ?>
                                    <div class="mt-1 d-flex flex-wrap gap-2">
                                    <?php 
                                        $files = json_decode($rekam_medis['file'], true);
                                        if(is_array($files)) {
                                            foreach($files as $idx => $f) {
                                                $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                                $icon = ($ext == 'pdf') ? 'bi-file-earmark-pdf' : 'bi-image';
                                                echo '<a href="'.base_url('uploads/rekam_medis/' . $f).'" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi '.$icon.'"></i> Buka File '.($idx+1).'</a>';
                                            }
                                        } else {
                                            // Fallback for old single file
                                            $ext = strtolower(pathinfo($rekam_medis['file'], PATHINFO_EXTENSION));
                                            $icon = ($ext == 'pdf') ? 'bi-file-earmark-pdf' : 'bi-image';
                                            echo '<a href="'.base_url('uploads/rekam_medis/' . $rekam_medis['file']).'" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi '.$icon.'"></i> Buka File</a>';
                                        }
                                    ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Tidak ada file terlampir.</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light text-end">
                <a href="/rekam_medis" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                <a href="/rekam_medis/edit/<?= $rekam_medis['id']; ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Ubah Data</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
