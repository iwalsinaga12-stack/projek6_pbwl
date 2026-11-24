# Project 6 - Sistem Akademik (PHP MVC)

Aplikasi web pengelolaan data akademik: **Mahasiswa, Dosen, dan Mata Kuliah**, lengkap dengan dashboard ringkasan.
Dibangun dengan PHP Native (pola MVC), MySQL + PDO, dan Bootstrap 5.

## Fitur

- **Dashboard**: total mahasiswa, dosen, mata kuliah, total SKS, mata kuliah per semester, dosen per golongan, dan 5 mahasiswa terbaru. Semua angka dihitung langsung dari database.
- **CRUD Mahasiswa, Dosen, Mata Kuliah**: tampil, tambah, edit, hapus, dan cari.
- Validasi input (di server) dengan pesan per kolom, isian lama tidak hilang saat ada error.
- Notifikasi berhasil/gagal (Bootstrap alert) dan dialog konfirmasi sebelum menghapus.
- Tampilan responsif: sidebar + navbar, nyaman di laptop dan HP.

## Kebutuhan

- XAMPP dengan **PHP 7.4 atau lebih baru** (PHP 8.x juga bisa), Apache, dan MySQL/MariaDB.
- Modul Apache `mod_rewrite` aktif (sudah aktif di XAMPP bawaan).

## Cara Instalasi (XAMPP)

1. **Ekstrak** ZIP, sehingga ada folder `project6`. Pindahkan ke `C:\xampp\htdocs\`  
   Hasilnya: `C:\xampp\htdocs\project6\index.php`.
2. Buka **XAMPP Control Panel**, klik **Start** pada **Apache** dan **MySQL**.
3. Buka `http://localhost/phpmyadmin`, lalu:
   1. Klik tab **Import**, pilih file `database.sql`, klik **Kirim**. Database `db_project6_si2` beserta 3 tabelnya akan dibuat otomatis.
   2. *(Opsional)* Import juga `data_contoh.sql` agar langsung ada data untuk dicoba. Lewati langkah ini jika ingin database kosong.
4. Buka **`http://localhost/project6`** di browser.
   Halaman awal adalah beranda tamu. Klik **Dashboard** atau buka `http://localhost/project6/dashboard`.

Jika pengaturan MySQL berbeda (misalnya root memakai password), ubah di **`inc/config.php`**:

```php
define("DB_HOST", "localhost");
define("DB_NAME", "db_project6_si2");
define("DB_USER", "root");
define("DB_PASS", "");
```

Alamat aplikasi (`URL`) dideteksi otomatis, jadi folder boleh diberi nama lain dan tetap berjalan.

## Struktur Folder

```
project6/
|-- index.php                  titik masuk aplikasi
|-- .htaccess                  rewrite URL ke index.php?page=...
|-- database.sql               struktur database (aman diimpor berulang)
|-- data_contoh.sql            data contoh (opsional)
|-- inc/config.php             konfigurasi: database, URL, session, autoload
|-- app/
|   |-- core/                  Bootstrap (router), Controller, CrudController,
|   |                          Model, Error, helpers.php
|   |-- controllers/           Index, Dashboard, Mahasiswa, Dosen, Matakuliah
|   |-- models/                Dashboard, Mahasiswa, Dosen, Matakuliah
|   `-- views/                 dashboard, mahasiswa, dosen, matakuliah,
|                              partials, error, index
|-- layouts/                   dashboard.php, guest.php, assets (css, js, bootstrap)
`-- vendor/                    autoload Composer + Whoops
```

## Daftar Alamat (Routing)

Pola: `/controller/method/parameter`

| Alamat | Fungsi |
|---|---|
| `/dashboard` | Dashboard ringkasan |
| `/mahasiswa` , `/mahasiswa?q=kata` | Daftar dan pencarian |
| `/mahasiswa/input` | Form tambah |
| `/mahasiswa/simpan` (POST) | Proses tambah |
| `/mahasiswa/edit/{id}` | Form edit |
| `/mahasiswa/update` (POST) | Proses edit |
| `/mahasiswa/delete/{id}` (POST) | Proses hapus |

`/dosen/...` dan `/matakuliah/...` memakai pola yang sama.

## Keamanan yang Diterapkan

