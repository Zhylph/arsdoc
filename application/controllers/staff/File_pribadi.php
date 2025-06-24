<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller File Pribadi untuk Staff
 * Menampilkan semua file pribadi yang diupload oleh user
 */
class File_pribadi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load model yang diperlukan
        $this->load->model('Model_file_pribadi');
        $this->load->model('Model_pengguna');
        $this->load->library('pagination');
        
        // Cek autentikasi
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        // Cek role
        if ($this->session->userdata('role') !== 'staff') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    /**
     * Halaman utama daftar file pribadi user
     */
    public function index() {
        // Ambil parameter filter
        $filter = array();
        
        if ($this->input->get('pencarian')) {
            $filter['pencarian'] = $this->input->get('pencarian');
        }
        
        if ($this->input->get('id_pengguna')) {
            $filter['id_pengguna'] = $this->input->get('id_pengguna');
        }
        
        if ($this->input->get('tipe_file')) {
            $filter['tipe_file'] = $this->input->get('tipe_file');
        }
        
        // Konfigurasi pagination
        $config['base_url'] = site_url('staff/file_pribadi');
        $config['total_rows'] = $this->Model_file_pribadi->hitung_total_file_dengan_user($filter);
        $config['per_page'] = 20;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        
        // Styling pagination
        $config['full_tag_open'] = '<nav class="flex items-center justify-between pt-4" aria-label="Table navigation"><ul class="inline-flex -space-x-px text-sm h-8">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = '«';
        $config['first_tag_open'] = '<li><a href="#" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">';
        $config['first_tag_close'] = '</a></li>';
        $config['last_link'] = '»';
        $config['last_tag_open'] = '<li><a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">';
        $config['last_tag_close'] = '</a></li>';
        $config['next_link'] = '>';
        $config['next_tag_open'] = '<li><a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">';
        $config['next_tag_close'] = '</a></li>';
        $config['prev_link'] = '<';
        $config['prev_tag_open'] = '<li><a href="#" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">';
        $config['prev_tag_close'] = '</a></li>';
        $config['cur_tag_open'] = '<li><a href="#" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li><a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">';
        $config['num_tag_close'] = '</a></li>';
        
        $this->pagination->initialize($config);
        
        // Ambil data file pribadi
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $offset = $page * $config['per_page'];
        
        $data['file_pribadi'] = $this->Model_file_pribadi->ambil_semua_file_dengan_user($filter, $config['per_page'], $offset);
        
        // Ambil daftar user untuk filter
        $data['daftar_user'] = $this->Model_pengguna->ambil_semua_pengguna(array('role' => 'user'));
        
        // Data untuk view
        $data['title'] = 'File Pribadi User - Sistem Arsip Dokumen';
        $data['page_title'] = 'File Pribadi User';
        $data['breadcrumb'] = array(
            'Dashboard' => 'staff/dashboard',
            'File Pribadi User' => ''
        );
        $data['filter'] = $filter;
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['current_page'] = $page + 1;
        $data['per_page'] = $config['per_page'];
        
        // Load view
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/file_pribadi/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Download file pribadi
     */
    public function download($id_file) {
        // Ambil data file
        $file = $this->Model_file_pribadi->ambil_file_by_id($id_file);
        
        if (!$file) {
            show_404();
        }
        
        $file_path = FCPATH . 'uploads/file_pribadi/' . $file['nama_file_sistem'];
        
        if (!file_exists($file_path)) {
            show_404();
        }
        
        // Update counter download
        $this->Model_file_pribadi->update_counter_download($id_file);
        
        // Log aktivitas
        $this->_log_aktivitas('download_file_pribadi', 'Download file pribadi: ' . $file['nama_file']);
        
        // Download file
        $this->load->helper('download');
        force_download($file['nama_file'], file_get_contents($file_path));
    }

    /**
     * Hapus file pribadi
     */
    public function hapus() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id_file = $this->input->post('id_file');
        
        if (!$id_file) {
            $response = array(
                'success' => false,
                'message' => 'ID file tidak valid.'
            );
            echo json_encode($response);
            return;
        }
        
        // Ambil data file
        $file = $this->Model_file_pribadi->ambil_file_by_id($id_file);
        
        if (!$file) {
            $response = array(
                'success' => false,
                'message' => 'File tidak ditemukan.'
            );
            echo json_encode($response);
            return;
        }
        
        // Hapus file fisik
        $file_path = FCPATH . 'uploads/file_pribadi/' . $file['nama_file_sistem'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Hapus dari database
        if ($this->Model_file_pribadi->hapus_file($id_file)) {
            // Log aktivitas
            $this->_log_aktivitas('hapus_file_pribadi', 'Hapus file pribadi: ' . $file['nama_file']);
            
            $response = array(
                'success' => true,
                'message' => 'File berhasil dihapus.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Gagal menghapus file.'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Log aktivitas
     */
    private function _log_aktivitas($jenis_aktivitas, $deskripsi) {
        $this->load->model('Model_log_aktivitas');
        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            $jenis_aktivitas,
            $deskripsi
        );
    }

    /**
     * Menampilkan detail file pribadi user
     */
    public function detail($id_file) {
        $file = $this->Model_file_pribadi->ambil_file_by_id($id_file);
        if (!$file) {
            show_404();
        }
        $this->load->model('Model_pengguna');
        $user = $this->Model_pengguna->ambil_pengguna_by_id($file['id_pengguna']);
        $data = [
            'file' => $file,
            'user' => $user,
            'title' => 'Detail File Pribadi',
            'page_title' => 'Detail File Pribadi',
            'breadcrumb' => [
                'Dashboard' => 'staff/dashboard',
                'File Pribadi User' => 'staff/file_pribadi',
                'Detail File' => ''
            ]
        ];
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/file_pribadi/detail', $data);
        $this->load->view('template/footer', $data);
    }
} 