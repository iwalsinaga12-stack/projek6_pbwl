-- ============================================================
-- Project 6 - Sistem Akademik
-- DATA CONTOH (opsional) untuk mencoba dashboard, pencarian, dan CRUD.
-- Impor SETELAH database.sql. Aman diimpor berulang (data kembar dilewati).
-- ============================================================

USE db_project6_si2;

INSERT IGNORE INTO tb_mhsw (mhsw_nim, mhsw_nama, mhsw_alamat) VALUES
('0702241001', 'Iwal Kurniawan Sinaga', 'Jl. Williem Iskandar No. 12, Medan'),
('0702241002', 'Siti Nurhaliza', 'Jl. Sisingamangaraja No. 45, Medan'),
('0702241003', 'Budi Santoso', 'Jl. Gatot Subroto No. 7, Medan'),
('0702241004', 'Dewi Lestari', 'Jl. Balai Kota No. 3, Tanjungbalai'),
('0702241005', 'Rizky Ramadhan', NULL),
('0702241006', 'Putri Anggraini', 'Jl. Imam Bonjol No. 21, Binjai'),
('0702241007', 'Muhammad Iqbal', 'Jl. Setia Budi No. 88, Medan'),
('0702241008', 'Nadia Kusuma', 'Jl. Karya Wisata No. 5, Medan');

INSERT IGNORE INTO tb_dosen (dosen_nip, dosen_nama, dosen_golongan) VALUES
('198501012010011001', 'Dr. Ahmad Syarif, M.Kom.', 'III/d'),
('198703152012012002', 'Rina Marlina, S.T., M.T.', 'III/c'),
('199002202015011003', 'Triase, S.T., M.Kom.', 'III/b'),
('197812102005011004', 'Prof. Dr. Hasanuddin, M.Si.', 'IV/b'),
('199205052019032005', 'Laila Safitri, M.Kom.', NULL);

INSERT IGNORE INTO tb_matakuliah (matkul_kode, matkul_nama, matkul_sks, matkul_semester) VALUES
('SI101', 'Pengantar Sistem Informasi', 3, 1),
('SI102', 'Algoritma dan Pemrograman', 4, 1),
('SI201', 'Basis Data', 3, 2),
('SI202', 'Pemrograman Berbasis Web', 3, 2),
('SI301', 'Pemrograman Berbasis Web Lanjutan', 3, 3),
('SI302', 'Analisis dan Perancangan Sistem', 3, 3),
('SI401', 'Metodologi Penelitian', 2, 4),
('SI501', 'Manajemen Proyek Sistem Informasi', 3, 5);