- Semua query memakai **PDO prepared statements** (native, bukan emulasi). Karakter `%` dan `_` pada pencarian diperlakukan sebagai teks biasa.
- Semua output di view memakai **`htmlspecialchars`** lewat fungsi `e()`.
- **Token CSRF** pada setiap form tambah, edit, dan hapus.
- Tambah, edit, dan hapus hanya bisa lewat **POST**. Membuka `/mahasiswa/delete/1` langsung dari browser (GET) ditolak.
- Router hanya mengizinkan method `public` milik controller. Method bawaan (`guest`, `dashboard`) dan alamat dengan jumlah parameter salah menghasilkan halaman 404, bukan error.
- Folder `app`, `inc`, `vendor` serta berkas `.sql`, `.md`, `.json` tidak dapat dibuka langsung lewat browser (Apache 2.4).
- Cookie session `HttpOnly` dan `SameSite=Lax`.

> **Mode debug.** `APP_DEBUG` di `inc/config.php` bernilai `true` agar pesan error (Whoops) membantu saat belajar. Jika aplikasi dipasang di server sungguhan, ubah ke `false`.

## Aturan Validasi

| Data | Aturan |
|---|---|
| NIM / NIP | wajib, maks. 25 karakter, huruf/angka/titik/tanda hubung, tidak boleh kembar |
| Nama mahasiswa / dosen | wajib, maks. 100 karakter, huruf, spasi, dan tanda `. , ' -` |
| Alamat | opsional, maks. 500 karakter |
| Golongan | opsional, maks. 100 karakter |
| Kode mata kuliah | wajib, maks. 25 karakter, huruf/angka/`. _ -`, tidak boleh kembar |
| Nama mata kuliah | wajib, maks. 100 karakter |
| SKS | wajib, angka 1 sampai 6 |
| Semester | wajib, angka 1 sampai 14 |

## Perubahan dari Proyek Awal

- `Mahasiswa` yang semula berupa contoh dilengkapi menjadi CRUD penuh; `Dosen`, `Matakuliah`, dan `Dashboard` dibuat baru dengan struktur MVC yang sama.
- Alur CRUD yang sama dipusatkan di `app/core/CrudController.php` agar tiga controller tidak menulis kode berulang.
- `inc/config.php`: URL dideteksi otomatis, pengaturan database dipindah ke konstanta, session dimulai, dan mode debug dibuat bisa dimatikan.
- `app/core/Bootstrap.php`: logika routing tetap sama, ditambah pemeriksaan agar hanya method yang sah yang bisa dipanggil.
- `composer.json` dan autoload: ditambah pemetaan folder huruf kecil (`app/core`, `app/controllers`, `app/models`) agar aplikasi juga jalan di server Linux yang membedakan huruf besar/kecil.
- `database.sql`: nama database dan kolom **tidak berubah**. Yang ditambahkan hanya `CREATE DATABASE`, `IF NOT EXISTS`, dan `ENGINE`/charset. Struktur lama dengan tabel `tb_mhsw`, `tb_dosen`, `tb_matakuliah` tetap kompatibel.
- Halaman contoh `Index` (beranda tamu, `/index/show`, `/index/detail`) dipertahankan.

## Pemecahan Masalah

| Gejala | Penyebab dan solusi |
|---|---|
| Semua halaman selain beranda **404** | `mod_rewrite`/`.htaccess` tidak terbaca. Pastikan folder bernama benar dan berisi `.htaccess`, dan di `httpd.conf` XAMPP bagian `htdocs` memakai `AllowOverride All`. Restart Apache. |
| `Unknown database 'db_project6_si2'` | `database.sql` belum diimpor. Lihat langkah 3. |
| `Access denied for user 'root'` | Password MySQL berbeda. Samakan `DB_PASS` di `inc/config.php`. |
| Error `SQLSTATE[HY000] [2002]` | MySQL belum di-Start di XAMPP Control Panel. |
| Tampilan polos tanpa gaya | Folder `layouts/assets` tidak ikut terekstrak, atau alamat yang dibuka bukan `http://localhost/...`. |
| Muncul `Class "..." not found` di server Linux | Jalankan `composer dump-autoload` di folder proyek. |
| Muncul 500 setelah dipasang di hosting lama | Hosting harus PHP 7.4 atau lebih baru dan MySQL 5.7 atau lebih baru. Jika MySQL lama tidak mengenal `utf8mb4`, ganti `utf8mb4` menjadi `utf8` di `database.sql` dan `app/core/Model.php`. |

Panduan pengujian setiap fitur ada di **`PANDUAN_PENGUJIAN.md`**.
