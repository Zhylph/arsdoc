<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard untuk User
 * Menampilkan informasi dan statistik untuk user
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Cek apakah user sudah login dan memiliki role user
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'user') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    /**
     * Halaman utama dashboard user
     */
    public function index() {
        $data = array(
            'title' => 'Dashboard User - Sistem Arsip Dokumen',
            'page_title' => 'Dashboard User',
            'breadcrumb' => array(
                'Dashboard' => ''
            )
        );

        // Ambil statistik untuk dashboard
        $data['statistik'] = $this->_ambil_statistik_dashboard();
        
        // Ambil submission terbaru user
        $data['submission_terbaru'] = $this->_ambil_submission_terbaru();
        
        // Ambil template dokumen yang tersedia
        $data['template_tersedia'] = $this->_ambil_template_tersedia();
        
        // Ambil file pribadi terbaru
        $data['file_pribadi_terbaru'] = $this->_ambil_file_pribadi_terbaru();

        // Load views
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/dashboard', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Mengambil statistik untuk dashboard user
     */
    private function _ambil_statistik_dashboard() {
        $statistik = array();
        $id_user = $this->session->userdata('id_pengguna');

        // Hitung submission user
        $this->db->where('id_pengguna', $id_user);
        $statistik['total_submission'] = $this->db->count_all_results('submission_dokumen');

        // Hitung submission berdasarkan status
        $this->db->where('id_pengguna', $id_user);
        $this->db->where('status', 'pending');
        $statistik['submission_pending'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('id_pengguna', $id_user);
        $this->db->where('status', 'diproses');
        $statistik['submission_diproses'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('id_pengguna', $id_user);
        $this->db->where('status', 'disetujui');
        $statistik['submission_disetujui'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('id_pengguna', $id_user);
        $this->db->where('status', 'ditolak');
        $statistik['submission_ditolak'] = $this->db->count_all_results('submission_dokumen');

        // Hitung file pribadi
        $this->db->where('id_pengguna', $id_user);
        $statistik['total_file_pribadi'] = $this->db->count_all_results('file_pribadi');

        // Hitung ukuran total file pribadi (dalam MB)
        $this->db->select_sum('ukuran_file');
        $this->db->where('id_pengguna', $id_user);
        $query = $this->db->get('file_pribadi');
        $ukuran_total = $query->row()->ukuran_file ?: 0;
        $statistik['ukuran_file_pribadi'] = round($ukuran_total / 1048576, 2); // Convert to MB

        // Hitung template dokumen yang tersedia
        $this->db->where('status', 'aktif');
        $statistik['template_tersedia'] = $this->db->count_all_results('template_dokumen');

        return $statistik;
    }

    /**
     * Mengambil submission terbaru user
     */
    private function _ambil_submission_terbaru() {
        $id_user = $this->session->userdata('id_pengguna');
        
        $this->db->select('sd.*, td.nama_template, jd.nama_jenis');
        $this->db->from('submission_dokumen sd');
        $this->db->join('template_dokumen td', 'sd.id_template = td.id_template');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis');
        $this->db->where('sd.id_pengguna', $id_user);
        $this->db->order_by('sd.tanggal_submission', 'DESC');
        $this->db->limit(5);
        
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil template dokumen yang tersedia
     */
    private function _ambil_template_tersedia() {
        $this->db->select('td.*, jd.nama_jenis');
        $this->db->from('template_dokumen td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis');
        $this->db->where('td.status', 'aktif');
        $this->db->where('jd.status', 'aktif');
        $this->db->order_by('td.tanggal_dibuat', 'DESC');
        $this->db->limit(6);
        
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil file pribadi terbaru
     */
    private function _ambil_file_pribadi_terbaru() {
        $id_user = $this->session->userdata('id_pengguna');
        
        $this->db->select('*');
        $this->db->where('id_pengguna', $id_user);
        $this->db->order_by('tanggal_upload', 'DESC');
        $this->db->limit(5);
        
        return $this->db->get('file_pribadi')->result_array();
    }
}
