# Sistem Arsip Dokumen

Sistem Pengarsipan Dokumen berbasis web menggunakan CodeIgniter 3 dengan tema Flowbite Admin Dashboard dan Tailwind CSS.

## 📋 Deskripsi

Sistem ini dirancang untuk mengelola pengarsipan dokumen dengan tiga level pengguna:
- **Admin**: Mengelola seluruh sistem, user management, dan pengaturan global
- **Staff**: Membuat template dokumen, menentukan field yang diperlukan, dan mereview submission
- **User**: Melihat daftar dokumen, upload file sesuai requirement, dan mengelola file pribadi

## 🚀 Fitur Utama

### Fitur Admin
- Dashboard dengan statistik lengkap sistem
- Manajemen pengguna (CRUD)
- Monitoring aktivitas sistem
- Laporan dan analitik
- Pengaturan sistem global

### Fitur Staff
- Dashboard khusus staff
- Membuat dan mengelola jenis dokumen
- Membuat template dokumen dengan field kustom
- Menentukan requirement file upload untuk setiap template
- Review dan approve/reject submission dari user
- Tracking status dokumen
- **File Pribadi User** - Melihat semua file pribadi yang diupload oleh user

### Fitur User
- Dashboard personal
- Melihat daftar template dokumen yang tersedia
- Submit dokumen sesuai requirement yang ditentukan staff
- Upload dan kelola file pribadi
- Tracking status submission dokumen
- Notifikasi status perubahan

## 🛠️ Teknologi yang Digunakan

- **Backend**: CodeIgniter 3
- **Frontend**: HTML5, CSS3, JavaScript
- **UI Framework**: Tailwind CSS
- **UI Components**: Flowbite
- **Database**: MySQL
- **Icons**: Font Awesome
- **Charts**: Chart.js

## 📦 Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx Web Server
- XAMPP/WAMP/LAMP (untuk development)

## 🔧 Instalasi

### 1. Clone atau Download Project
```bash
git clone [repository-url]
# atau download dan extract ke folder htdocs/arsdoc
```

### 2. Setup Database
1. Pastikan MySQL server berjalan
2. Buka browser dan akses: `http://localhost/arsdoc/setup_database.php`
3. Klik "Jalankan Setup Database"
4. Tunggu hingga proses selesai

### 3. Konfigurasi (Opsional)
Jika diperlukan, edit konfigurasi di:
- `application/config/database.php` - Konfigurasi database
- `application/config/config.php` - Konfigurasi umum

### 4. Akses Sistem
Buka browser dan akses: `http://localhost/arsdoc/`

## 👥 Akun Default

Setelah setup database, gunakan akun berikut untuk login:

| Role  | Email              | Password |
|-------|-------------------|----------|
| Admin | admin@arsdoc.com  | password |
| Staff | staff@arsdoc.com  | password |
| User  | user@arsdoc.com   | password |

## 📁 Struktur Project

```
arsdoc/
├── application/
│   ├── controllers/
│   │   ├── admin/          # Controller untuk admin
│   │   ├── staff/          # Controller untuk staff
│   │   ├── user/           # Controller untuk user
│   │   └── Autentikasi.php # Controller autentikasi
│   ├── models/
│   │   └── Model_pengguna.php
│   ├── views/
│   │   ├── admin/          # Views untuk admin
│   │   ├── staff/          # Views untuk staff
│   │   ├── user/           # Views untuk user
│   │   ├── autentikasi/    # Views login/register
│   │   └── template/       # Template layout
│   └── config/             # Konfigurasi CI
├── uploads/                # Folder upload file
│   ├── profil/            # Foto profil user
│   ├── dokumen/           # File submission dokumen
│   └── file_pribadi/      # File pribadi user
├── flowbite-admin-dashboard-main/ # Tema Flowbite
├── system/                # CodeIgniter system files
├── database_setup.sql     # Script setup database
├── setup_database.php    # Web interface setup database
└── README.md             # Dokumentasi ini
```

## 🔐 Keamanan

- Password di-hash menggunakan PHP `password_hash()`
- Session management untuk autentikasi
- Role-based access control
- File upload validation (tipe dan ukuran)
- XSS protection
- CSRF protection (dapat diaktifkan di config)
- SQL injection protection (menggunakan Query Builder CI)

## 📊 Database Schema

### Tabel Utama:
- `pengguna` - Data pengguna sistem
- `jenis_dokumen` - Kategori dokumen
- `template_dokumen` - Template dokumen dengan field
- `field_dokumen` - Field yang diperlukan dalam template
- `submission_dokumen` - Submission dari user
- `data_submission` - Data field submission
- `file_pribadi` - File pribadi user
- `log_aktivitas` - Log aktivitas sistem

## 🎨 Kustomisasi UI

Sistem menggunakan Tailwind CSS dan Flowbite components. Untuk kustomisasi:

1. **Warna Tema**: Edit class Tailwind di file view
2. **Layout**: Modifikasi file di `application/views/template/`
3. **Components**: Gunakan Flowbite components dari dokumentasi resmi

## 📝 Penggunaan

### Untuk Admin:
1. Login dengan akun admin
2. Kelola pengguna melalui menu "Kelola Pengguna"
3. Monitor aktivitas sistem di dashboard
4. Lihat laporan dan statistik

### Untuk Staff:
1. Login dengan akun staff
2. Buat jenis dokumen baru
3. Buat template dokumen dengan field yang diperlukan
4. Review submission dari user
5. Approve atau reject submission
6. Melihat semua file pribadi yang diupload oleh user

### Untuk User:
1. Login atau register akun baru
2. Lihat daftar template dokumen yang tersedia
3. Submit dokumen sesuai requirement
4. Upload dan kelola file pribadi
5. Track status submission

## 🔧 Troubleshooting

### Database Connection Error
- Pastikan MySQL server berjalan
- Cek konfigurasi di `application/config/database.php`
- Pastikan database `sistem_arsip_dokumen` sudah dibuat

### File Upload Error
- Cek permission folder `uploads/`
- Pastikan `upload_max_filesize` di php.ini cukup besar
- Cek `max_execution_time` untuk file besar

### 404 Error
- Pastikan mod_rewrite Apache aktif
- Cek file `.htaccess` di root project
- Pastikan `base_url` di config benar

## 📞 Support

Untuk bantuan atau pertanyaan:
- Baca dokumentasi CodeIgniter 3
- Cek dokumentasi Flowbite
- Review kode dan komentar dalam project

## 📄 Lisensi

Project ini menggunakan lisensi MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.

## 🔄 Update Log

### v1.0.0 (2024)
- Initial release
- Sistem autentikasi lengkap
- Dashboard untuk semua role
- Template dokumen dengan field dinamis
- File upload dan management
- UI responsif dengan Flowbite

---

**Catatan**: Sistem ini dibuat untuk keperluan pembelajaran dan dapat dikembangkan lebih lanjut sesuai kebutuhan spesifik organisasi.
# arsdoc
