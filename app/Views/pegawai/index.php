<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Manajemen Pegawai & Tenaga Medis</h4>
                <p class="text-muted small">Kelola hak akses dan penempatan staf rumah sakit.</p>
            </div>
            <a href="/pegawai/create" class="btn btn-primary shadow-sm"><i class="bi bi-person-plus-fill"></i> Tambah Pegawai</a>
        </div>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>Kontak & Alamat</th>
                                <th>Jabatan / Unit</th>
                                <th>Status Akun</th>
                                <th class="text-center" width="18%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pegawai as $p) : ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $i++; ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $p['nama']; ?></div>
                                        <div class="small text-muted">@<?= $p['username']; ?></div>
                                    </td>
                                    <td>
                                        <div class="small"><i class="bi bi-whatsapp text-success"></i> <?= $p['nomor_telp']; ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 150px;"><?= $p['alamat']; ?></div>
                                    </td>
                                    <td>
                                        <?php 
                                            $badgeClass = 'bg-secondary';
                                            if($p['role'] == 'Admin') $badgeClass = 'bg-dark';
                                            if($p['role'] == 'Dokter') $badgeClass = 'bg-success';
                                            if($p['role'] == 'Kasir') $badgeClass = 'bg-info';
                                        ?>
                                        <span class="badge <?= $badgeClass; ?> mb-1"><?= $p['role']; ?></span>
                                        <?php if($p['role'] == 'Dokter'): ?>
                                            <div class="small text-primary fw-bold" style="font-size: 0.7rem;"><?= $p['spesialisasi']; ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($p['is_active'] == 1): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Pending ACC</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group">
                                            <?php if($p['is_active'] == 0 && session()->get('role') == 'Admin'): ?>
                                                <form action="/pegawai/approve/<?= $p['id']; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Setujui Akun"><i class="bi bi-check-lg"></i></button>
                                                </form>
                                            <?php endif; ?>
                                            <a href="/pegawai/edit/<?= $p['id']; ?>" class="btn btn-sm btn-outline-warning" title="Ubah Data"><i class="bi bi-pencil"></i></a>
                                            <a href="/pegawai/delete/<?= $p['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>