<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard untuk Staff
 * Menampilkan statistik dan informasi untuk staff
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'staff') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
        
        // Load model yang diperlukan
        $this->load->model('Model_file_pribadi');
    }

    /**
     * Halaman utama dashboard staff
     */
    public function index() {
        $data = array(
            'title' => 'Dashboard Staff - Sistem Arsip Dokumen',
            'page_title' => 'Dashboard Staff',
            'breadcrumb' => array(
                'Dashboard' => ''
            )
        );

        
        $data['statistik'] = $this->_ambil_statistik_dashboard();
        
        
        $data['submission_pending'] = $this->_ambil_submission_pending();
        
        
        $data['template_saya'] = $this->_ambil_template_saya();

        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/dashboard', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Mengambil statistik untuk dashboard staff
     */
    private function _ambil_statistik_dashboard() {
        $statistik = array();
        $id_staff = $this->session->userdata('id_pengguna');

        
        $this->db->where('dibuat_oleh', $id_staff);
        $this->db->where('status', 'aktif');
        $statistik['jenis_dokumen_saya'] = $this->db->count_all_results('jenis_dokumen');

        
        $this->db->where('dibuat_oleh', $id_staff);
        $this->db->where('status', 'aktif');
        $statistik['template_saya'] = $this->db->count_all_results('template_dokumen');

        
        $this->db->where('status', 'pending');
        $statistik['submission_pending'] = $this->db->count_all_results('submission_dokumen');

        
        $this->db->where('diproses_oleh', $id_staff);
        $statistik['submission_diproses_saya'] = $this->db->count_all_results('submission_dokumen');

        
        $this->db->where('status', 'diproses');
        $statistik['submission_diproses'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('status', 'disetujui');
        $statistik['submission_disetujui'] = $this->db->count_all_results('submission_dokumen');

        $this->db->where('status', 'ditolak');
        $statistik['submission_ditolak'] = $this->db->count_all_results('submission_dokumen');

        
        $statistik['total_submission'] = $this->db->count_all_results('submission_dokumen');

        // Statistik file pribadi user
        $statistik['total_file_pribadi'] = $this->db->count_all_results('file_pribadi');
        
        // File pribadi hari ini
        $this->db->where('DATE(tanggal_upload)', date('Y-m-d'));
        $statistik['file_pribadi_hari_ini'] = $this->db->count_all_results('file_pribadi');
        
        // Total ukuran file pribadi
        $this->db->select_sum('ukuran_file');
        $result = $this->db->get('file_pribadi')->row();
        $statistik['total_ukuran_file'] = $result->ukuran_file ? $result->ukuran_file : 0;

        return $statistik;
    }

    /**
     * Mengambil submission yang pending untuk direview
     */
    private function _ambil_submission_pending() {
        $this->db->select('sd.*, td.nama_template, p.nama_lengkap');
        $this->db->from('submission_dokumen sd');
        $this->db->join('template_dokumen td', 'sd.id_template = td.id_template');
        $this->db->join('pengguna p', 'sd.id_pengguna = p.id_pengguna');
        $this->db->where('sd.status', 'pending');
        $this->db->order_by('sd.tanggal_submission', 'ASC');
        $this->db->limit(10);
        
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil template dokumen yang dibuat staff ini
     */
    private function _ambil_template_saya() {
        $id_staff = $this->session->userdata('id_pengguna');
        
        $this->db->select('td.*, jd.nama_jenis, COUNT(sd.id_submission) as jumlah_submission');
        $this->db->from('template_dokumen td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis');
        $this->db->join('submission_dokumen sd', 'td.id_template = sd.id_template', 'left');
        $this->db->where('td.dibuat_oleh', $id_staff);
        $this->db->where('td.status', 'aktif');
        $this->db->group_by('td.id_template');
        $this->db->order_by('td.tanggal_dibuat', 'DESC');
        $this->db->limit(5);
        
        return $this->db->get()->result_array();
    }
}
