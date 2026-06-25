<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history"></i> Buku Besar Histori Kunjungan</h2>
            <button class="btn btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Laporan</button>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-primary text-nowrap">
                            <tr>
                                <th class="ps-3">No Pendaftaran</th>
                                <th>Nama Pasien</th>
                                <th>Poliklinik</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($histori)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada rekam jejak histori apapun di sistem.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($histori as $h): ?>
                                    <tr>
                                        <td class="ps-3">
                                            <span class="badge bg-secondary"><?= $h['no_pendaftaran']; ?></span>
                                        </td>
                                        <td>
                                            <strong><?= $h['nama_pasien']; ?></strong>
                                        </td>
                                        <td><span class="badge bg-light text-dark border"><?= $h['nama_poli']; ?></span></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#detailModal<?= $h['id_pendaftaran'] ?>">
                                                <i class="bi bi-eye"></i> Lihat Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal<?= $h['id_pendaftaran'] ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $h['id_pendaftaran'] ?>" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold" id="detailModalLabel<?= $h['id_pendaftaran'] ?>">Detail Histori - <?= $h['no_pendaftaran'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <span class="text-muted small d-block">Tanggal Kunjungan</span>
                                                    <strong class="fs-6"><?= date('d M Y H:i', strtotime($h['tanggal'])); ?> WIB</strong>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <span class="text-muted small d-block">Status Kunjungan</span>
                                                    <?php if($h['status_pendaftaran'] == 'Selesai'): ?>
                                                        <span class="badge bg-success mt-1">Selesai</span>
                                                    <?php elseif($h['status_pendaftaran'] == 'Batal'): ?>
                                                        <span class="badge bg-danger mt-1">Dibatalkan</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning text-dark mt-1">Dalam Antrean</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <span class="text-muted small d-block">Data Pasien</span>
                                                    <strong class="fs-6"><?= $h['nama_pasien']; ?></strong><br>
                                                    <small class="text-muted">NIK: <?= $h['nik']; ?></small>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <span class="text-muted small d-block">Poliklinik Tujuan</span>
                                                    <strong class="fs-6"><?= $h['nama_poli']; ?></strong>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <h6 class="fw-bold border-bottom pb-2">Catatan Rekam Medis</h6>
                                                    <?php 
                                                        $rmPasien = $rekamMedisPasien[$h['id_pasien']] ?? [];
                                                    ?>
                                                    <?php if(count($rmPasien) > 0): ?>
                                                        <?php if(count($rmPasien) > 1): ?>
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold">Pilihan Rekam Medis berdasarkan Tanggal Kunjungan:</label>
                                                                <select class="form-select form-select-sm select-rm-history" data-target="rm-container-<?= $h['id_pendaftaran'] ?>">
                                                                    <?php foreach($rmPasien as $idx => $rm): ?>
                                                                        <option value="rm-<?= $rm['id'] ?>-<?= $h['id_pendaftaran'] ?>" <?= ($rm['kd_rekam_medis'] == $h['kd_rekam_medis']) ? 'selected' : '' ?>>
                                                                            <?= date('d M Y', strtotime($rm['tanggal_periksa'])) ?> (Poliklinik / <?= $rm['no_pendaftaran'] ?>)
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        <?php endif; ?>

                                                        <div id="rm-container-<?= $h['id_pendaftaran'] ?>">
                                                            <?php foreach($rmPasien as $idx => $rm): ?>
                                                                <div class="rm-item" id="rm-<?= $rm['id'] ?>-<?= $h['id_pendaftaran'] ?>" style="<?= ($rm['kd_rekam_medis'] == $h['kd_rekam_medis'] || ($idx == 0 && !$h['kd_rekam_medis'])) ? 'display:block;' : 'display:none;' ?>">
                                                                    <div class="mb-2"><span class="badge bg-secondary">RM: <?= $rm['kd_rekam_medis']; ?></span></div>
                                                                    <div class="mb-2"><span class="text-muted small d-block">Diagnosa:</span> <span class="text-danger fw-bold"><?= $rm['diagnosa']; ?></span></div>
                                                                    <?php if($rm['tindakan_medis']): ?>
                                                                        <div class="mb-2"><span class="text-muted small d-block">Tindakan Medis:</span> <?= $rm['tindakan_medis']; ?></div>
                                                                    <?php endif; ?>
                                                                    <?php if($rm['file']): ?>
                                                                        <div class="mt-3">
                                                                            <?php 
                                                                                $files = json_decode($rm['file'], true);
                                                                                if(is_array($files)) {
                                                                                    foreach($files as $fidx => $f) {
                                                                                        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                                                                        $icon = ($ext == 'pdf') ? 'bi-file-earmark-pdf' : 'bi-image';
                                                                                        echo '<a href="'.base_url('uploads/rekam_medis/' . $f).'" target="_blank" class="btn btn-sm btn-outline-danger me-1 mb-1"><i class="bi '.$icon.'"></i> Buka File '.($fidx+1).'</a>';
                                                                                    }
                                                                                } else {
                                                                                    $ext = strtolower(pathinfo($rm['file'], PATHINFO_EXTENSION));
                                                                                    $icon = ($ext == 'pdf') ? 'bi-file-earmark-pdf' : 'bi-image';
                                                                                    echo '<a href="'.base_url('uploads/rekam_medis/' . $rm['file']).'" target="_blank" class="btn btn-sm btn-outline-danger me-1 mb-1"><i class="bi '.$icon.'"></i> Buka File</a>';
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="alert alert-light border fst-italic text-center py-3">Belum ada data rekam medis yang diinputkan untuk kunjungan maupun pasien ini.</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- End Modal -->
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-muted small text-center py-3">
                <i class="bi bi-info-circle"></i> Tabel ini merangkum seluruh aktivitas dari tabel pendaftaran. Klik "Lihat Detail" untuk informasi lengkap.
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling khusus cetak */
    @media print {
        #sidebar, .navbar, .btn-outline-secondary, .card-footer, .nav-link {
            display: none !important;
        }
        #main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card { border: none !important; box-shadow: none !important; }
        .table-responsive { overflow: visible !important; }
    }
</style>

<?= $this->section('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rmSelects = document.querySelectorAll('.select-rm-history');
    
    rmSelects.forEach(select => {
        select.addEventListener('change', function() {
            const targetContainerId = this.getAttribute('data-target');
            const targetContainer = document.getElementById(targetContainerId);
            const selectedRmId = this.value;
            
            if(targetContainer) {
                // Hide all rm-items inside this container
                const rmItems = targetContainer.querySelectorAll('.rm-item');
                rmItems.forEach(item => {
                    item.style.display = 'none';
                });
                
                // Show the selected one
                const selectedItem = targetContainer.querySelector('#' + selectedRmId);
                if(selectedItem) {
                    selectedItem.style.display = 'block';
                }
            }
        });
    });
});
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>
