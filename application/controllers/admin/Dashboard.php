<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard untuk Admin
 * Menampilkan statistik dan informasi sistem untuk administrator
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
        
        $this->load->model('Model_pengguna');
    }

    /**
     * Halaman utama dashboard admin
     */
    public function index() {
        $data = array(
            'title' => 'Dashboard Admin - Sistem Arsip Dokumen',
            'page_title' => 'Dashboard Administrator',
            'breadcrumb' => array(
                'Dashboard' => ''
            )
        );

        
        $data['statistik'] = $this->_ambil_statistik_dashboard();
        
        
        $data['aktivitas_terbaru'] = $this->_ambil_aktivitas_terbaru();
        
        
        $data['pengguna_terbaru'] = $this->_ambil_pengguna_terbaru();

        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Mengambil statistik untuk dashboard
     */
    private function _ambil_statistik_dashboard() {
        $statistik = array();

        
        $jumlah_pengguna = $this->Model_pengguna->hitung_pengguna_by_role();
        $statistik['total_admin'] = $jumlah_pengguna['admin'];
        $statistik['total_staff'] = $jumlah_pengguna['staff'];
        $statistik['total_user'] = $jumlah_pengguna['user'];
        $statistik['total_pengguna'] = $statistik['total_admin'] + $statistik['total_staff'] + $statistik['total_user'];

        
        $this->db->where('status', 'aktif');
        $statistik['total_jenis_dokumen'] = $this->db->count_all_results('jenis_dokumen');

        
        $this->db->where('status', 'aktif');
        $statistik['total_template'] = $this->db->count_all_results('template_dokumen');

        
        $statistik['total_submission'] = $this->db->count_all_results('submission_dokumen');

        
        $this->db->where('status', 'pending');
        $statistik['submission_pending'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('status', 'diproses');
        $statistik['submission_diproses'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('status', 'disetujui');
        $statistik['submission_disetujui'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('status', 'ditolak');
        $statistik['submission_ditolak'] = $this->db->count_all_results('submission_dokumen');

        
        $statistik['total_file_pribadi'] = $this->db->count_all_results('file_pribadi');

        
        $this->db->select_sum('ukuran_file');
        $query = $this->db->get('file_pribadi');
        $ukuran_file_pribadi = $query->row()->ukuran_file ?: 0;

        $this->db->select_sum('ukuran_file');
        $query = $this->db->get('data_submission');
        $ukuran_file_submission = $query->row()->ukuran_file ?: 0;

        $statistik['total_ukuran_file'] = round(($ukuran_file_pribadi + $ukuran_file_submission) / 1048576, 2); 

        return $statistik;
    }

    /**
     * Mengambil aktivitas terbaru sistem
     */
    private function _ambil_aktivitas_terbaru() {
        $this->db->select('la.*, p.nama_lengkap, p.role');
        $this->db->from('log_aktivitas la');
        $this->db->join('pengguna p', 'la.id_pengguna = p.id_pengguna');
        $this->db->order_by('la.tanggal_aktivitas', 'DESC');
        $this->db->limit(10);
        
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil pengguna yang baru mendaftar
     */
    private function _ambil_pengguna_terbaru() {
        $this->db->select('id_pengguna, nama_lengkap, email, role, tanggal_dibuat');
        $this->db->order_by('tanggal_dibuat', 'DESC');
        $this->db->limit(5);
        
        return $this->db->get('pengguna')->result_array();
    }

    /**
     * API endpoint untuk data chart (AJAX)
     */
    public function chart_data() {
        
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $type = $this->input->get('type');
        
        switch ($type) {
            case 'submission_bulanan':
                $data = $this->_chart_submission_bulanan();
                break;
            case 'pengguna_role':
                $data = $this->_chart_pengguna_role();
                break;
            case 'dokumen_populer':
                $data = $this->_chart_dokumen_populer();
                break;
            default:
                $data = array('error' => 'Invalid chart type');
                break;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Data chart submission per bulan
     */
    private function _chart_submission_bulanan() {
        $this->db->select("DATE_FORMAT(tanggal_submission, '%Y-%m') as bulan, COUNT(*) as jumlah");
        $this->db->where('tanggal_submission >=', date('Y-m-d', strtotime('-12 months')));
        $this->db->group_by("DATE_FORMAT(tanggal_submission, '%Y-%m')");
        $this->db->order_by('bulan', 'ASC');
        
        $result = $this->db->get('submission_dokumen')->result_array();
        
        $labels = array();
        $data = array();
        
        foreach ($result as $row) {
            $labels[] = date('M Y', strtotime($row['bulan'] . '-01'));
            $data[] = (int)$row['jumlah'];
        }
        
        return array(
            'labels' => $labels,
            'data' => $data
        );
    }

    /**
     * Data chart distribusi pengguna berdasarkan role
     */
    private function _chart_pengguna_role() {
        $jumlah_pengguna = $this->Model_pengguna->hitung_pengguna_by_role();
        
        return array(
            'labels' => array('Admin', 'Staff', 'User'),
            'data' => array(
                $jumlah_pengguna['admin'],
                $jumlah_pengguna['staff'],
                $jumlah_pengguna['user']
            )
        );
    }

    /**
     * Data chart dokumen paling populer
     */
    private function _chart_dokumen_populer() {
        $this->db->select('td.nama_template, COUNT(sd.id_submission) as jumlah_submission');
        $this->db->from('template_dokumen td');
        $this->db->join('submission_dokumen sd', 'td.id_template = sd.id_template', 'left');
        $this->db->group_by('td.id_template');
        $this->db->order_by('jumlah_submission', 'DESC');
        $this->db->limit(5);
        
        $result = $this->db->get()->result_array();
        
        $labels = array();
        $data = array();
        
        foreach ($result as $row) {
            $labels[] = $row['nama_template'];
            $data[] = (int)$row['jumlah_submission'];
        }
        
        return array(
            'labels' => $labels,
            'data' => $data
        );
    }

    /**
     * Halaman sistem info
     */
    public function sistem_info() {
        $data = array(
            'title' => 'Informasi Sistem - Admin Dashboard',
            'page_title' => 'Informasi Sistem',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Informasi Sistem' => ''
            )
        );

        
        $data['sistem_info'] = array(
            'php_version' => phpversion(),
            'ci_version' => CI_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_version' => $this->db->version(),
            'max_upload_size' => ini_get('upload_max_filesize'),
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
            'disk_free_space' => $this->_format_bytes(disk_free_space('.')),
            'disk_total_space' => $this->_format_bytes(disk_total_space('.'))
        );

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/sistem_info', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Format bytes ke format yang mudah dibaca
     */
    private function _format_bytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
