<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Laporan untuk Admin
 * Menangani laporan dan statistik sistem
 */
class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek apakah user sudah login dan memiliki role admin
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }

        if ($this->session->userdata('role') !== 'admin') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }

        $this->load->model('Model_pengguna');
        $this->load->model('Model_submission');
        $this->load->model('Model_template_dokumen');
        $this->load->model('Model_jenis_dokumen');
        $this->load->model('Model_log_aktivitas');
        $this->load->helper('url');
    }

    /**
     * Halaman utama laporan
     */
    public function index() {
        $data = array(
            'title' => 'Laporan Sistem - Admin Dashboard',
            'page_title' => 'Laporan dan Statistik Sistem',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Laporan' => ''
            )
        );

        // Ambil filter dari input
        $filter = $this->_get_filter();

        // Statistik umum
        $data['statistik_umum'] = $this->_ambil_statistik_umum($filter);

        // Statistik submission
        $data['statistik_submission'] = $this->_ambil_statistik_submission($filter);

        // Statistik pengguna
        $data['statistik_pengguna'] = $this->_ambil_statistik_pengguna($filter);

        // Template paling populer
        $data['template_populer'] = $this->Model_submission->ambil_statistik_by_template(5);

        // Aktivitas terbaru
        $data['aktivitas_terbaru'] = $this->Model_log_aktivitas->ambil_aktivitas_terbaru(10);

        $data['filter'] = $filter;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Laporan submission dokumen
     */
    public function submission() {
        $data = array(
            'title' => 'Laporan Submission - Admin Dashboard',
            'page_title' => 'Laporan Submission Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Laporan' => 'admin/laporan',
                'Submission' => ''
            )
        );

        // Konfigurasi pagination
        $config['base_url'] = base_url('admin/laporan/submission');
        $filter = $this->_get_filter();
        $config['total_rows'] = $this->Model_submission->hitung_total_submission($filter);
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;

        // Styling pagination dengan Flowbite
        $this->_setup_pagination($config);

        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;

        // Ambil data submission
        $data['submission'] = $this->Model_submission->ambil_semua_submission($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];

        // Ambil data untuk dropdown filter
        $data['template_list'] = $this->Model_template_dokumen->ambil_template_aktif();
        $data['staff_list'] = $this->Model_pengguna->ambil_staff_aktif();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/laporan/submission', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Laporan pengguna
     */
    public function pengguna() {
        $data = array(
            'title' => 'Laporan Pengguna - Admin Dashboard',
            'page_title' => 'Laporan Data Pengguna',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Laporan' => 'admin/laporan',
                'Pengguna' => ''
            )
        );

        // Konfigurasi pagination
        $config['base_url'] = base_url('admin/laporan/pengguna');
        $filter = $this->_get_filter();
        $config['total_rows'] = $this->Model_pengguna->hitung_total_pengguna($filter);
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;

        $this->_setup_pagination($config);

        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;

        // Ambil data pengguna
        $data['pengguna'] = $this->Model_pengguna->ambil_semua_pengguna($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/laporan/pengguna', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Laporan aktivitas sistem
     */
    public function aktivitas() {
        $data = array(
            'title' => 'Laporan Aktivitas - Admin Dashboard',
            'page_title' => 'Laporan Log Aktivitas Sistem',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Laporan' => 'admin/laporan',
                'Aktivitas' => ''
            )
        );

        // Konfigurasi pagination
        $config['base_url'] = base_url('admin/laporan/aktivitas');
        $filter = $this->_get_filter();
        $config['total_rows'] = $this->Model_log_aktivitas->hitung_total_log($filter);
        $config['per_page'] = 50;
        $config['uri_segment'] = 4;

        $this->_setup_pagination($config);

        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;

        // Ambil data log aktivitas
        $data['log_aktivitas'] = $this->Model_log_aktivitas->ambil_semua_log($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];

        // Statistik aktivitas
        $data['statistik_aktivitas'] = $this->Model_log_aktivitas->ambil_ringkasan_aktivitas();
        $data['aktivitas_populer'] = $this->Model_log_aktivitas->ambil_aktivitas_populer(10);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/laporan/aktivitas', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Export laporan submission ke Excel
     */
    public function export_submission() {
        $filter = $this->_get_filter();
        $submission = $this->Model_submission->ambil_semua_submission($filter);

        // Set header untuk download Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_submission_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        // Load view untuk export
        $data['submission'] = $submission;
        $data['filter'] = $filter;
        $this->load->view('admin/laporan/export_submission', $data);
    }

    /**
     * Export laporan pengguna ke Excel
     */
    public function export_pengguna() {
        $filter = $this->_get_filter();
        $pengguna = $this->Model_pengguna->ambil_semua_pengguna($filter);

        // Set header untuk download Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_pengguna_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        // Load view untuk export
        $data['pengguna'] = $pengguna;
        $data['filter'] = $filter;
        $this->load->view('admin/laporan/export_pengguna', $data);
    }

    /**
     * Export laporan aktivitas ke CSV
     */
    public function export_aktivitas() {
        $filter = $this->_get_filter();
        $this->Model_log_aktivitas->export_log($filter);
    }

    /**
     * API untuk data chart (AJAX)
     */
    public function chart_data() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $type = $this->input->get('type');
        $filter = $this->_get_filter();

        switch ($type) {
            case 'submission_bulanan':
                $data = $this->Model_submission->ambil_statistik_bulanan();
                break;
            case 'submission_status':
                $data = $this->_chart_submission_status($filter);
                break;
            case 'pengguna_role':
                $data = $this->Model_pengguna->hitung_pengguna_by_role();
                break;
            case 'aktivitas_harian':
                $data = $this->Model_log_aktivitas->ambil_statistik_harian(7);
                break;
            default:
                $data = array('error' => 'Invalid chart type');
                break;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Mendapatkan filter dari input GET
     */
    private function _get_filter() {
        return array(
            'status' => $this->input->get('status'),
            'role' => $this->input->get('role'),
            'id_template' => $this->input->get('id_template'),
            'diproses_oleh' => $this->input->get('diproses_oleh'),
            'tanggal_dari' => $this->input->get('tanggal_dari'),
            'tanggal_sampai' => $this->input->get('tanggal_sampai'),
            'pencarian' => $this->input->get('pencarian'),
            'aktivitas' => $this->input->get('aktivitas')
        );
    }

    /**
     * Setup konfigurasi pagination
     */
    private function _setup_pagination(&$config) {
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="inline-flex items-center -space-x-px">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><span class="px-3 py-2 text-blue-600 border border-gray-300 bg-blue-50">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->load->library('pagination', $config);
    }

    /**
     * Ambil statistik umum sistem
     */
    private function _ambil_statistik_umum($filter) {
        $statistik = array();

        // Total pengguna
        $statistik['total_pengguna'] = $this->Model_pengguna->hitung_total_pengguna();
        $statistik['pengguna_aktif'] = $this->Model_pengguna->hitung_pengguna_by_status('aktif');

        // Total template dan jenis dokumen
        $statistik['total_template'] = $this->Model_template_dokumen->hitung_total_template();
        $statistik['total_jenis_dokumen'] = $this->Model_jenis_dokumen->hitung_total_jenis_dokumen();

        // Total submission
        $statistik['total_submission'] = $this->Model_submission->hitung_total_submission();

        return $statistik;
    }

    /**
     * Ambil statistik submission
     */
    private function _ambil_statistik_submission($filter) {
        $statistik = array();

        $statistik['pending'] = $this->Model_submission->hitung_submission_by_status('pending');
        $statistik['diproses'] = $this->Model_submission->hitung_submission_by_status('diproses');
        $statistik['disetujui'] = $this->Model_submission->hitung_submission_by_status('disetujui');
        $statistik['ditolak'] = $this->Model_submission->hitung_submission_by_status('ditolak');

        return $statistik;
    }

    /**
     * Ambil statistik pengguna
     */
    private function _ambil_statistik_pengguna($filter) {
        return $this->Model_pengguna->hitung_pengguna_by_role();
    }

    /**
     * Data chart submission berdasarkan status
     */
    private function _chart_submission_status($filter) {
        $statistik = $this->_ambil_statistik_submission($filter);

        return array(
            'labels' => array('Pending', 'Diproses', 'Disetujui', 'Ditolak'),
            'data' => array(
                $statistik['pending'],
                $statistik['diproses'],
                $statistik['disetujui'],
                $statistik['ditolak']
            )
        );
    }
}
