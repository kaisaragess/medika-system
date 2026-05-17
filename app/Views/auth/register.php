<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pegawai | MedikaSistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9; 
            padding: 40px 20px;
        }
        .register-container {
            max-width: 700px;
            margin: 0 auto;
        }
        .register-card { 
            border-radius: 16px; 
            border: none; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); 
            background: #fff;
            padding: 40px;
        }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #495057; }
        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .form-control:focus, .form-select:focus {
            background-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
            border-color: #198754;
        }
        .btn-success {
            padding: 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
        }
        .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            background-color: #198754;
            color: white;
            border-radius: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container register-container">
    <div class="register-card">
        <div class="mb-4">
            <a href="/login" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke Login</a>
        </div>
        
        <div class="text-center mb-5">
            <div class="icon-box shadow-sm">
                <i class="bi bi-person-badge fs-2"></i>
            </div>
            <h3 class="fw-bold text-success mb-1">Pendaftaran Akun Pegawai</h3>
            <p class="text-muted">Lengkapi data untuk mengajukan akses sistem</p>
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
                    <input type="text" class="form-control" name="nomor_telp" id="nomor_telp" value="<?= old('nomor_telp'); ?>" required placeholder="Contoh: 081234567890">
                    
                    <div class="small mt-2" id="phone-rules" style="font-size: 0.75rem;">
                        <div id="rule-phone-num" class="text-danger"><i class="bi bi-x-circle"></i> Hanya berisi angka</div>
                        <div id="rule-phone-len" class="text-danger"><i class="bi bi-x-circle"></i> Panjang 10 hingga 13 digit</div>
                    </div>
                </div>

            <!-- AREA KHUSUS DOKTER: Disembunyikan oleh JS jika bukan dokter -->
           <div class="row mb-3 bg-light p-3 rounded-3" id="medical_fields">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-primary">Kategori Poliklinik</label>
                    <select class="form-select" id="kategori_poli">
                        <option value="">-- Pilih Poli --</option>
                        <?php foreach($unique_poli as $poli): ?>
                            <option value="<?= $poli; ?>"><?= $poli; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-primary">Pilih Spesialisasi / Kode</label>
                    <select class="form-select" name="id_poli" id="id_poli">
                        <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                    </select>
                    
                    <input type="hidden" name="spesialisasi" id="hidden_spesialisasi" value="">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Lengkap</label>
                <textarea class="form-control" name="alamat" rows="2" required><?= old('alamat'); ?></textarea>
            </div>

            <hr class="text-muted">

