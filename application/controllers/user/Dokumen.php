<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dokumen untuk User
 * Menangani daftar template dokumen dan submission user
 */
class Dokumen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Cek apakah user sudah login dan memiliki role user
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'user') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
        
        $this->load->model('Model_template_dokumen');
        $this->load->model('Model_jenis_dokumen');
        $this->load->model('Model_submission');
        $this->load->model('Model_log_aktivitas');
        $this->load->helper('url');
    }

    /**
     * Halaman daftar template dokumen yang tersedia
     */
    public function index() {
        $data = array(
            'title' => 'Daftar Dokumen - User Dashboard',
            'page_title' => 'Daftar Template Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'user/dashboard',
                'Daftar Dokumen' => ''
            )
        );

        // Konfigurasi pagination
        $config['base_url'] = base_url('user/dokumen/index');
        $filter = $this->_get_filter();
        $filter['status'] = 'aktif'; // Hanya tampilkan template aktif
        $config['total_rows'] = $this->Model_template_dokumen->hitung_total_template($filter);
        $config['per_page'] = 12;
        $config['uri_segment'] = 4;
        
        // Styling pagination dengan Flowbite
        $this->_setup_pagination($config);
        
        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        // Ambil data template dokumen
        $data['template_dokumen'] = $this->Model_template_dokumen->ambil_semua_template($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];
        
        // Data untuk dropdown filter
        $data['jenis_dokumen'] = $this->Model_jenis_dokumen->ambil_jenis_aktif();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/dokumen/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Detail template dokumen
     */
    public function detail($id_template = null) {
        if (!$id_template) {
            show_404();
        }

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template || $template['status'] !== 'aktif') {
            show_404();
        }

        $data = array(
            'title' => 'Detail Template - User Dashboard',
            'page_title' => 'Detail Template: ' . $template['nama_template'],
            'breadcrumb' => array(
                'Dashboard' => 'user/dashboard',
                'Daftar Dokumen' => 'user/dokumen',
                'Detail Template' => ''
            ),
            'template' => $template
        );

        // Ambil field template
        $data['field_template'] = $this->Model_template_dokumen->ambil_field_by_template($id_template);
        
        // Cek apakah user sudah pernah submit template ini
        $data['submission_user'] = $this->Model_submission->ambil_semua_submission(array(
            'id_template' => $id_template,
            'id_pengguna' => $this->session->userdata('id_pengguna')
        ));

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/dokumen/detail', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Halaman submission user
     */
    public function submission() {
        $data = array(
            'title' => 'Submission Saya - User Dashboard',
            'page_title' => 'Daftar Submission Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'user/dashboard',
                'Submission Saya' => ''
            )
        );

        // Konfigurasi pagination
        $config['base_url'] = base_url('user/dokumen/submission');
        $filter = $this->_get_filter();
        $filter['id_pengguna'] = $this->session->userdata('id_pengguna'); // Hanya submission user ini
        $config['total_rows'] = $this->Model_submission->hitung_total_submission($filter);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        
        $this->_setup_pagination($config);
        
        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        // Ambil data submission user
        $data['submission'] = $this->Model_submission->ambil_semua_submission($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];
        
        // Statistik submission user
        $data['statistik'] = array(
            'total' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'))),
            'pending' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'pending')),
            'diproses' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'diproses')),
            'disetujui' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'disetujui')),
            'ditolak' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'ditolak'))
        );
        
        // Data untuk dropdown filter
        $data['template_list'] = $this->Model_template_dokumen->ambil_template_aktif();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/dokumen/submission', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Detail submission user
     */
    public function detail_submission($id_submission = null) {
        if (!$id_submission) {
            show_404();
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission || $submission['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            show_404();
        }

        $data = array(
            'title' => 'Detail Submission - User Dashboard',
            'page_title' => 'Detail Submission: ' . $submission['nomor_submission'],
            'breadcrumb' => array(
                'Dashboard' => 'user/dashboard',
                'Submission Saya' => 'user/dokumen/submission',
                'Detail' => ''
            ),
            'submission' => $submission
        );

        // Ambil data field submission
        $data['data_submission'] = $this->Model_submission->ambil_data_submission($id_submission);
        
        // Ambil field template untuk referensi
        $data['field_template'] = $this->Model_template_dokumen->ambil_field_by_template($submission['id_template']);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/dokumen/detail_submission', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Hapus submission (hanya jika status pending)
     */
    public function hapus_submission() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_submission = $this->input->post('id_submission');
        
        if (!$id_submission) {
            echo json_encode(array('success' => false, 'message' => 'ID submission tidak valid.'));
            return;
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission || $submission['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            echo json_encode(array('success' => false, 'message' => 'Submission tidak ditemukan.'));
            return;
        }

        // Hanya bisa hapus jika status pending
        if ($submission['status'] !== 'pending') {
            echo json_encode(array('success' => false, 'message' => 'Submission yang sudah diproses tidak dapat dihapus.'));
            return;
        }

        // Hapus file yang diupload
        $data_submission = $this->Model_submission->ambil_data_submission($id_submission);
        foreach ($data_submission as $data) {
            if ($data['tipe_field'] === 'file' && !empty($data['value'])) {
                $file_path = './uploads/dokumen/' . $data['value'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }

        if ($this->Model_submission->hapus_submission($id_submission)) {
            // Log aktivitas
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Menghapus submission',
                "Menghapus submission {$submission['nomor_submission']}"
            );

            echo json_encode(array('success' => true, 'message' => 'Submission berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus submission.'));
        }
    }

    /**
     * Download file submission user
     */
    public function download_file($id_submission, $field_name) {
        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission || $submission['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            show_404();
        }

        $data_submission = $this->Model_submission->ambil_data_submission($id_submission);
        $file_data = null;

        foreach ($data_submission as $data) {
            if ($data['nama_field'] === $field_name && $data['tipe_field'] === 'file') {
                $file_data = $data;
                break;
            }
        }

        if (!$file_data || empty($file_data['value'])) {
            show_404();
        }

        $file_path = './uploads/dokumen/' . $file_data['value'];
        
        if (!file_exists($file_path)) {
            show_404();
        }

        // Log aktivitas
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Download file submission',
            "Download file {$field_name} dari submission {$submission['nomor_submission']}"
        );

        // Force download
        $this->load->helper('download');
        force_download($file_data['value'], file_get_contents($file_path));
    }

    /**
     * Pencarian template dokumen (AJAX)
     */
    public function cari_template() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $keyword = $this->input->get('q');
        $filter = array(
            'status' => 'aktif',
            'pencarian' => $keyword
        );

        $templates = $this->Model_template_dokumen->ambil_semua_template($filter, 10);
        
        $result = array();
        foreach ($templates as $template) {
            $result[] = array(
                'id' => $template['id_template'],
                'text' => $template['nama_template'] . ' - ' . $template['nama_jenis'],
                'description' => $template['deskripsi']
            );
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    /**
     * Mendapatkan filter dari input GET
     */
    private function _get_filter() {
        return array(
            'id_jenis' => $this->input->get('id_jenis'),
            'status' => $this->input->get('status'),
            'id_template' => $this->input->get('id_template'),
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
}
