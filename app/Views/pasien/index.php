<!-- 1. Memberitahu CI4 bahwa file ini menggunakan template utama -->
<?= $this->extend('layout/template'); ?>

<!-- 2. Memulai bagian konten yang akan disuntikkan ke template -->
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Data Pasien</h2>
            <a href="/pasien/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Pasien</a>
        </div>

        <!-- Menampilkan pesan sukses (flashdata) jika ada -->
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tabel Data -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Pasien</th>
                                <th>L/P</th>
                                <th>No. Telepon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <!-- Melakukan perulangan data pasien dari database -->
                            <?php foreach ($pasien as $p) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $p['nik']; ?></td>
                                    <td><?= $p['nama']; ?></td>
                                    <td><?= $p['jenis_kelamin']; ?></td>
                                    <td><?= $p['no_telp']; ?></td>
                                    <td class="text-center">
                                        <a href="/pasien/edit/<?= $p['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                                        
                                        <a href="/pasien/delete/<?= $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data pasien ini? Semua data terkait pendaftaran pasien ini juga akan ikut terhapus.');"><i class="bi bi-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <!-- Pesan jika data masih kosong -->
                            <?php if(empty($pasien)) : ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Belum ada data pasien.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Menutup bagian konten -->
<?= $this->endSection(); ?>