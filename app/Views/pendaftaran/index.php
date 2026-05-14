<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Pendaftaran Kunjungan</h2>
            <a href="/pendaftaran/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Daftar Pasien Baru</a>
        </div>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No. Pendaftaran</th>
                                <th>Waktu Daftar</th>
                                <th>NIK Pasien</th>
                                <th>Nama Pasien</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pendaftaran as $p) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td class="fw-bold text-primary"><?= $p['no_pendaftaran']; ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($p['tgl_daftar'])); ?></td>
                                    <td><?= $p['nik']; ?></td>
                                    <td><?= $p['nama_pasien']; ?></td>
                                    <td>
                                        <?php if($p['status'] == 'Antri'): ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Antri</span>
                                        <?php elseif($p['status'] == 'Diperiksa'): ?>
                                            <span class="badge bg-info text-dark"><i class="bi bi-stethoscope"></i> Diperiksa</span>
                                        <?php elseif($p['status'] == 'Selesai'): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-all"></i> Selesai</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Batal</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/pendaftaran/edit/<?= $p['id']; ?>" class="btn btn-sm btn-primary" title="Ubah Status"><i class="bi bi-arrow-repeat"></i> Status</a>
                                        
                                        <form action="/pendaftaran/delete/<?= $p['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Peringatan: Menghapus pendaftaran akan menghapus SEMUA rekam medis, tagihan obat, dan layanan pada kunjungan ini. Lanjutkan?');" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($pendaftaran)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Belum ada pasien yang mendaftar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>