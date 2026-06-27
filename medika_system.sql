-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: medika_system
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `detail_pembayaran`
--

DROP TABLE IF EXISTS `detail_pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_pembayaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pembayaran` int DEFAULT NULL,
  `jenis_item` varchar(50) DEFAULT NULL,
  `nama_item` varchar(100) DEFAULT NULL,
  `biaya` decimal(10,2) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pembayaran` (`id_pembayaran`),
  CONSTRAINT `detail_pembayaran_ibfk_1` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_pembayaran`
--

LOCK TABLES `detail_pembayaran` WRITE;
/*!40000 ALTER TABLE `detail_pembayaran` DISABLE KEYS */;
INSERT INTO `detail_pembayaran` VALUES (1,1,'Layanan','Total Tagihan Layanan Medis',100000.00,1,100000.00),(2,1,'Kamar','Total Tagihan Rawat Inap',1500000.00,1,1500000.00),(3,2,'Layanan','Total Tagihan Layanan Medis',100000.00,1,100000.00),(4,2,'Kamar','Total Tagihan Rawat Inap',1500000.00,1,1500000.00),(5,4,'Obat','Resep Obat: Paracetamol',5000.00,1,5000.00),(6,4,'Layanan','Tindakan/Layanan: Pemasangan Behel (metal brace)',5000000.00,1,5000000.00),(7,5,'Obat','Resep Obat: Ondansetron',35000.00,1,35000.00),(8,5,'Layanan','Tindakan/Layanan: Paket Persalinan Caesar (SC)',25000000.00,1,25000000.00),(9,5,'Kamar','Rawat Inap: Kamar KMR-3-02 (Kelas 3)',200000.00,1,200000.00),(10,6,'Obat','Resep Obat: Amlodipine',12000.00,1,12000.00),(11,6,'Layanan','Tindakan/Layanan: Tindik Telinga Bayi ',100000.00,1,100000.00),(12,6,'Kamar','Rawat Inap: Kamar KMR-3-02 (Kelas 3)',200000.00,1,200000.00),(13,7,'Obat','Resep Obat: Sanmol',20000.00,1,20000.00),(14,7,'Layanan','Tindakan/Layanan: Kontrol Behel Rutin',200000.00,1,200000.00),(15,8,'Obat','Resep Obat: Amoxicillin',15000.00,1,15000.00),(16,8,'Layanan','Tindakan/Layanan: Konsultasi Dokter Umum',50000.00,1,50000.00),(17,9,'Obat','Resep Obat: Ketoconazole Cream',15000.00,1,15000.00),(18,9,'Layanan','Tindakan/Layanan: Konsultasi Dokter Umum',50000.00,1,50000.00);
/*!40000 ALTER TABLE `detail_pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kamar`
--

DROP TABLE IF EXISTS `kamar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kamar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_kmr` varchar(20) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `harga_per_malam` decimal(10,2) DEFAULT NULL,
  `status` enum('Tersedia','Terisi','Perbaikan') DEFAULT 'Tersedia',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_kmr` (`kd_kmr`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kamar`
--

LOCK TABLES `kamar` WRITE;
/*!40000 ALTER TABLE `kamar` DISABLE KEYS */;
INSERT INTO `kamar` VALUES (1,'111','VVIP',1500000.00,'Tersedia'),(2,'112','VVIP',1500000.00,'Tersedia'),(3,'211','VIP',1000000.00,'Tersedia'),(4,'212','VIP',1000000.00,'Tersedia'),(5,'311','Kelas 1',600000.00,'Tersedia'),(6,'312','Kelas 1',600000.00,'Tersedia'),(7,'321','Kelas 2',400000.00,'Tersedia'),(8,'322','Kelas 2',400000.00,'Tersedia'),(9,'331','Kelas 3',200000.00,'Tersedia'),(10,'332','Kelas 3',200000.00,'Tersedia'),(11,'KMR-ICU-01','VVIP',2500000.00,'Tersedia'),(12,'KMR-NICU-01','NICU',3000000.00,'Tersedia'),(13,'IGD-1','Kelas 3',100000.00,'Tersedia');
/*!40000 ALTER TABLE `kamar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layanan`
--

DROP TABLE IF EXISTS `layanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_layanan` varchar(20) DEFAULT NULL,
  `nama_layanan` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_layanan` (`kd_layanan`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layanan`
--

LOCK TABLES `layanan` WRITE;
/*!40000 ALTER TABLE `layanan` DISABLE KEYS */;
INSERT INTO `layanan` VALUES (1,'0301','Scalling Gigi Pembersihan Karang Gigi','Tindakan Medis',350000.00,1,'2026-05-15 17:17:39','2026-05-15 17:17:39'),(2,'0302','Pencabutan Gigi (Eksodonsi)','Tindakan Medis',250000.00,1,'2026-05-15 17:18:48','2026-05-15 17:18:48'),(3,'0303','Tambal Gigi Komposit','Tindakan Medis',400000.00,1,'2026-05-15 17:19:30','2026-05-15 17:19:30'),(4,'0304','Pemasangan Behel (metal brace)','Tindakan Medis',5000000.00,1,'2026-05-15 17:20:58','2026-05-15 17:20:58'),(5,'0305','Kontrol Behel Rutin','Konsultasi',200000.00,1,'2026-05-15 17:21:53','2026-05-15 17:21:53'),(6,'0306','Perawatan Saluran Akar','Tindakan Medis',600000.00,1,'2026-05-15 17:22:38','2026-05-15 17:22:38'),(7,'0307','Odontektomi (Operasi Gigi Bungsu','Tindakan Medis',2000000.00,1,'2026-05-15 17:23:27','2026-05-15 17:23:27'),(8,'0701','Konsultasi Spesialis THT','Konsultasi',250000.00,1,'2026-05-15 17:25:26','2026-05-15 17:25:26'),(9,'0702','Ekstraksi Serumen (Pembersihan Telinga)','Tindakan Medis',150000.00,1,'2026-05-15 17:25:59','2026-05-15 17:25:59'),(10,'0703','Endoskopi THT','Tindakan Medis',500000.00,1,'2026-05-15 17:26:59','2026-05-15 17:26:59'),(11,'0704','Tes Pendengaran (Audiometri)','Pemeriksaan Lab',350000.00,1,'2026-05-15 17:27:38','2026-05-15 17:27:38'),(12,'0705','Pengambilan Benda Asing','Tindakan Medis',400000.00,1,'2026-05-15 17:28:05','2026-05-15 17:28:05'),(13,'0706','Irigasi Telinga','Tindakan Medis',200000.00,1,'2026-05-15 17:28:28','2026-05-15 17:28:28'),(14,'0707','Kauterisasi Hidung (Penanganan Mimisan)','Tindakan Medis',300000.00,1,'2026-05-15 17:29:19','2026-05-15 17:29:19'),(15,'0708','Operasi Amandel (Tonsilektomi)','Tindakan Medis',7500000.00,1,'2026-05-15 17:29:53','2026-05-15 17:29:53'),(16,'0601','Konsultasi Spesialis Mata','Konsultasi',250000.00,1,'2026-05-16 06:44:22','2026-05-16 06:44:22'),(17,'0602','Pemeriksaan Refraksi (Minus/Plus/Silinder0','Tindakan Medis',1000000.00,1,'2026-05-16 06:45:37','2026-05-16 06:45:37'),(18,'0603','Cek Tekanan Bola Mata','Tindakan Medis',150000.00,1,'2026-05-16 06:46:15','2026-05-16 06:46:15'),(19,'0604','Pemeriksaan Saraf Retina','Tindakan Medis',250000.00,1,'2026-05-16 06:46:47','2026-05-16 06:46:47'),(20,'0605','Tes Buta Warna','Tindakan Medis',75000.00,1,'2026-05-16 06:47:15','2026-05-16 06:47:15'),(21,'0606','Pengambilan Benda Asing','Tindakan Medis',300000.00,1,'2026-05-16 06:48:06','2026-05-16 06:48:06'),(22,'0607','Operasi Pterigium (Selaput Mata)','Tindakan Medis',3500000.00,1,'2026-05-16 06:48:45','2026-05-16 06:48:45'),(23,'0608','Operasi Katarak','Tindakan Medis',8500000.00,1,'2026-05-16 06:49:29','2026-05-16 06:49:29'),(24,'0201','Konsultasi Spesialis Anak','Konsultasi',250000.00,1,'2026-05-16 06:51:55','2026-05-16 06:51:55'),(25,'0202','Pemeriksaan Tumbuh Kembang','Lainnya',300000.00,1,'2026-05-16 06:52:47','2026-05-16 06:52:47'),(26,'0203','Imunisasi Anak (BCG/Polio/DPT/Campak)','Tindakan Medis',200000.00,1,'2026-05-16 06:53:39','2026-05-16 06:53:39'),(27,'0204','Imunisasi Pilihan (PCV/Rotavirus/Influenza)','Tindakan Medis',850000.00,1,'2026-05-16 06:54:33','2026-05-16 06:54:33'),(28,'0205','Terapi Uap (Nebulizer)','Lainnya',150000.00,1,'2026-05-16 06:55:25','2026-05-16 06:55:25'),(29,'0206','Tindik Telinga Bayi ','Tindakan Medis',100000.00,1,'2026-05-16 06:55:54','2026-05-16 06:56:09'),(30,'0207','Skrinning Bayi Baru Lahir','Lainnya',450000.00,1,'2026-05-16 06:56:39','2026-05-16 06:56:39'),(31,'0208','Konsultasi Nutrisi dan Laktasi','Konsultasi',250000.00,1,'2026-05-16 06:57:08','2026-05-16 06:57:08'),(32,'0401','Konsultasi Spesialis Kandungan','Konsultasi',300000.00,1,'2026-05-16 06:58:28','2026-05-16 06:58:28'),(33,'0402','USG 2D & Konsultasi Kehamilan','Lainnya',450000.00,1,'2026-05-16 06:59:46','2026-05-16 06:59:46'),(34,'0403','USG 4D (Screening Detail)','Lainnya',800000.00,1,'2026-05-16 07:00:45','2026-05-16 07:00:45'),(35,'0404','Pap Smear (Deteksi Kanker Serviks)','Tindakan Medis',350000.00,1,'2026-05-16 07:01:29','2026-05-16 07:01:29'),(36,'0405','Pemasangan/Pelepasan KB IUD','Tindakan Medis',600000.00,1,'2026-05-16 07:01:51','2026-05-16 07:01:51'),(37,'0406','Imunisasi HPV (Kanker Serviks)','Tindakan Medis',1200000.00,1,'2026-05-16 07:02:18','2026-05-16 07:02:18'),(38,'0407','Paket Persalinan Normal (Tanpa Komplikasi)','Lainnya',12000000.00,1,'2026-05-16 07:02:55','2026-05-16 07:02:55'),(39,'0408','Paket Persalinan Caesar (SC)','Lainnya',25000000.00,1,'2026-05-16 07:03:23','2026-05-16 07:03:23'),(40,'0501','Konsultasi Spesialis Penyakit Dalam','Konsultasi',250000.00,1,'2026-05-16 07:04:10','2026-05-16 07:04:10'),(41,'0502','EKG (Elektrokardiogram) / Rekam Jantung','Tindakan Medis',150000.00,1,'2026-05-16 07:04:44','2026-05-16 07:04:44'),(42,'0503','USG Abdomen (Pemeriksaan Organ Dalam Perut)','Lainnya',500000.00,1,'2026-05-16 07:05:14','2026-05-16 07:05:14'),(43,'0504','Endoskopi Saluran Cerna Atas (Gastroskopi)','Lainnya',2500000.00,1,'2026-05-16 07:05:39','2026-05-16 07:05:39'),(44,'0505','Kolonoskopi (Pemeriksaan Usus Besar)','Lainnya',3000000.00,1,'2026-05-16 07:06:12','2026-05-16 07:06:12'),(45,'0506','Spirometri (Tes Fungsi Paru)','Lainnya',350000.00,1,'2026-05-16 07:06:42','2026-05-16 07:06:42'),(46,'0507','Edukasi & Injeksi Insulin (Diabetes','Lainnya',150000.00,1,'2026-05-16 07:07:07','2026-05-16 07:07:07'),(47,'0508','Vaksinasi Dewasa (Influenza / Pneumonia)','Tindakan Medis',600000.00,1,'2026-05-16 07:07:35','2026-05-16 07:07:35'),(48,'0101','Konsultasi Dokter Umum','Konsultasi',50000.00,1,'2026-05-16 07:53:45','2026-05-16 07:54:40');
/*!40000 ALTER TABLE `layanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-05-14-080531','App\\Database\\Migrations\\SetupDatabase','default','App',1778746885,1),(2,'2026-05-17-102351','App\\Database\\Migrations\\AddNoTagihanToPembayaran','default','App',1779013454,2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obat`
--

DROP TABLE IF EXISTS `obat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_obat` varchar(20) DEFAULT NULL,
  `nama_obat` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `dosis` varchar(50) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `expired` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_obat` (`kd_obat`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obat`
--

LOCK TABLES `obat` WRITE;
/*!40000 ALTER TABLE `obat` DISABLE KEYS */;
INSERT INTO `obat` VALUES (1,'KAPS-001','Amoxicillin','Kapsul','500mg','Strip',15000.00,98,'2027-12-31'),(2,'KAPS-002','Omeprazole','Kapsul','20mg','Strip',25000.00,50,'2028-06-30'),(3,'KAPS-003','Loperamide','Kapsul','2mg','Strip',10000.00,75,'2027-10-15'),(4,'TAB-001','Paracetamol','Tablet','500mg','Strip',5000.00,199,'2028-01-01'),(5,'TAB-002','Amlodipine','Tablet','10mg','Strip',12000.00,149,'2027-08-20'),(6,'TAB-003','Metformin','Tablet','500mg','Strip',18000.00,120,'2029-02-28'),(7,'SYR-001','Sanmol','Sirup','120mg/5ml','Botol',20000.00,39,'2027-05-10'),(8,'SYR-002','Ambroxol','Sirup','15mg/5ml','Botol',18000.00,60,'2028-03-12'),(9,'SYR-003','Ibuprofen','Sirup','100mg/5ml','Botol',25000.00,34,'2027-11-30'),(10,'SLP-001','Ketoconazole Cream','Salep','2%','Tube',15000.00,49,'2028-09-01'),(11,'SLP-002','Hydrocortisone Cream','Salep','2.5%','Tube',12000.00,45,'2027-07-15'),(12,'SLP-003','Gentamicin Ointment','Salep','0.1%','Tube',10000.00,60,'2029-01-20'),(13,'INJ-001','Ceftriaxone','Injeksi','1g','Vial',50000.00,80,'2028-12-31'),(14,'INJ-002','Ondansetron','Injeksi','4mg/2ml','Ampul',35000.00,99,'2027-04-30'),(15,'INJ-003','Dexamethasone','Injeksi','5mg/ml','Ampul',15000.00,150,'2028-10-10');
/*!40000 ALTER TABLE `obat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pasien`
--

DROP TABLE IF EXISTS `pasien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pasien`
--

LOCK TABLES `pasien` WRITE;
/*!40000 ALTER TABLE `pasien` DISABLE KEYS */;
INSERT INTO `pasien` VALUES (1,'1234567890','Yolo','L','2026-05-01','dasfafesaf','3141414'),(2,'3171010101900001','Budi Santoso','L','1990-01-15','Jl. Condet Raya No. 15, Jakarta Timur','081234567001'),(3,'3276020202920002','Siti Aminah','P','1992-02-20','Jl. Margonda Raya No. 88, Depok','081345678002'),(4,'3174030303850003','Andi Wijaya','L','1985-03-10','Jl. Tebet Barat Dalam No. 12, Jakarta Selatan','081456789003'),(5,'3171040404880004','Rina Melati','P','1988-04-05','Jl. Raya Bogor KM 28, Jakarta Timur','081567890004'),(6,'3174050505750005','Joko Anwar','L','1975-05-25','Jl. Kemang Raya No. 45, Jakarta Selatan','081678901005'),(7,'3276060606950006','Dewi Lestari','P','1995-06-30','Jl. Nusantara Raya No. 10, Depok','081789012006'),(8,'3171070707820007','Hendra Setiawan','L','1982-07-12','Jl. Pemuda No. 70, Rawamangun, Jakarta Timur','081890123007'),(9,'3174080808980008','Ayu Tingting','P','1998-08-18','Jl. Fatmawati No. 33, Jakarta Selatan','081901234008'),(10,'3276090909910009','Eko Patrio','L','1991-09-09','Jl. Akses UI No. 99, Kelapa Dua, Depok','082012345009'),(11,'3171101010890010','Maya Septha','P','1989-10-22','Jl. Kalimalang Raya No. 5, Jakarta Timur','082123456010'),(12,'3174111111770011','Rudi Salim','L','1977-11-11','Jl. Senopati No. 22, Jakarta Selatan','082234567011'),(13,'3276121212940012','Nina Zatulini','P','1994-12-01','Jl. Siliwangi No. 44, Pancoran Mas, Depok','082345678012'),(14,'3171131313860013','Dwi Sasono','L','1986-01-13','Jl. Dewi Sartika No. 11, Cawang, Jakarta Timur','082456789013'),(15,'3174141414990014','Sari Roti','P','1999-02-14','Jl. Panglima Polim No. 7, Jakarta Selatan','082567890014'),(16,'3276151515830015','Tono Supartono','L','1983-03-15','Jl. Cinere Raya No. 21, Limo, Depok','082678901015'),(17,'123456788','Dika','L','2005-01-01','dafaefaefe','087812345678'),(18,'1213455666','rofi satu','L','2013-06-04','adjbkfnasjf','087811223344');
/*!40000 ALTER TABLE `pasien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawai` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_poli` int DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `spesialisasi` varchar(100) DEFAULT NULL,
  `nomor_telp` varchar(20) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `id_poli` (`id_poli`),
  CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `poliklinik` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES (1,NULL,'kaisar','','kaisar','$2y$10$Ew9i9ED9iDJltbxvS6dZleD2UVxsDX9yEY71v90NYCK7uepMhg5n6','a64b898cf87a9a44c4421d971494a557e15a7425acba136c74366b3d2aec4274',1,'','123456','Admin'),(2,NULL,'ages',NULL,'ages','$2y$10$Gm/cpM8xlyKCvnmfE2Kl1eaTJtmOwPevUk5PZ1cPwQZDA4KgRKWF6',NULL,1,NULL,'11111','Dokter'),(3,10,'qeurio','adsada','querio','$2y$10$cSKNZFEKKBqKFhukpd5mP..fw/DyI4aT30PHUBl.vBj9UqKftRkEy',NULL,1,'mata','087844338679','Dokter'),(5,NULL,'kaisar kasir','Jalan2','kaisar_kasir','$2y$10$xeA/wZvbKKzU7BRM0wwNpu.FmDI4FQjUkWNK3QiqcHmraVjeBkXmy',NULL,1,NULL,'08123456789','Kasir'),(6,NULL,'kaisar suster','Jalan Bakti','kaisar_suster','$2y$10$sPrKZ5STb7uj5ppDM3eSbu7EBdMnXTJ0XHtAHnVPNKxSEIEqalAKq',NULL,1,NULL,'087844338679','Perawat'),(7,1,'kaisar_dokter','Jalan dokter kaisar','kaisar_dokter','$2y$10$iHT7cC7FWtZeghXoZyqgx.T7Z4S0no8Nd3mmbrpPSTxpAj/KgSppW',NULL,1,'umum','087844338679','Dokter');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int DEFAULT NULL,
  `no_tagihan` varchar(50) DEFAULT NULL,
  `id_pegawai` int DEFAULT NULL,
  `tgl_bayar` datetime DEFAULT CURRENT_TIMESTAMP,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `total_bayar` decimal(10,2) DEFAULT NULL,
  `status_pembayaran` enum('Belum Lunas','Lunas','Batal') DEFAULT 'Belum Lunas',
  PRIMARY KEY (`id`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_pegawai` (`id_pegawai`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran`
--

LOCK TABLES `pembayaran` WRITE;
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
INSERT INTO `pembayaran` VALUES (1,3,'INV-20260517102856',1,'2026-05-17 10:28:00','Tunai',1600000.00,'Lunas'),(2,3,'INV-20260517102856',1,'2026-05-17 10:28:00','Tunai',1600000.00,'Lunas'),(3,4,'INV-20260517105915',1,'2026-05-17 10:59:00','Tunai',0.00,'Lunas'),(4,5,'INV-20260517110836',1,'2026-05-17 11:08:00','Tunai',5005000.00,'Lunas'),(5,6,'INV-20260518153947',1,'2026-05-18 15:39:00','QRIS',25235000.00,'Lunas'),(6,10,'INV-20260519160402',1,'2026-05-19 16:04:00','Tunai',312000.00,'Lunas'),(7,11,'INV-20260609025512',1,'2026-06-09 02:55:00','QRIS',220000.00,'Lunas'),(8,12,'INV-20260625044211',1,'2026-06-25 04:42:00','Kartu Debit/Kredit',65000.00,'Lunas'),(9,13,'INV-20260625044804',1,'2026-06-25 04:48:00','Tunai',65000.00,'Lunas');
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran`
--

DROP TABLE IF EXISTS `pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_pendaftaran` varchar(50) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `id_poli` int unsigned DEFAULT NULL,
  `keluhan_awal` text,
  `tgl_daftar` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Antri','Diperiksa','Selesai','Batal') DEFAULT 'Antri',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_pendaftaran` (`no_pendaftaran`),
  KEY `id_pasien` (`id_pasien`),
  CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
INSERT INTO `pendaftaran` VALUES (1,'REG-20260515-4493',1,NULL,NULL,'2026-05-15 22:21:42','Selesai'),(3,'REG-20260516-6185',2,1,'Batuk','2026-05-16 07:50:56','Selesai'),(4,'REG-20260517-7835',3,4,'nyeri gusi\r\n','2026-05-17 10:57:07','Selesai'),(5,'REG-20260517-6262',4,5,'gigi tidak rapi','2026-05-17 11:05:17','Selesai'),(6,'REG-20260518-1635',17,8,'bayi 12 bulan ga lahir\r\n','2026-05-18 15:36:55','Selesai'),(7,'REG-20260519-8476',7,1,'batuk\r\n','2026-05-19 02:58:45','Selesai'),(8,'REG-20260519-4892',2,1,'ijjojnin','2026-05-19 15:52:34','Selesai'),(9,'REG-20260519-8877',17,4,'kokokokok','2026-05-19 15:55:18','Selesai'),(10,'REG-20260519-8389',12,9,'ksokdokaof','2026-05-19 15:58:37','Selesai'),(11,'REG-20260609-3986',18,4,'gusi berdarah\r\n','2026-06-09 02:53:17','Selesai'),(12,'REG-20260625-8375',4,1,'sakit perut','2026-06-25 04:40:32','Selesai'),(13,'REG-20260625-1181',17,8,'sakit gigi','2026-06-25 04:46:14','Selesai'),(14,'REG-20260625-1966',6,9,'nyeri bagian belakang punggung\r\n','2026-06-25 04:50:41','Antri');
/*!40000 ALTER TABLE `pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poliklinik`
--

DROP TABLE IF EXISTS `poliklinik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poliklinik` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_poli` varchar(100) DEFAULT NULL,
  `daftar_spesialisasi` varchar(30) DEFAULT NULL,
  `kode_poli` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poliklinik`
--

LOCK TABLES `poliklinik` WRITE;
/*!40000 ALTER TABLE `poliklinik` DISABLE KEYS */;
INSERT INTO `poliklinik` VALUES (1,'umum','umum','111'),(2,'anak','pediatri','122'),(3,'anak','bedah anak','123'),(4,'gigi','umum','131'),(5,'gigi','ortodoti','132'),(6,'gigi','bedah mulut ','133'),(7,'gigi','konservasi mulut gigi','134'),(8,'kandungan','kebidanan dan kandungan','141'),(9,'penyakit dalam ','penyakit dalam (internis)','151'),(10,'mata','mata','161'),(11,'tht','tht','171');
/*!40000 ALTER TABLE `poliklinik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekam_medis`
--

DROP TABLE IF EXISTS `rekam_medis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekam_medis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kd_rekam_medis` varchar(50) DEFAULT NULL,
  `id_pendaftaran` int DEFAULT NULL,
  `id_pegawai` int DEFAULT NULL,
  `tanggal_periksa` date DEFAULT NULL,
  `keluhan` text,
  `diagnosa` text,
  `tindakan_medis` text,
  `tekanan_darah` varchar(20) DEFAULT NULL,
  `file` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_rekam_medis` (`kd_rekam_medis`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_pegawai` (`id_pegawai`),
  CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rekam_medis_ibfk_2` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekam_medis`
--

LOCK TABLES `rekam_medis` WRITE;
/*!40000 ALTER TABLE `rekam_medis` DISABLE KEYS */;
INSERT INTO `rekam_medis` VALUES (1,'RM-20260515-644',1,3,'2026-05-15','ffF','dfdF','dFdF','120/80',NULL),(2,'RM-20260515-578',1,2,'2026-05-15','agga','agag','gaga','gag',NULL),(3,'RM-20260516-344',3,3,'2026-05-16','batuk','infeksi saluran pernapasan','kasih obat','120',NULL),(4,'RM-20260517-690',4,7,'2026-05-17','nyeri  gusi','adalah pokoknya','yang tau tau aja','120/80','1779015491_152614776e4ee847d2bf.pdf'),(5,'RM-20260517-248',5,7,'2026-05-17','gigi tidak rapi','gigi bawah maju ke depan','pemasangan behel','120/4',NULL),(6,'RM-20260518-893',6,7,'2026-05-18','gdshsdh','dagdgsag','vzdfdg','235/10000',NULL),(7,'RM-20260519-881',7,7,'2026-05-19','batuk','radang','kasih obat xxxxx','120/30',NULL),(8,'RM-20260519-265',8,7,'2026-05-19','ijjojnin','jiojoiji','jninijn','11/11',NULL),(9,'RM-20260519-600',9,3,'2026-05-19','kokokokok','jnninj','jnjnijn','120/30',NULL),(10,'RM-20260519-214',10,7,'2026-05-19','ksokdokaof','janggal','dfafdaf','120/212',NULL);
/*!40000 ALTER TABLE `rekam_medis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi_kamar`
--

DROP TABLE IF EXISTS `transaksi_kamar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi_kamar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int DEFAULT NULL,
  `id_kamar` int DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `total_biaya` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Dirawat',
  PRIMARY KEY (`id`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_kamar` (`id_kamar`),
  CONSTRAINT `transaksi_kamar_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_kamar_ibfk_2` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_kamar`
--

LOCK TABLES `transaksi_kamar` WRITE;
/*!40000 ALTER TABLE `transaksi_kamar` DISABLE KEYS */;
INSERT INTO `transaksi_kamar` VALUES (1,3,1,'2026-05-16','2026-06-25',60000000.00,'Pulang'),(2,6,10,'2026-05-18','2026-06-25',7600000.00,'Pulang'),(3,10,10,'2026-05-19','2026-06-25',7400000.00,'Pulang');
/*!40000 ALTER TABLE `transaksi_kamar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi_layanan`
--

DROP TABLE IF EXISTS `transaksi_layanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi_layanan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int DEFAULT NULL,
  `id_layanan` int DEFAULT NULL,
  `qty` int DEFAULT '1',
  `total_harga` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_layanan` (`id_layanan`),
  CONSTRAINT `transaksi_layanan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_layanan_ibfk_2` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_layanan`
--

LOCK TABLES `transaksi_layanan` WRITE;
/*!40000 ALTER TABLE `transaksi_layanan` DISABLE KEYS */;
INSERT INTO `transaksi_layanan` VALUES (1,1,1,1,350000.00),(2,3,48,1,50000.00),(3,3,48,1,50000.00),(4,4,6,1,600000.00),(5,5,4,1,5000000.00),(6,6,39,1,25000000.00),(7,10,29,1,100000.00),(8,11,5,1,200000.00),(9,12,48,1,50000.00),(10,13,48,1,50000.00);
/*!40000 ALTER TABLE `transaksi_layanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi_obat`
--

DROP TABLE IF EXISTS `transaksi_obat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi_obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int DEFAULT NULL,
  `id_obat` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `aturan_pakai` varchar(100) DEFAULT NULL,
  `tagihan_obat` decimal(10,2) DEFAULT NULL,
  `tgl_transaksi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_obat` (`id_obat`),
  CONSTRAINT `transaksi_obat_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_obat_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_obat`
--

LOCK TABLES `transaksi_obat` WRITE;
/*!40000 ALTER TABLE `transaksi_obat` DISABLE KEYS */;
INSERT INTO `transaksi_obat` VALUES (1,3,NULL,NULL,NULL,NULL,'2026-05-16 16:26:23'),(2,3,NULL,NULL,NULL,NULL,'2026-05-16 16:34:47'),(3,4,NULL,NULL,NULL,NULL,'2026-05-17 17:59:09'),(4,4,NULL,NULL,NULL,NULL,'2026-05-17 18:00:54'),(5,4,1,1,'3x1',15000.00,'2026-05-17 18:04:33'),(6,5,4,1,'3x1',5000.00,'2026-05-17 18:08:19'),(7,6,14,1,'1x1',35000.00,'2026-05-18 22:38:30'),(8,7,9,1,'3x1',25000.00,'2026-05-19 10:02:20'),(9,10,5,1,'1x1',12000.00,'2026-05-19 23:03:33'),(10,11,7,1,'3x1',20000.00,'2026-06-09 09:54:56'),(11,12,1,1,'3x1',15000.00,'2026-06-25 11:42:00'),(12,13,10,1,'3x1',15000.00,'2026-06-25 11:47:56');
/*!40000 ALTER TABLE `transaksi_obat` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-27 20:45:12
