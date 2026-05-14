<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetupDatabase extends Migration
{
    public function up()
    {
        //
        $db = \Config\Database::connect();

        // 1. Tabel Master
        $db->query("CREATE TABLE pasien (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nik VARCHAR(20) UNIQUE,
            nama VARCHAR(100),
            jenis_kelamin ENUM('L', 'P'),
            tgl_lahir DATE,
            alamat TEXT,
            no_telp VARCHAR(20)
        )");

        $db->query("CREATE TABLE kamar (
            id INT PRIMARY KEY AUTO_INCREMENT,
            kd_kmr VARCHAR(20) UNIQUE,
            kelas VARCHAR(50),
            harga_per_malam DECIMAL(10,2),
            status ENUM('Tersedia', 'Terisi', 'Perbaikan') DEFAULT 'Tersedia'
        )");

        $db->query("CREATE TABLE poliklinik (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nama_poli VARCHAR(100),
            ruangan VARCHAR(50)
        )");

        $db->query("CREATE TABLE obat (
            id INT PRIMARY KEY AUTO_INCREMENT,
            kd_obat VARCHAR(20) UNIQUE,
            nama_obat VARCHAR(100),
            jenis VARCHAR(50),
            dosis VARCHAR(50),
            satuan VARCHAR(50),
            harga DECIMAL(10,2),
            qty INT,
            expired DATE
        )");

        $db->query("CREATE TABLE layanan (
            id INT PRIMARY KEY AUTO_INCREMENT,
            kd_layanan VARCHAR(20) UNIQUE,
            nama_layanan VARCHAR(100),
            kategori VARCHAR(50),
            harga DECIMAL(10,2),
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE pegawai (
            id INT PRIMARY KEY AUTO_INCREMENT,
            id_poli INT,
            nama VARCHAR(100),
            alamat TEXT,
            spesialisasi VARCHAR(100),
            nomor_telp VARCHAR(20),
            role VARCHAR(50),
            FOREIGN KEY (id_poli) REFERENCES poliklinik(id) ON DELETE SET NULL
        )");

        // 2. Tabel Pendaftaran
        $db->query("CREATE TABLE pendaftaran (
            id INT PRIMARY KEY AUTO_INCREMENT,
            no_pendaftaran VARCHAR(50) UNIQUE,
            id_pasien INT,
            tgl_daftar DATETIME DEFAULT CURRENT_TIMESTAMP,
            status ENUM('Antri', 'Diperiksa', 'Selesai', 'Batal') DEFAULT 'Antri',
            FOREIGN KEY (id_pasien) REFERENCES pasien(id) ON DELETE CASCADE
        )");

        $db->query("CREATE TABLE rekam_medis (
            id INT PRIMARY KEY AUTO_INCREMENT,
            kd_rekam_medis VARCHAR(50) UNIQUE,
            id_pendaftaran INT,
            id_pegawai INT,
            tanggal_periksa DATE,
            keluhan TEXT,
            diagnosa TEXT,
            tindakan_medis TEXT,
            tekanan_darah VARCHAR(20),
            file TEXT,
            FOREIGN KEY (id_pendaftaran) REFERENCES pendaftaran(id) ON DELETE CASCADE,
            FOREIGN KEY (id_pegawai) REFERENCES pegawai(id)
        )");

        $db->query("CREATE TABLE transaksi_kamar (
            id INT PRIMARY KEY AUTO_INCREMENT,
            id_pendaftaran INT,
            id_kamar INT,
            tgl_masuk DATE,
            tgl_keluar DATE,
            total_biaya DECIMAL(10,2),
            FOREIGN KEY (id_pendaftaran) REFERENCES pendaftaran(id) ON DELETE CASCADE,
            FOREIGN KEY (id_kamar) REFERENCES kamar(id)
        )");

        $db->query("CREATE TABLE transaksi_obat (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_pendaftaran INT,
                id_obat INT,
                qty INT,
                aturan_pakai VARCHAR(100),
                tagihan_obat DECIMAL(10,2),
                FOREIGN KEY (id_pendaftaran) REFERENCES pendaftaran(id) ON DELETE CASCADE,
                FOREIGN KEY (id_obat) REFERENCES obat(id)
        )");

        $db->query("CREATE TABLE transaksi_layanan (
            id INT PRIMARY KEY AUTO_INCREMENT,
            id_pendaftaran INT,
            id_layanan INT,
            qty INT DEFAULT 1,
            total_harga DECIMAL(10,2),
            FOREIGN KEY (id_pendaftaran) REFERENCES pendaftaran(id) ON DELETE CASCADE,
            FOREIGN KEY (id_layanan) REFERENCES layanan(id)
        )");

        $db->query("CREATE TABLE pembayaran (
            id INT PRIMARY KEY AUTO_INCREMENT,
            id_pendaftaran INT,
            id_pegawai INT,
            tgl_bayar DATETIME DEFAULT CURRENT_TIMESTAMP,
            metode_bayar VARCHAR(50),
            total_bayar DECIMAL(10,2),
            status_pembayaran ENUM('Belum Lunas', 'Lunas', 'Batal') DEFAULT 'Belum Lunas',
            FOREIGN KEY (id_pendaftaran) REFERENCES pendaftaran(id) ON DELETE CASCADE,
            FOREIGN KEY (id_pegawai) REFERENCES pegawai(id)
        )");

        $db->query("CREATE TABLE detail_pembayaran (
            id INT PRIMARY KEY AUTO_INCREMENT,
            id_pembayaran INT,
            jenis_item VARCHAR(50),
            nama_item VARCHAR(100),
            biaya DECIMAL(10,2),
            qty INT,
            subtotal DECIMAL(10,2),
            FOREIGN KEY (id_pembayaran) REFERENCES pembayaran(id) ON DELETE CASCADE
        )");


    }

    public function down()
    {
        // Fungsi ini berguna jika kamu ingin me-rollback / menghapus database
        $this->forge->dropTable('detail_pembayaran', true);
        $this->forge->dropTable('pembayaran', true);
        $this->forge->dropTable('transaksi_layanan', true);
        $this->forge->dropTable('transaksi_obat', true);
        $this->forge->dropTable('transaksi_kamar', true);
        $this->forge->dropTable('rekam_medis', true);
        $this->forge->dropTable('pendaftaran', true);
        $this->forge->dropTable('pegawai', true);
        $this->forge->dropTable('layanan', true);
        $this->forge->dropTable('obat', true);
        $this->forge->dropTable('poliklinik', true);
        $this->forge->dropTable('kamar', true);
        $this->forge->dropTable('pasien', true);
    }
}
