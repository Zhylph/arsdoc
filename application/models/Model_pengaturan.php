<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola pengaturan sistem
 * Menangani konfigurasi global aplikasi
 */
class Model_pengaturan extends CI_Model {

    private $tabel = 'pengaturan_sistem';

    public function __construct() {
        parent::__construct();
        $this->_buat_tabel_jika_belum_ada();
        $this->_inisialisasi_pengaturan_default();
    }

    /**
     * Mendapatkan semua pengaturan
     */
    public function ambil_semua_pengaturan() {
        $this->db->order_by('kategori, urutan, key');
        return $this->db->get($this->tabel)->result_array();
    }

    /**
     * Mendapatkan pengaturan berdasarkan key
     */
    public function ambil_pengaturan($key) {
        $this->db->where('key', $key);
        $result = $this->db->get($this->tabel)->row_array();
        return $result ? $result['value'] : null;
    }

    /**
     * Mendapatkan pengaturan berdasarkan kategori
     */
    public function ambil_pengaturan_by_kategori($kategori) {
        $this->db->where('kategori', $kategori);
        $this->db->order_by('urutan, key');
        return $this->db->get($this->tabel)->result_array();
    }

    /**
     * Update pengaturan
     */
    public function update_pengaturan($key, $value) {
        $this->db->where('key', $key);
        return $this->db->update($this->tabel, array(
            'value' => $value,
            'tanggal_diperbarui' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Tambah pengaturan baru
     */
    public function tambah_pengaturan($data) {
        $data['tanggal_dibuat'] = date('Y-m-d H:i:s');
        $data['tanggal_diperbarui'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->tabel, $data);
    }

    /**
     * Reset pengaturan ke default berdasarkan kategori
     */
    public function reset_pengaturan($kategori = null) {
        $pengaturan_default = $this->_pengaturan_default();
        $berhasil = 0;

        foreach ($pengaturan_default as $setting) {
            if ($kategori && $setting['kategori'] !== $kategori) {
                continue;
            }

            $this->db->where('key', $setting['key']);
            if ($this->db->update($this->tabel, array(
                'value' => $setting['default_value'],
                'tanggal_diperbarui' => date('Y-m-d H:i:s')
            ))) {
                $berhasil++;
            }
        }

        return $berhasil > 0;
    }

    /**
     * Optimize database
     */
    public function optimize_database() {
        $tables = $this->db->list_tables();
        $optimized = 0;

        foreach ($tables as $table) {
            if ($this->db->query("OPTIMIZE TABLE `$table`")) {
                $optimized++;
            }
        }

        return $optimized > 0;
    }

    /**
     * Hitung total tabel dalam database
     */
    public function hitung_total_tabel() {
        return count($this->db->list_tables());
    }

    /**
     * Ambil ukuran database
     */
    public function ambil_ukuran_database() {
        $query = $this->db->query("
            SELECT 
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'ukuran_mb'
            FROM information_schema.tables 
            WHERE table_schema = DATABASE()
        ");
        
        $result = $query->row_array();
        return $result ? $result['ukuran_mb'] . ' MB' : '0 MB';
    }

    /**
     * Buat tabel pengaturan jika belum ada
     */
    private function _buat_tabel_jika_belum_ada() {
        if (!$this->db->table_exists($this->tabel)) {
            $sql = "
                CREATE TABLE `{$this->tabel}` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `key` varchar(100) NOT NULL,
                    `value` text,
                    `default_value` text,
                    `kategori` varchar(50) NOT NULL,
                    `label` varchar(200) NOT NULL,
                    `deskripsi` text,
                    `tipe` enum('text','number','email','url','textarea','select','checkbox','file') NOT NULL DEFAULT 'text',
                    `options` text COMMENT 'JSON untuk select options',
                    `required` tinyint(1) NOT NULL DEFAULT 0,
                    `urutan` int(11) NOT NULL DEFAULT 0,
                    `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `tanggal_diperbarui` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `key` (`key`),
                    KEY `kategori` (`kategori`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ";
            
            $this->db->query($sql);
        }
    }

    /**
     * Inisialisasi pengaturan default
     */
    private function _inisialisasi_pengaturan_default() {
        // Cek apakah sudah ada pengaturan
        $count = $this->db->count_all($this->tabel);
        if ($count > 0) {
            return;
        }

        $pengaturan_default = $this->_pengaturan_default();
        
        foreach ($pengaturan_default as $setting) {
            $this->db->insert($this->tabel, $setting);
        }
    }

    /**
     * Daftar pengaturan default sistem
     */
    private function _pengaturan_default() {
        return array(
            // Pengaturan Umum
            array(
                'key' => 'site_name',
                'value' => 'Sistem Arsip Dokumen',
                'default_value' => 'Sistem Arsip Dokumen',
                'kategori' => 'umum',
                'label' => 'Nama Situs',
                'deskripsi' => 'Nama aplikasi yang akan ditampilkan di header dan title',
                'tipe' => 'text',
                'required' => 1,
                'urutan' => 1
            ),
            array(
                'key' => 'site_description',
                'value' => 'Sistem Pengarsipan Dokumen Digital',
                'default_value' => 'Sistem Pengarsipan Dokumen Digital',
                'kategori' => 'umum',
                'label' => 'Deskripsi Situs',
                'deskripsi' => 'Deskripsi singkat tentang aplikasi',
                'tipe' => 'textarea',
                'required' => 0,
                'urutan' => 2
            ),
            array(
                'key' => 'admin_email',
                'value' => 'admin@arsdoc.com',
                'default_value' => 'admin@arsdoc.com',
                'kategori' => 'umum',
                'label' => 'Email Administrator',
                'deskripsi' => 'Email administrator untuk notifikasi sistem',
                'tipe' => 'email',
                'required' => 1,
                'urutan' => 3
            ),
            array(
                'key' => 'timezone',
                'value' => 'Asia/Jakarta',
                'default_value' => 'Asia/Jakarta',
                'kategori' => 'umum',
                'label' => 'Zona Waktu',
                'deskripsi' => 'Zona waktu yang digunakan sistem',
                'tipe' => 'select',
                'options' => '{"Asia/Jakarta":"WIB (Jakarta)","Asia/Makassar":"WITA (Makassar)","Asia/Jayapura":"WIT (Jayapura)"}',
                'required' => 1,
                'urutan' => 4
            ),

            // Pengaturan Upload
            array(
                'key' => 'max_upload_size',
                'value' => '10',
                'default_value' => '10',
                'kategori' => 'upload',
                'label' => 'Ukuran Maksimal Upload (MB)',
                'deskripsi' => 'Ukuran maksimal file yang dapat diupload dalam MB',
                'tipe' => 'number',
                'required' => 1,
                'urutan' => 1
            ),
            array(
                'key' => 'allowed_file_types',
                'value' => 'pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif',
                'default_value' => 'pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif',
                'kategori' => 'upload',
                'label' => 'Tipe File yang Diizinkan',
                'deskripsi' => 'Ekstensi file yang diizinkan untuk upload (pisahkan dengan koma)',
                'tipe' => 'text',
                'required' => 1,
                'urutan' => 2
            ),
            array(
                'key' => 'auto_delete_temp_files',
                'value' => '1',
                'default_value' => '1',
                'kategori' => 'upload',
                'label' => 'Hapus File Temporary Otomatis',
                'deskripsi' => 'Hapus file temporary yang lebih dari 24 jam secara otomatis',
                'tipe' => 'checkbox',
                'required' => 0,
                'urutan' => 3
            ),

            // Pengaturan Keamanan
            array(
                'key' => 'session_timeout',
                'value' => '3600',
                'default_value' => '3600',
                'kategori' => 'keamanan',
                'label' => 'Timeout Session (detik)',
                'deskripsi' => 'Waktu timeout session dalam detik (3600 = 1 jam)',
                'tipe' => 'number',
                'required' => 1,
                'urutan' => 1
            ),
            array(
                'key' => 'max_login_attempts',
                'value' => '5',
                'default_value' => '5',
                'kategori' => 'keamanan',
                'label' => 'Maksimal Percobaan Login',
                'deskripsi' => 'Jumlah maksimal percobaan login yang gagal sebelum akun dikunci',
                'tipe' => 'number',
                'required' => 1,
                'urutan' => 2
            ),
            array(
                'key' => 'lockout_duration',
                'value' => '900',
                'default_value' => '900',
                'kategori' => 'keamanan',
                'label' => 'Durasi Lockout (detik)',
                'deskripsi' => 'Durasi penguncian akun dalam detik (900 = 15 menit)',
                'tipe' => 'number',
                'required' => 1,
                'urutan' => 3
            ),
            array(
                'key' => 'force_https',
                'value' => '0',
                'default_value' => '0',
                'kategori' => 'keamanan',
                'label' => 'Paksa HTTPS',
                'deskripsi' => 'Paksa penggunaan HTTPS untuk semua halaman',
                'tipe' => 'checkbox',
                'required' => 0,
                'urutan' => 4
            ),

            // Pengaturan Email
            array(
                'key' => 'email_protocol',
                'value' => 'smtp',
                'default_value' => 'smtp',
                'kategori' => 'email',
                'label' => 'Protokol Email',
                'deskripsi' => 'Protokol yang digunakan untuk mengirim email',
                'tipe' => 'select',
                'options' => '{"mail":"PHP Mail","smtp":"SMTP","sendmail":"Sendmail"}',
                'required' => 1,
                'urutan' => 1
            ),
            array(
                'key' => 'email_smtp_host',
                'value' => 'smtp.gmail.com',
                'default_value' => 'smtp.gmail.com',
                'kategori' => 'email',
                'label' => 'SMTP Host',
                'deskripsi' => 'Host server SMTP',
                'tipe' => 'text',
                'required' => 0,
                'urutan' => 2
            ),
            array(
                'key' => 'email_smtp_port',
                'value' => '587',
                'default_value' => '587',
                'kategori' => 'email',
                'label' => 'SMTP Port',
                'deskripsi' => 'Port server SMTP',
                'tipe' => 'number',
                'required' => 0,
                'urutan' => 3
            ),
            array(
                'key' => 'email_smtp_user',
                'value' => '',
                'default_value' => '',
                'kategori' => 'email',
                'label' => 'SMTP Username',
                'deskripsi' => 'Username untuk autentikasi SMTP',
                'tipe' => 'text',
                'required' => 0,
                'urutan' => 4
            ),
            array(
                'key' => 'email_smtp_pass',
                'value' => '',
                'default_value' => '',
                'kategori' => 'email',
                'label' => 'SMTP Password',
                'deskripsi' => 'Password untuk autentikasi SMTP',
                'tipe' => 'text',
                'required' => 0,
                'urutan' => 5
            ),

            // Pengaturan Tampilan
            array(
                'key' => 'pagination_limit',
                'value' => '10',
                'default_value' => '10',
                'kategori' => 'tampilan',
                'label' => 'Jumlah Data per Halaman',
                'deskripsi' => 'Jumlah data yang ditampilkan per halaman pada tabel',
                'tipe' => 'number',
                'required' => 1,
                'urutan' => 1
            ),
            array(
                'key' => 'date_format',
                'value' => 'd/m/Y',
                'default_value' => 'd/m/Y',
                'kategori' => 'tampilan',
                'label' => 'Format Tanggal',
                'deskripsi' => 'Format tampilan tanggal di seluruh sistem',
                'tipe' => 'select',
                'options' => '{"d/m/Y":"DD/MM/YYYY","Y-m-d":"YYYY-MM-DD","d-m-Y":"DD-MM-YYYY","m/d/Y":"MM/DD/YYYY"}',
                'required' => 1,
                'urutan' => 2
            ),
            array(
                'key' => 'show_breadcrumb',
                'value' => '1',
                'default_value' => '1',
                'kategori' => 'tampilan',
                'label' => 'Tampilkan Breadcrumb',
                'deskripsi' => 'Tampilkan navigasi breadcrumb di setiap halaman',
                'tipe' => 'checkbox',
                'required' => 0,
                'urutan' => 3
            ),

            // Pengaturan Backup
            array(
                'key' => 'auto_backup',
                'value' => '0',
                'default_value' => '0',
                'kategori' => 'backup',
                'label' => 'Backup Otomatis',
                'deskripsi' => 'Aktifkan backup database otomatis',
                'tipe' => 'checkbox',
                'required' => 0,
                'urutan' => 1
            ),
            array(
                'key' => 'backup_frequency',
                'value' => 'weekly',
                'default_value' => 'weekly',
                'kategori' => 'backup',
                'label' => 'Frekuensi Backup',
                'deskripsi' => 'Frekuensi backup otomatis',
                'tipe' => 'select',
                'options' => '{"daily":"Harian","weekly":"Mingguan","monthly":"Bulanan"}',
                'required' => 0,
                'urutan' => 2
            ),
            array(
                'key' => 'backup_retention_days',
                'value' => '30',
                'default_value' => '30',
                'kategori' => 'backup',
                'label' => 'Retensi Backup (hari)',
                'deskripsi' => 'Jumlah hari backup disimpan sebelum dihapus otomatis',
                'tipe' => 'number',
                'required' => 0,
                'urutan' => 3
            )
        );
    }
}
