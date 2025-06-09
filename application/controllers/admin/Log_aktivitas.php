<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Log Aktivitas untuk Admin
 * Menangani monitoring dan pengelolaan log aktivitas sistem
 */
class Log_aktivitas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
        
        $this->load->model('Model_log_aktivitas');
        $this->load->model('Model_pengguna');
        $this->load->helper('url');
    }

    /**
     * Halaman utama log aktivitas
     */
    public function index() {
        $data = array(
            'title' => 'Log Aktivitas - Admin Dashboard',
            'page_title' => 'Log Aktivitas Sistem',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Log Aktivitas' => ''
            )
        );

        
        $config['base_url'] = base_url('admin/log_aktivitas/index');
        $filter = $this->_get_filter();
        $config['total_rows'] = $this->Model_log_aktivitas->hitung_total_log($filter);
        $config['per_page'] = 25;
        $config['uri_segment'] = 4;
        
        
        $this->_setup_pagination($config);
        
        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        
        $data['log_aktivitas'] = $this->Model_log_aktivitas->ambil_semua_log($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];
        
        
        $data['statistik'] = $this->Model_log_aktivitas->ambil_ringkasan_aktivitas();
        
        
        $data['pengguna_list'] = $this->Model_pengguna->ambil_semua_pengguna();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/log_aktivitas/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Detail log aktivitas
     */
    public function detail($id_log = null) {
        if (!$id_log) {
            show_404();
        }

        $log = $this->Model_log_aktivitas->ambil_log_by_id($id_log);
        if (!$log) {
            show_404();
        }

        $data = array(
            'title' => 'Detail Log Aktivitas - Admin Dashboard',
            'page_title' => 'Detail Log Aktivitas',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Log Aktivitas' => 'admin/log_aktivitas',
                'Detail' => ''
            ),
            'log' => $log
        );

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/log_aktivitas/detail', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Statistik aktivitas
     */
    public function statistik() {
        $data = array(
            'title' => 'Statistik Aktivitas - Admin Dashboard',
            'page_title' => 'Statistik Log Aktivitas',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Log Aktivitas' => 'admin/log_aktivitas',
                'Statistik' => ''
            )
        );

        
        $data['statistik_umum'] = $this->Model_log_aktivitas->ambil_ringkasan_aktivitas();
        
        
        $data['aktivitas_populer'] = $this->Model_log_aktivitas->ambil_aktivitas_populer(15);
        
        
        $data['statistik_harian'] = $this->Model_log_aktivitas->ambil_statistik_harian(7);
        
        
        $data['ukuran_tabel'] = $this->Model_log_aktivitas->ambil_ukuran_tabel();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/log_aktivitas/statistik', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Export log aktivitas
     */
    public function export() {
        $format = $this->input->get('format', 'csv');
        $filter = $this->_get_filter();
        
        if ($format === 'csv') {
            $this->Model_log_aktivitas->export_log($filter);
        } else {
            
            $log_aktivitas = $this->Model_log_aktivitas->ambil_semua_log($filter);
            
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="log_aktivitas_' . date('Y-m-d') . '.xls"');
            header('Cache-Control: max-age=0');

            
            $data['log_aktivitas'] = $log_aktivitas;
            $data['filter'] = $filter;
            $this->load->view('admin/log_aktivitas/export', $data);
        }
    }

    /**
     * Hapus log lama
     */
    public function hapus_log_lama() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $hari = $this->input->post('hari', 90);
        
        if (!is_numeric($hari) || $hari < 1) {
            echo json_encode(array('success' => false, 'message' => 'Jumlah hari tidak valid.'));
            return;
        }

        $result = $this->Model_log_aktivitas->hapus_log_lama($hari);
        
        if ($result) {
            
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Hapus log aktivitas lama',
                "Menghapus log aktivitas lebih dari $hari hari"
            );

            echo json_encode(array('success' => true, 'message' => "Log aktivitas lebih dari $hari hari berhasil dihapus."));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus log aktivitas lama.'));
        }
    }

    /**
     * Hapus semua log aktivitas
     */
    public function hapus_semua_log() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $konfirmasi = $this->input->post('konfirmasi');
        
        if ($konfirmasi !== 'HAPUS SEMUA LOG') {
            echo json_encode(array('success' => false, 'message' => 'Konfirmasi tidak sesuai.'));
            return;
        }

        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Hapus semua log aktivitas',
            'Menghapus semua log aktivitas sistem'
        );

        
        $this->db->where('id_log <', $this->db->insert_id());
        $result = $this->db->delete('log_aktivitas');

        if ($result) {
            echo json_encode(array('success' => true, 'message' => 'Semua log aktivitas berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus log aktivitas.'));
        }
    }

    /**
     * API untuk data chart aktivitas (AJAX)
     */
    public function chart_data() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $type = $this->input->get('type');
        
        switch ($type) {
            case 'aktivitas_harian':
                $hari = $this->input->get('hari', 7);
                $data = $this->Model_log_aktivitas->ambil_statistik_harian($hari);
                break;
                
            case 'aktivitas_populer':
                $limit = $this->input->get('limit', 10);
                $result = $this->Model_log_aktivitas->ambil_aktivitas_populer($limit);
                $data = array(
                    'labels' => array_column($result, 'aktivitas'),
                    'data' => array_column($result, 'jumlah')
                );
                break;
                
            case 'aktivitas_by_role':
                $data = $this->_chart_aktivitas_by_role();
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
            'id_pengguna' => $this->input->get('id_pengguna'),
            'role' => $this->input->get('role'),
            'aktivitas' => $this->input->get('aktivitas'),
            'tanggal_dari' => $this->input->get('tanggal_dari'),
            'tanggal_sampai' => $this->input->get('tanggal_sampai'),
            'pencarian' => $this->input->get('pencarian')
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
     * Data chart aktivitas berdasarkan role
     */
    private function _chart_aktivitas_by_role() {
        $this->db->select('p.role, COUNT(la.id_log) as jumlah');
        $this->db->from('log_aktivitas la');
        $this->db->join('pengguna p', 'la.id_pengguna = p.id_pengguna');
        $this->db->where('DATE(la.tanggal_aktivitas) >=', date('Y-m-d', strtotime('-30 days')));
        $this->db->group_by('p.role');
        $this->db->order_by('jumlah', 'DESC');
        
        $result = $this->db->get()->result_array();
        
        return array(
            'labels' => array_map('ucfirst', array_column($result, 'role')),
            'data' => array_column($result, 'jumlah')
        );
    }
}
