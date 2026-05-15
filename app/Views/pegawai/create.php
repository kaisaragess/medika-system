<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Formulir Pegawai Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="/pegawai/store" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama tanpa gelar" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jabatan / Role</label>
                            <select class="form-select" name="role" id="role_select" required>
                                <option value="Admin">Admin</option>
                                <option value="Dokter">Dokter</option>
                                <option value="Perawat">Perawat</option>
                                <option value="Apoteker">Apoteker</option>
                                <option value="Kasir">Kasir</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-3 d-none" id="dokter_area">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Unit Poliklinik</label>
                                <select class="form-select" name="id_poli" id="id_poli">
                                    <option value="">-- Pilih Unit --</option>
                                    <?php foreach($poliklinik as $poli): ?>
                                        <option value="<?= $poli['id']; ?>" data-spec="<?= $poli['daftar_spesialisasi']; ?>">
                                            [<?= $poli['kode_poli']; ?>] <?= $poli['nama_poli']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Spesialisasi</label>
                                <select class="form-select" name="spesialisasi" id="spesialisasi_select">
                                    <option value="">-- Pilih Poli Dahulu --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">No. Telepon (WhatsApp)</label>
                        <input type="text" class="form-control" name="nomor_telp" placeholder="08..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Alamat Domisili</label>
                        <textarea class="form-control" name="alamat" rows="2" required></textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Password Default</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/pegawai" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Pegawai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('role_select');
    const dokterArea = document.getElementById('dokter_area');
    const idPoli = document.getElementById('id_poli');
    const specSelect = document.getElementById('spesialisasi_select');

    roleSelect.addEventListener('change', function() {
        if(this.value === 'Dokter') {
            dokterArea.classList.remove('d-none');
        } else {
            dokterArea.classList.add('d-none');
        }
    });

    idPoli.addEventListener('change', function() {
        const specs = this.options[this.selectedIndex].getAttribute('data-spec');
        specSelect.innerHTML = '<option value="">-- Pilih Spesialisasi --</option>';
        if(specs) {
            specs.split(',').forEach(s => {
                let opt = document.createElement('option');
                opt.value = s.trim();
                opt.textContent = s.trim();
                specSelect.appendChild(opt);
            });
        }
    });
</script>
<?= $this->endSection(); ?>