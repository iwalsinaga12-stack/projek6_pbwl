# Panduan Pengujian Project 6 - Sistem Akademik

Lakukan setelah instalasi selesai (lihat `README.md`). Disarankan mengimpor `data_contoh.sql` terlebih dahulu.
Centang setiap baris jika hasilnya sesuai.

## 1. Koneksi database dan routing
- [ ] `http://localhost/project6` menampilkan beranda tamu.
- [ ] `/dashboard`, `/mahasiswa`, `/dosen`, `/matakuliah` terbuka tanpa error.
- [ ] `/halamanasal` menampilkan halaman **404** yang rapi.
- [ ] `/mahasiswa/edit/99999` menampilkan 404 (bukan error PHP).
- [ ] Matikan MySQL di XAMPP, muat ulang `/dashboard`: muncul pesan error koneksi. Nyalakan lagi MySQL, halaman normal kembali.

## 2. Dashboard
- [ ] Empat kartu (Mahasiswa, Dosen, Mata kuliah, Total SKS) sesuai isi tabel di phpMyAdmin. Dengan data contoh: **8, 5, 8, 24**.
- [ ] Klik kartu Mahasiswa, Dosen, dan Mata kuliah: pindah ke halaman masing-masing.
- [ ] Tombol **+ Mahasiswa / + Dosen / + Mata kuliah** membuka form tambah.
- [ ] Tambah satu mata kuliah baru (SKS 3), kembali ke dashboard: jumlah mata kuliah dan total SKS bertambah.
- [ ] Panel "Mata kuliah per semester", "Dosen per golongan", dan "Mahasiswa terbaru" berisi data yang sesuai.

## 3. CRUD Mahasiswa
- [ ] **Tambah**: isi NIM, nama, alamat, klik Simpan. Muncul notifikasi hijau "berhasil ditambahkan" dan data ada di tabel.
- [ ] **Edit**: klik Edit, ubah nama, Simpan. Muncul "berhasil diperbarui".
- [ ] **Hapus**: klik Hapus, muncul dialog konfirmasi berisi nama data. Klik **Batal**: data tetap ada. Klik Hapus lagi lalu **Hapus**: data hilang dan muncul "berhasil dihapus".
- [ ] **Cari**: ketik sebagian nama, NIM, atau alamat. Hanya data yang cocok tampil. Klik **Reset** untuk kembali.
- [ ] Pencarian tanpa hasil menampilkan pesan "Tidak ada mahasiswa yang cocok".

## 4. CRUD Dosen
- [ ] Tambah, edit, hapus (dengan dialog konfirmasi), dan cari berfungsi seperti Mahasiswa.
- [ ] Golongan boleh dikosongkan; di tabel tampil tanda `-`.

## 5. CRUD Mata Kuliah
- [ ] Tambah, edit, hapus (dengan dialog konfirmasi), dan cari (kode atau nama) berfungsi.
- [ ] Data terurut berdasarkan semester lalu kode.

## 6. Validasi form
Kolom wajib juga dijaga oleh browser (tanda `*`), sehingga pesan "wajib diisi" dari server sulit dipicu lewat tampilan biasa.
Fokuskan pengujian pada aturan di bawah; pesan "wajib diisi" dari server sudah diuji otomatis.

- [ ] Kosongkan kolom wajib lalu klik Simpan: browser menahan pengiriman dan menandai kolom yang kosong.
- [ ] NIM/NIP yang sudah ada: pesan "sudah terdaftar". Edit data dengan NIM miliknya sendiri **tidak** dianggap kembar.
- [ ] Nama berisi angka atau tanda `<` ditolak.
- [ ] SKS 0, 7, atau huruf ditolak. Semester 0 atau 15 ditolak.
- [ ] Saat ada error, isian lain yang sudah diketik tidak hilang.

## 7. Navigasi dan tombol
- [ ] Setiap menu di sidebar mengarah ke halaman yang benar dan menu aktif ditandai.
- [ ] Tombol **Batal** pada form kembali ke daftar.
- [ ] Tidak ada tombol atau tautan yang tidak berfungsi.

## 8. Tampilan responsif
- [ ] Di browser tekan `F12`, aktifkan mode perangkat (Ctrl+Shift+M), pilih lebar sekitar 390 px.
- [ ] Menu sidebar tersembunyi; tombol ☰ membukanya, klik area gelap menutupnya.
- [ ] Tidak ada halaman yang bergeser ke samping. Tabel yang lebar dapat digeser di dalam kotaknya.
- [ ] Kartu dashboard tersusun 2 kolom dan semua teks terbaca.

## 9. Keamanan dasar
- [ ] Buka `http://localhost/project6/mahasiswa/delete/1` langsung di browser: ditolak dengan pesan merah, data **tidak** terhapus.
- [ ] Isi alamat mahasiswa dengan `<script>alert(1)</script>`, simpan: teks tampil apa adanya dan **tidak** muncul kotak peringatan.
- [ ] Cari dengan kata kunci `' OR 1=1 --`: tidak ada error, hasil kosong.
- [ ] Buka `http://localhost/project6/database.sql` dan `.../app/core/Model.php`: ditolak (403).

## Hasil pengujian otomatis saat pembuatan

Pengujian berikut sudah dijalankan pada PHP 8.3 + MariaDB 10.11 menggunakan server bawaan PHP: 147 pemeriksaan
(routing, dashboard, pencarian, CRUD tiga modul, validasi, CSRF, XSS, SQL injection, kondisi data kosong), semuanya lulus.
Tampilan desktop dan HP (lebar 390 px) diperiksa dengan Chromium. Yang **belum** diuji di lingkungan pembuatan: Apache XAMPP
sungguhan (khususnya `.htaccess`) dan Windows, sehingga langkah 1 dan 9 di atas tetap perlu Anda cek sendiri.