<div class="mb-3">
                <label class="form-label">Username (Untuk Login)</label>
                <input type="text" class="form-control" name="username" value="<?= old('username'); ?>" required>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                    <div class="small mt-2" id="password-rules" style="font-size: 0.75rem;">
                        <div id="rule-length" class="text-danger"><i class="bi bi-x-circle"></i> Minimal 8 karakter</div>
                        <div id="rule-case" class="text-danger"><i class="bi bi-x-circle"></i> Huruf kapital & huruf kecil</div>
                        <div id="rule-num-sym" class="text-danger"><i class="bi bi-x-circle"></i> Angka & Simbol (@$!%*?&#)</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" required>
                    <div class="small mt-2 fw-bold" id="password-match" style="font-size: 0.75rem;"></div>
                </div>
            </div>

            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-success fw-bold">Daftar Sekarang</button>
            </div>
        </form>
    </div>
</div>

    <script>
    // 1. Ambil data JSON dari Controller
    const poliMap = <?= $spesialisasi_map; ?>;

    // 2. Logic ketika Kategori Poli dipilih
    document.getElementById('kategori_poli').addEventListener('change', function() {
        const selectedPoli = this.value;
        const spesialisasiSelect = document.getElementById('id_poli');
        const hiddenSpec = document.getElementById('hidden_spesialisasi');
        
        spesialisasiSelect.innerHTML = '<option value="">-- Pilih Spesialisasi --</option>';
        hiddenSpec.value = ''; // Reset hidden input
        
        if(selectedPoli && poliMap[selectedPoli]) {
            poliMap[selectedPoli].forEach(function(item) {
                let opt = document.createElement('option');
                opt.value = item.id; // Ini ID tabel poliklinik (1, 2, 3, dst)
                // Menyimpan nama spesialisasi di attribute untuk diambil nanti
                opt.setAttribute('data-nama-spec', item.spesialisasi); 
                // Tampilan: [132] ortodonti
                opt.textContent = `[${item.kode_poli}] ${item.spesialisasi}`; 
                spesialisasiSelect.appendChild(opt);
            });
        }
    });

    // 3. Logic untuk mengisi hidden input 'spesialisasi' saat spesialisasi dipilih
    document.getElementById('id_poli').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const hiddenSpec = document.getElementById('hidden_spesialisasi');
        
        if (selectedOption.value !== "") {
            hiddenSpec.value = selectedOption.getAttribute('data-nama-spec');
        } else {
            hiddenSpec.value = '';
        }
    });

    // 4. Logic untuk menyembunyikan kolom medis jika bukan Dokter
    const roleSelect = document.getElementById('role');
    const medicalFields = document.getElementById('medical_fields');

    function toggleMedicalFields() {
        if (roleSelect.value === 'Dokter') {
            medicalFields.style.display = 'flex';
        } else {
            medicalFields.style.display = 'none';
            document.getElementById('kategori_poli').value = '';
            document.getElementById('id_poli').innerHTML = '<option value="">-- Pilih Spesialisasi --</option>';
            document.getElementById('hidden_spesialisasi').value = '';
        }
    }

    roleSelect.addEventListener('change', toggleMedicalFields);
    toggleMedicalFields(); 


    // --- FITUR VALIDASI PASSWORD REAL-TIME ---
    const pwdInput = document.getElementById('password');
    const confirmPwdInput = document.getElementById('konfirmasi_password');
    const matchText = document.getElementById('password-match');

    pwdInput.addEventListener('keyup', function() {
        const val = pwdInput.value;
        
        // Cek Panjang (Min 8)
        updateRuleIndicator('rule-length', val.length >= 8);
        
        // Cek Huruf Besar dan Kecil
        const hasUpperAndLower = /[A-Z]/.test(val) && /[a-z]/.test(val);
        updateRuleIndicator('rule-case', hasUpperAndLower);
        
        // Cek Angka dan Simbol
        const hasNumAndSym = /\d/.test(val) && /[@$!%*?&#]/.test(val);
        updateRuleIndicator('rule-num-sym', hasNumAndSym);
        
        checkPasswordMatch();
    });

    confirmPwdInput.addEventListener('keyup', checkPasswordMatch);

    function updateRuleIndicator(elementId, isValid) {
        const el = document.getElementById(elementId);
        if (isValid) {
            el.classList.replace('text-danger', 'text-success');
            el.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + el.innerText.trim();
        } else {
            el.classList.replace('text-success', 'text-danger');
            el.innerHTML = '<i class="bi bi-x-circle"></i> ' + el.innerText.trim();
        }
    }

    function checkPasswordMatch() {
        if (confirmPwdInput.value === '') {
            matchText.innerText = '';
            return;
        }
        
        if (pwdInput.value === confirmPwdInput.value) {
            matchText.classList.remove('text-danger');
            matchText.classList.add('text-success');
            matchText.innerHTML = '<i class="bi bi-check-circle-fill"></i> Password cocok';
        } else {
            matchText.classList.remove('text-success');
            matchText.classList.add('text-danger');
            matchText.innerHTML = '<i class="bi bi-x-circle"></i> Password tidak cocok';
        }
    }

    // --- FITUR VALIDASI NOMOR TELEPON REAL-TIME ---
    const phoneInput = document.getElementById('nomor_telp');

    phoneInput.addEventListener('input', function() {
        // Otomatis menghapus karakter selain angka yang diketik user
        this.value = this.value.replace(/[^\d]/g, '');
        
        const val = this.value;

        // Cek apakah hanya angka dan tidak kosong
        const isOnlyNumbers = val.length > 0 && /^\d+$/.test(val);
        updateRuleIndicator('rule-phone-num', isOnlyNumbers);

        // Cek panjang antara 10 hingga 13 digit
        const isValidLength = val.length >= 10 && val.length <= 13;
        updateRuleIndicator('rule-phone-len', isValidLength);
    });
    </script>
</body>
</html>