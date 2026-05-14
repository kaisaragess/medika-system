<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Pegawai & Tenaga Medis</h2>
            <a href="/pegawai/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Pegawai</a>
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
                                <th>Nama Lengkap</th>
                                <th>Role / Jabatan</th>
                                <th>Spesialisasi</th>
                                <th>Poliklinik</th>
                                <th>No. Telepon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pegawai as $p) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td class="fw-bold"><?= $p['nama']; ?></td>
                                    <td>
                                        <!-- Menampilkan Role -->
                                        <?php if($p['role'] == 'Dokter'): ?>
                                            <span class="badge bg-success">Dokter</span>
                                        <?php elseif($p['role'] == 'Admin' || $p['role'] == 'Kasir'): ?>
                                            <span class="badge bg-primary"><?= $p['role']; ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= $p['role']; ?></span>
                                        <?php endif; ?>
                                        
                                        <!-- Menampilkan Status Pending -->
                                        <?php if(isset($p['is_active']) && $p['is_active'] == 0): ?>
                                            <br><span class="badge bg-danger mt-1">Pending ACC</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $p['spesialisasi'] ? $p['spesialisasi'] : '-'; ?></td>
                                    <td><?= isset($p['nama_poli']) && $p['nama_poli'] ? $p['nama_poli'] : '-'; ?></td>
                                    <td><?= $p['nomor_telp']; ?></td>
                                    <td class="text-center">
                                        
                                        <!-- Tombol ACC HANYA muncul untuk Admin dan jika akun masih pending -->
                                        <?php if(isset($p['is_active']) && $p['is_active'] == 0 && session()->get('role') == 'Admin'): ?>
                                            <form action="/pegawai/approve/<?= $p['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui dan aktifkan akun ini?');" title="Approve Akun"><i class="bi bi-check-circle"></i> ACC</button>
                                            </form>
                                        <?php endif; ?>

                                        <!-- Tombol Edit & Hapus -->
                                        <a href="/pegawai/edit/<?= $p['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form action="/pegawai/delete/<?= $p['id']; ?>" method="get" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data pegawai ini?');"><i class="bi bi-trash"></i></button>
                                        </form>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($pegawai)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Data pegawai belum tersedia.</td>
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