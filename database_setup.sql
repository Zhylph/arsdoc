-- Database Setup untuk Sistem Pengarsipan Dokumen
-- Dibuat untuk CodeIgniter 3 dengan MySQL

CREATE DATABASE IF NOT EXISTS sistem_arsip_dokumen;
USE sistem_arsip_dokumen;

-- Tabel untuk menyimpan data pengguna
CREATE TABLE pengguna (
    id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'user') NOT NULL DEFAULT 'user',
    status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
    foto_profil VARCHAR(255) NULL,
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_diperbarui TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk jenis dokumen
CREATE TABLE jenis_dokumen (
    id_jenis INT AUTO_INCREMENT PRIMARY KEY,
    nama_jenis VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
    dibuat_oleh INT NOT NULL,
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_diperbarui TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dibuat_oleh) REFERENCES pengguna(id_pengguna)
);

-- Tabel untuk template dokumen
CREATE TABLE template_dokumen (
    id_template INT AUTO_INCREMENT PRIMARY KEY,
    id_jenis INT NOT NULL,
    nama_template VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    instruksi_upload TEXT,
    max_ukuran_file INT DEFAULT 10485760, -- 10MB dalam bytes
    tipe_file_diizinkan VARCHAR(255) DEFAULT 'pdf,doc,docx,jpg,jpeg,png',
    status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
    dibuat_oleh INT NOT NULL,
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_diperbarui TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_jenis) REFERENCES jenis_dokumen(id_jenis),
    FOREIGN KEY (dibuat_oleh) REFERENCES pengguna(id_pengguna)
);

-- Tabel untuk field yang diperlukan dalam template
CREATE TABLE field_dokumen (
    id_field INT AUTO_INCREMENT PRIMARY KEY,
    id_template INT NOT NULL,
    nama_field VARCHAR(100) NOT NULL,
    tipe_field ENUM('text', 'textarea', 'file', 'date', 'number') NOT NULL,
    wajib_diisi BOOLEAN DEFAULT FALSE,
    urutan INT DEFAULT 0,
    placeholder VARCHAR(255),
    validasi VARCHAR(255),
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_template) REFERENCES template_dokumen(id_template) ON DELETE CASCADE
);

-- Tabel untuk submission dokumen dari user
CREATE TABLE submission_dokumen (
    id_submission INT AUTO_INCREMENT PRIMARY KEY,
    id_template INT NOT NULL,
    id_pengguna INT NOT NULL,
    nomor_submission VARCHAR(50) UNIQUE NOT NULL,
    status ENUM('pending', 'diproses', 'disetujui', 'ditolak') NOT NULL DEFAULT 'pending',
    catatan_staff TEXT,
    diproses_oleh INT NULL,
    tanggal_submission TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_diproses TIMESTAMP NULL,
    FOREIGN KEY (id_template) REFERENCES template_dokumen(id_template),
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna),
    FOREIGN KEY (diproses_oleh) REFERENCES pengguna(id_pengguna)
);

-- Tabel untuk data field submission
CREATE TABLE data_submission (
    id_data INT AUTO_INCREMENT PRIMARY KEY,
    id_submission INT NOT NULL,
    id_field INT NOT NULL,
    nilai_field TEXT,
    nama_file VARCHAR(255),
    path_file VARCHAR(500),
    ukuran_file INT,
    tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_submission) REFERENCES submission_dokumen(id_submission) ON DELETE CASCADE,
    FOREIGN KEY (id_field) REFERENCES field_dokumen(id_field)
);

-- Tabel untuk file pribadi user
CREATE TABLE file_pribadi (
    id_file INT AUTO_INCREMENT PRIMARY KEY,
    id_pengguna INT NOT NULL,
    nama_file VARCHAR(255) NOT NULL,
    nama_asli VARCHAR(255) NOT NULL,
    path_file VARCHAR(500) NOT NULL,
    ukuran_file INT NOT NULL,
    tipe_file VARCHAR(50) NOT NULL,
    deskripsi TEXT,
    tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna) ON DELETE CASCADE
);

-- Tabel untuk log aktivitas sistem
CREATE TABLE log_aktivitas (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_pengguna INT NOT NULL,
    aktivitas VARCHAR(255) NOT NULL,
    detail TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    tanggal_aktivitas TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna)
);

-- Insert data admin default
INSERT INTO pengguna (nama_lengkap, email, password, role) VALUES 
('Administrator', 'admin@arsdoc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert data staff default
INSERT INTO pengguna (nama_lengkap, email, password, role) VALUES 
('Staff Arsip', 'staff@arsdoc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff');

-- Insert data user default
INSERT INTO pengguna (nama_lengkap, email, password, role) VALUES 
('User Demo', 'user@arsdoc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Insert contoh jenis dokumen
INSERT INTO jenis_dokumen (nama_jenis, deskripsi, dibuat_oleh) VALUES 
('Dokumen Kepegawaian', 'Dokumen yang berkaitan dengan kepegawaian seperti kenaikan pangkat, mutasi, dll', 2),
('Dokumen Akademik', 'Dokumen yang berkaitan dengan akademik seperti ijazah, transkrip, sertifikat', 2),
('Dokumen Keuangan', 'Dokumen yang berkaitan dengan keuangan seperti slip gaji, SPT, dll', 2);

-- Insert contoh template dokumen
INSERT INTO template_dokumen (id_jenis, nama_template, deskripsi, instruksi_upload, dibuat_oleh) VALUES 
(1, 'Pengajuan Kenaikan Pangkat', 'Template untuk pengajuan kenaikan pangkat pegawai', 'Silakan upload dokumen pendukung yang diperlukan untuk pengajuan kenaikan pangkat', 2),
(2, 'Legalisir Ijazah', 'Template untuk permohonan legalisir ijazah', 'Upload scan ijazah asli yang akan dilegalisir', 2),
(3, 'Pengajuan Reimbursement', 'Template untuk pengajuan penggantian biaya', 'Upload bukti pembayaran dan dokumen pendukung lainnya', 2);
