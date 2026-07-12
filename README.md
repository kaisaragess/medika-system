# 🚀 Tutorial: Cara Fork & Menjalankan MedikaSistem di Localhost
Halo semuanya! 👋 Jika kalian tertarik untuk mempelajari struktur kode aplikasi manajemen klinik/rumah sakit ini, atau bahkan ingin ikut berkontribusi mengembangkannya, kalian bisa menjalankan project MedikaSistem ini di laptop atau PC kalian masing-masing.

Berikut adalah langkah-langkah step-by-step untuk mem-fork dan menjalankannya di localhost!

## 🛠️ Persiapan Awal (Prerequisites)
Sebelum mulai, pastikan di laptop/PC kamu sudah ter-install:

- XAMPP / Laragon (Pastikan versi PHP minimal 8.1, direkomendasikan PHP 8.2).

- Composer (Untuk mengelola dependency PHP).

- Git (Untuk mempermudah proses cloning repositori).

## Langkah 1: Fork Repository Ini
Forking berarti kamu membuat salinan (copy) dari project ini ke dalam akun GitHub-mu sendiri agar kamu bisa bereksperimen dengan bebas.

Scroll ke bagian paling atas halaman repository ini.

Di pojok kanan atas, klik tombol **"Fork"**.

Ikuti instruksi dari GitHub untuk menyimpan repository ini ke akunmu.

## Langkah 2: Clone ke Komputer Lokal
Setelah berhasil di-fork, sekarang saatnya mengunduh kodenya ke komputermu.

Buka folder htdocs (jika pakai XAMPP) atau www (jika pakai Laragon).

Klik kanan di dalam folder tersebut, lalu pilih "Open Git Bash here" atau buka Terminal/CMD.

Ketikkan perintah berikut (jangan lupa ganti USERNAME_KAMU dengan username GitHub-mu):

```
Bash
git clone https://github.com/USERNAME_KAMU/medika_system.git
```

Masuk ke dalam folder project-nya:

```
Bash
cd medika_system
```

## Langkah 3: Install Dependencies (Composer)
Karena CodeIgniter 4 menggunakan beberapa pustaka pihak ketiga, kita harus mengunduhnya dulu melalui Composer. Di dalam terminal yang sama, jalankan:

```
Bash
composer install
```
Tunggu hingga proses unduhan selesai.

## Langkah 4: Konfigurasi Environment (.env)
Kita perlu memberi tahu aplikasi ini cara terhubung ke database di laptopmu.

Buka folder medika_system menggunakan code editor (seperti VS Code).

Cari file bernama env (tanpa titik di depannya), lalu rename atau ubah namanya menjadi .env (tambahkan titik di depan).

Buka file .env tersebut, cari baris kode ini, dan hilangkan tanda pagar (#) di depannya agar aktif:

Ini, 
```
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = medika_system
database.default.username = root 
database.default.password = 
database.default.DBDriver = MySQLi
```
(Catatan: Sesuaikan username dan password. Jika phpMyAdmin-mu menggunakan password, isi bagian password = )


## Langkah 5: Buat Database
Nyalakan Apache dan MySQL di XAMPP.

Buka browser dan masuk ke http://localhost/phpmyadmin/.

Buat database baru dengan nama: medika_system.

**Cara Import Database (dari file zip):**
1. Cari file bernama `medika_system_data_schema_table.zip` di dalam folder project ini.
2. Ekstrak (unzip) file `medika_system_data_schema_table.zip` tersebut. Kamu akan mendapatkan folder `medika_system_data_schema_table` yang berisi beberapa file `.sql` (skema dan data tabel).
3. Di phpMyAdmin, pastikan kamu sudah memilih (klik) database `medika_system` yang baru saja dibuat.
4. Klik tab **Import**.
5. Klik **Choose File** (Pilih File) dan upload file-file `.sql` yang ada di dalam folder hasil ekstraksi tersebut secara berurutan.

*(Tips Cepat: Karena file terpisah per tabel, kamu bisa menggabungkan semua file `.sql` tersebut menjadi satu file terlebih dahulu jika tidak ingin meng-import satu per satu. Buka Terminal/CMD di dalam folder hasil ekstraksi, lalu jalankan perintah `copy /b *.sql gabungan_tabel.sql` (Windows CMD) atau `cat *.sql > gabungan_tabel.sql` (Git Bash). Setelah itu, kamu cukup meng-import file `gabungan_tabel.sql` tersebut ke phpMyAdmin).*

## Langkah 6: Jalankan Aplikasi! 🎉
Semuanya sudah siap! Sekarang kita tinggal menyalakan server lokal bawaan CodeIgniter.
Di terminal/CMD, ketik:

```
Bash
php spark serve
```
Buka browser kamu dan ketikkan alamat: http://localhost:8080.

Selamat! Aplikasi MedikaSistem sekarang sudah berjalan sempurna di komputermu. Silakan telusuri kodenya, pelajari alur transaksinya, dan selamat berkreasi!

# Catatan!
**Kamu harus ada akun sebagai admin dengan cara manual input query atau GUI di phpmyadmin**
# 💡 Ingin Berkontribusi?
Jika kamu menambahkan fitur baru, memperbaiki bug, atau merapikan UI, jangan ragu untuk melakukan Pull Request kembali ke repository utama ini! Mari belajar dan berkembang bersama.
