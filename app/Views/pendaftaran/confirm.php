<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-warning text-dark py-3 rounded-top-4">
                <h5 class="fw-bold mb-0"><i class="bi bi-exclamation-circle"></i> Konfirmasi Data Kunjungan</h5>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info small pb-0">
                    <p>Data berikut disimpan sementara. Mohon pastikan kembali dengan pasien sebelum menyimpan permanen.</p>
                </div>

                <table class="table table-borderless">
                    <tr>
                        <td width="35%" class="text-muted fw-bold">Nama Pasien</td>
                        <td>: <span class="fw-bold"><?= $temp_data['nama_pasien']; ?></span></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Tujuan Poliklinik</td>
                        <td>: <?= $temp_data['nama_poli']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Waktu Daftar</td>
                        <td>: <?= $temp_data['tanggal']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Petugas Kasir/Admin</td>
                        <td>: <?= $temp_data['petugas']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Keluhan Awal</td>
                        <td>: <div class="bg-light p-2 rounded mt-1 border"><?= $temp_data['keluhan_awal']; ?></div></td>
                    </tr>
                </table>

                <hr>

                <div class="d-flex justify-content-between mt-4">
                    <a href="/pendaftaran/cancel" class="btn btn-outline-danger fw-bold"><i class="bi bi-x-lg"></i> Batalkan</a>
                    
                    <form action="/pendaftaran/store" method="post">
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-success fw-bold px-4"><i class="bi bi-save"></i> Konfirmasi & Simpan</button>
                    </form>
                </div>
                
                <div class="text-center mt-3">
                    <a href="/pendaftaran/create" class="text-decoration-none small text-muted"><i class="bi bi-pencil"></i> Edit Data Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>