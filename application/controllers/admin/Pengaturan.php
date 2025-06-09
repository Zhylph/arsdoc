<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Pengaturan Sistem untuk Admin
 * Menangani konfigurasi global sistem arsip dokumen
 */
class Pengaturan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
        
        $this->load->model('Model_pengaturan');
        $this->load->model('Model_log_aktivitas');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    /**
     * Halaman utama pengaturan sistem
     */
    public function index() {
        $data = array(
            'title' => 'Pengaturan Sistem - Admin Dashboard',
            'page_title' => 'Pengaturan Sistem',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Pengaturan Sistem' => ''
            )
        );

        
        $data['pengaturan'] = $this->Model_pengaturan->ambil_semua_pengaturan();
        
        
        $data['pengaturan_grouped'] = array();
        foreach ($data['pengaturan'] as $setting) {
            $data['pengaturan_grouped'][$setting['kategori']][] = $setting;
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/pengaturan/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Simpan pengaturan sistem
     */
    public function simpan() {
        if (!$this->input->post()) {
            redirect('admin/pengaturan');
        }

        $pengaturan_data = $this->input->post();
        $berhasil_update = 0;
        $gagal_update = 0;

        foreach ($pengaturan_data as $key => $value) {
            
            if (in_array($key, array('csrf_token', 'submit'))) {
                continue;
            }

            
            if (!$this->_validasi_pengaturan($key, $value)) {
                $gagal_update++;
                continue;
            }

            if ($this->Model_pengaturan->update_pengaturan($key, $value)) {
                $berhasil_update++;
            } else {
                $gagal_update++;
            }
        }

        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Mengupdate pengaturan sistem',
            "Berhasil: $berhasil_update, Gagal: $gagal_update"
        );

        if ($gagal_update > 0) {
            $this->session->set_flashdata('warning', "Pengaturan diperbarui dengan $berhasil_update berhasil dan $gagal_update gagal.");
        } else {
            $this->session->set_flashdata('success', 'Semua pengaturan berhasil diperbarui.');
        }

        redirect('admin/pengaturan');
    }

    /**
     * Reset pengaturan ke default
     */
    public function reset() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $kategori = $this->input->post('kategori');
        
        if ($this->Model_pengaturan->reset_pengaturan($kategori)) {
            
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Reset pengaturan sistem',
                'Reset pengaturan kategori: ' . $kategori
            );

            echo json_encode(array('success' => true, 'message' => 'Pengaturan berhasil direset ke default.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mereset pengaturan.'));
        }
    }

    /**
     * Backup pengaturan sistem
     */
    public function backup() {
        $pengaturan = $this->Model_pengaturan->ambil_semua_pengaturan();
        
        $backup_data = array(
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0',
            'pengaturan' => $pengaturan
        );

        
        header('Content-Type: application/json');
        header('Content-Disposition: attachment;filename="backup_pengaturan_' . date('Y-m-d_H-i-s') . '.json"');
        header('Cache-Control: max-age=0');

        echo json_encode($backup_data, JSON_PRETTY_PRINT);

        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Backup pengaturan sistem',
            'Download backup pengaturan sistem'
        );
    }

    /**
     * Restore pengaturan dari backup
     */
    public function restore() {
        $data = array(
            'title' => 'Restore Pengaturan - Admin Dashboard',
            'page_title' => 'Restore Pengaturan Sistem',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Pengaturan Sistem' => 'admin/pengaturan',
                'Restore' => ''
            )
        );

        if ($this->input->post()) {
            $this->_proses_restore();
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/pengaturan/restore', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Halaman informasi sistem
     */
    public function sistem_info() {
        $data = array(
            'title' => 'Informasi Sistem - Admin Dashboard',
            'page_title' => 'Informasi Sistem',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Pengaturan Sistem' => 'admin/pengaturan',
                'Informasi Sistem' => ''
            )
        );

        
        $data['sistem_info'] = $this->_ambil_informasi_sistem();
        
        
        $data['database_info'] = $this->_ambil_informasi_database();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/pengaturan/sistem_info', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Maintenance database
     */
    public function maintenance() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $action = $this->input->post('action');
        $result = false;
        $message = '';

        switch ($action) {
            case 'optimize':
                $result = $this->Model_pengaturan->optimize_database();
                $message = $result ? 'Database berhasil dioptimasi.' : 'Gagal mengoptimasi database.';
                break;
                
            case 'clean_logs':
                $hari = $this->input->post('hari', 90);
                $result = $this->Model_log_aktivitas->hapus_log_lama($hari);
                $message = $result ? "Log aktivitas lebih dari $hari hari berhasil dihapus." : 'Gagal menghapus log lama.';
                break;
                
            case 'clean_temp':
                $result = $this->_bersihkan_file_temp();
                $message = $result ? 'File temporary berhasil dibersihkan.' : 'Gagal membersihkan file temporary.';
                break;
                
            default:
                $message = 'Aksi tidak valid.';
                break;
        }

        if ($result) {
            
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Maintenance sistem',
                "Aksi: $action - $message"
            );
        }

        echo json_encode(array('success' => $result, 'message' => $message));
    }

    /**
     * Validasi pengaturan khusus
     */
    private function _validasi_pengaturan($key, $value) {
        switch ($key) {
            case 'max_upload_size':
                return is_numeric($value) && $value > 0 && $value <= 100; 
                
            case 'session_timeout':
                return is_numeric($value) && $value >= 300 && $value <= 86400; 
                
            case 'pagination_limit':
                return is_numeric($value) && $value >= 5 && $value <= 100;
                
            case 'email_smtp_port':
                return is_numeric($value) && $value > 0 && $value <= 65535;
                
            case 'backup_retention_days':
                return is_numeric($value) && $value >= 1 && $value <= 365;
                
            default:
                return true; 
        }
    }

    /**
     * Proses restore pengaturan
     */
    private function _proses_restore() {
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'json';
        $config['max_size'] = 2048; 
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('backup_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            return;
        }

        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];

        
        $json_content = file_get_contents($file_path);
        $backup_data = json_decode($json_content, true);

        if (!$backup_data || !isset($backup_data['pengaturan'])) {
            $this->session->set_flashdata('error', 'File backup tidak valid.');
            unlink($file_path);
            return;
        }

        
        $berhasil = 0;
        $gagal = 0;

        foreach ($backup_data['pengaturan'] as $setting) {
            if ($this->Model_pengaturan->update_pengaturan($setting['key'], $setting['value'])) {
                $berhasil++;
            } else {
                $gagal++;
            }
        }

        
        unlink($file_path);

        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Restore pengaturan sistem',
            "Berhasil: $berhasil, Gagal: $gagal"
        );

        if ($gagal > 0) {
            $this->session->set_flashdata('warning', "Restore selesai dengan $berhasil berhasil dan $gagal gagal.");
        } else {
            $this->session->set_flashdata('success', 'Semua pengaturan berhasil direstore.');
        }
    }

    /**
     * Ambil informasi sistem
     */
    private function _ambil_informasi_sistem() {
        return array(
            'php_version' => phpversion(),
            'ci_version' => CI_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'server_os' => php_uname('s') . ' ' . php_uname('r'),
            'max_upload_size' => ini_get('upload_max_filesize'),
            'max_execution_time' => ini_get('max_execution_time') . ' detik',
            'memory_limit' => ini_get('memory_limit'),
            'post_max_size' => ini_get('post_max_size'),
            'timezone' => date_default_timezone_get(),
            'disk_free_space' => $this->_format_bytes(disk_free_space('.')),
            'disk_total_space' => $this->_format_bytes(disk_total_space('.')),
            'current_time' => date('Y-m-d H:i:s')
        );
    }

    /**
     * Ambil informasi database
     */
    private function _ambil_informasi_database() {
        return array(
            'database_version' => $this->db->version(),
            'database_name' => $this->db->database,
            'total_tables' => $this->Model_pengaturan->hitung_total_tabel(),
            'database_size' => $this->Model_pengaturan->ambil_ukuran_database(),
            'log_size' => $this->Model_log_aktivitas->ambil_ukuran_tabel()
        );
    }

    /**
     * Bersihkan file temporary
     */
    private function _bersihkan_file_temp() {
        $temp_dirs = array('./uploads/temp/', './application/cache/');
        $total_deleted = 0;

        foreach ($temp_dirs as $dir) {
            if (is_dir($dir)) {
                $files = glob($dir . '*');
                foreach ($files as $file) {
                    if (is_file($file) && filemtime($file) < strtotime('-1 day')) {
                        if (unlink($file)) {
                            $total_deleted++;
                        }
                    }
                }
            }
        }

        return $total_deleted > 0;
    }

    /**
     * Format bytes ke format yang mudah dibaca
     */
    private function _format_bytes($size, $precision = 2) {
        if ($size == 0) return '0 B';
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
