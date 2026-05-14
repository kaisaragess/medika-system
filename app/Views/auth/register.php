<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pegawai | MedikaSistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .register-card { border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); max-width: 600px; width: 100%; }
        .form-label { font-size: 0.85rem; font-weight: 600; }
    </style>
</head>
<body>

<div class="card register-card">
    <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="bg-success text-white rounded-3 d-inline-flex p-2 mb-2">
                <i class="bi bi-person-badge fs-3"></i>
            </div>
            <h4 class="fw-bold">Pendaftaran Akun Pegawai</h4>
            <p class="text-muted small">Lengkapi data untuk mengajukan akses sistem</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger small py-2"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <form action="/auth/processRegister" method="post">
            <?= csrf_field(); ?>
            
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" value="<?= old('nama'); ?>" required autofocus>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label">Role / Jabatan</label>
                    <select class="form-select" name="role" id="role" required>
                        <option value="Dokter" <?= old('role') == 'Dokter' ? 'selected' : ''; ?>>Dokter</option>
                        <option value="Perawat" <?= old('role') == 'Perawat' ? 'selected' : ''; ?>>Perawat</option>
                        <option value="Apoteker" <?= old('role') == 'Apoteker' ? 'selected' : ''; ?>>Apoteker</option>
                        <option value="Kasir" <?= old('role') == 'Kasir' ? 'selected' : ''; ?>>Kasir</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon (WA)</label>
                    <!-- Validasi HTML5: Angka saja, 10-13 digit -->
                    <input type="text" class="form-control" name="nomor_telp" value="<?= old('nomor_telp'); ?>" pattern="\d{10,13}" title="Masukkan 10 hingga 13 digit angka" required placeholder="Contoh: 081234567890">
                </div>
            </div>

            <!-- AREA KHUSUS DOKTER: Disembunyikan oleh JS jika bukan dokter -->
            <div class="row mb-3 bg-light p-3 rounded-3" id="medical_fields">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-primary">Penempatan Poliklinik</label>
                    <select class="form-select" name="id_poli" id="id_poli">
                        <option value="">-- Pilih Poli --</option>
                        <?php foreach($poliklinik as $poli): ?>
                            <!-- Menyimpan nama_poli di data-attribute untuk dipakai JS -->
                            <option value="<?= $poli['id']; ?>" data-name="<?= $poli['nama_poli']; ?>" <?= old('id_poli') == $poli['id'] ? 'selected' : ''; ?>>
                                <?= $poli['nama_poli']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-primary">Spesialisasi</label>
                    <select class="form-select" name="spesialisasi" id="spesialisasi">
                        <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Lengkap</label>
                <textarea class="form-control" name="alamat" rows="2" required><?= old('alamat'); ?></textarea>
            </div>

            <hr class="text-muted">

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label">Username (Untuk Login)</label>
                    <input type="text" class="form-control" name="username" value="<?= old('username'); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success fw-bold">Daftar Sekarang</button>
                <a href="/login" class="btn btn-light border text-muted">Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Ambil data JSON dari Controller (Hasil pecah koma dari tabel Poliklinik)
    const poliMap = <?= $spesialisasi_map; ?>;

    // 2. Logic ketika Poli dipilih
    document.getElementById('id_poli').addEventListener('change', function() {
        const selectedPoliId = this.value;
        const spesialisasiSelect = document.getElementById('spesialisasi');
        
        spesialisasiSelect.innerHTML = '<option value="">-- Pilih Spesialisasi --</option>';
        
        if(selectedPoliId && poliMap[selectedPoliId]) {
            poliMap[selectedPoliId].forEach(function(spec) {
                let opt = document.createElement('option');
                opt.value = spec;
                opt.textContent = spec;
                spesialisasiSelect.appendChild(opt);
            });
        }
    });

    // 3. Logic untuk menyembunyikan kolom medis jika bukan Dokter
    const roleSelect = document.getElementById('role');
    const medicalFields = document.getElementById('medical_fields');

    function toggleMedicalFields() {
        if (roleSelect.value === 'Dokter') {
            medicalFields.style.display = 'flex';
        } else {
            medicalFields.style.display = 'none';
            document.getElementById('id_poli').value = '';
            document.getElementById('spesialisasi').innerHTML = '<option value="">-- Pilih Spesialisasi --</option>';
        }
    }

    roleSelect.addEventListener('change', toggleMedicalFields);
    toggleMedicalFields(); 
</script>

</body>
</html>