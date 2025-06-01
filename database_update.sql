-- Database Update untuk menambah field opsi pada tabel field_dokumen
-- Jalankan script ini untuk menambah field yang diperlukan

USE sistem_arsip_dokumen;

-- Tambah field opsi untuk menyimpan pilihan select/radio/checkbox
ALTER TABLE field_dokumen 
ADD COLUMN opsi TEXT AFTER placeholder;

-- Update tipe_field enum untuk menambah select, radio, checkbox
ALTER TABLE field_dokumen 
MODIFY COLUMN tipe_field ENUM('text', 'textarea', 'file', 'date', 'number', 'select', 'radio', 'checkbox') NOT NULL;

-- Update wajib_diisi menjadi ENUM untuk konsistensi
ALTER TABLE field_dokumen 
MODIFY COLUMN wajib_diisi ENUM('ya', 'tidak') NOT NULL DEFAULT 'tidak';
