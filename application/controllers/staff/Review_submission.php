<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Review Submission untuk Staff
 * Menangani review dan approval submission dokumen dari user
 */
class Review_submission extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Cek apakah user sudah login dan memiliki role staff
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'staff') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
        
        $this->load->model('Model_submission');
        $this->load->model('Model_template_dokumen');
        $this->load->model('Model_pengguna');
        $this->load->model('Model_log_aktivitas');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    /**
     * Halaman daftar submission untuk review
     */
    public function index() {
        $data = array(
            'title' => 'Review Submission - Staff Dashboard',
            'page_title' => 'Review Submission Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Review Submission' => ''
            )
        );

        // Konfigurasi pagination
        $config['base_url'] = base_url('staff/review_submission/index');
        $filter = $this->_get_filter();
        $config['total_rows'] = $this->Model_submission->hitung_total_submission($filter);
        $config['per_page'] = 15;
        $config['uri_segment'] = 4;
        
        // Styling pagination dengan Flowbite
        $this->_setup_pagination($config);
        
        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        // Ambil data submission
        $data['submission'] = $this->Model_submission->ambil_semua_submission($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];
        
        // Statistik submission
        $data['statistik'] = array(
            'pending' => $this->Model_submission->hitung_submission_by_status('pending'),
            'diproses' => $this->Model_submission->hitung_submission_by_status('diproses'),
            'disetujui' => $this->Model_submission->hitung_submission_by_status('disetujui'),
            'ditolak' => $this->Model_submission->hitung_submission_by_status('ditolak'),
            'saya_proses' => $this->Model_submission->hitung_total_submission(array('diproses_oleh' => $this->session->userdata('id_pengguna')))
        );
        
        // Data untuk dropdown filter
        $data['template_list'] = $this->Model_template_dokumen->ambil_template_aktif();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/review_submission/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Detail submission untuk review
     */
    public function detail($id_submission = null) {
        if (!$id_submission) {
            show_404();
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission) {
            show_404();
        }

        $data = array(
            'title' => 'Detail Submission - Staff Dashboard',
            'page_title' => 'Detail Submission: ' . $submission['nomor_submission'],
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Review Submission' => 'staff/review_submission',
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
        $this->load->view('staff/review_submission/detail', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Proses review submission (approve/reject)
     */
    public function proses($id_submission = null) {
        if (!$id_submission) {
            show_404();
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission) {
            show_404();
        }

        // Cek apakah submission masih bisa diproses
        if (!in_array($submission['status'], array('pending', 'diproses'))) {
            $this->session->set_flashdata('error', 'Submission ini sudah tidak dapat diproses lagi.');
            redirect('staff/review_submission/detail/' . $id_submission);
        }

        $data = array(
            'title' => 'Proses Submission - Staff Dashboard',
            'page_title' => 'Proses Submission: ' . $submission['nomor_submission'],
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Review Submission' => 'staff/review_submission',
                'Detail' => 'staff/review_submission/detail/' . $id_submission,
                'Proses' => ''
            ),
            'submission' => $submission
        );

        if ($this->input->post()) {
            $this->_validasi_form_proses();
            
            if ($this->form_validation->run() === TRUE) {
                $status_baru = $this->input->post('status');
                $catatan = $this->input->post('catatan_staff');
                
                $data_update = array(
                    'status' => $status_baru,
                    'catatan_staff' => $catatan,
                    'diproses_oleh' => $this->session->userdata('id_pengguna'),
                    'tanggal_diproses' => date('Y-m-d H:i:s')
                );

                if ($this->Model_submission->update_submission($id_submission, $data_update)) {
                    // Log aktivitas
                    $this->Model_log_aktivitas->tambah_log(
                        $this->session->userdata('id_pengguna'),
                        'Memproses submission',
                        "Submission {$submission['nomor_submission']} diubah status menjadi $status_baru"
                    );
                    
                    // Kirim notifikasi email ke user (opsional)
                    $this->_kirim_notifikasi_email($submission, $status_baru, $catatan);
                    
                    $this->session->set_flashdata('success', 'Submission berhasil diproses.');
                    redirect('staff/review_submission');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memproses submission.');
                }
            }
        }

        // Ambil data field submission untuk ditampilkan
        $data['data_submission'] = $this->Model_submission->ambil_data_submission($id_submission);
        $data['field_template'] = $this->Model_template_dokumen->ambil_field_by_template($submission['id_template']);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/review_submission/proses', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Ambil submission untuk diproses (AJAX)
     */
    public function ambil_submission() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_submission = $this->input->post('id_submission');
        
        if (!$id_submission) {
            echo json_encode(array('success' => false, 'message' => 'ID submission tidak valid.'));
            return;
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission) {
            echo json_encode(array('success' => false, 'message' => 'Submission tidak ditemukan.'));
            return;
        }

        // Cek apakah submission masih pending
        if ($submission['status'] !== 'pending') {
            echo json_encode(array('success' => false, 'message' => 'Submission ini sudah tidak dapat diambil.'));
            return;
        }

        // Update status menjadi diproses
        $data_update = array(
            'status' => 'diproses',
            'diproses_oleh' => $this->session->userdata('id_pengguna'),
            'tanggal_diproses' => date('Y-m-d H:i:s')
        );

        if ($this->Model_submission->update_submission($id_submission, $data_update)) {
            // Log aktivitas
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Mengambil submission untuk diproses',
                "Submission {$submission['nomor_submission']} diambil untuk diproses"
            );

            echo json_encode(array('success' => true, 'message' => 'Submission berhasil diambil untuk diproses.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mengambil submission.'));
        }
    }

    /**
     * Kembalikan submission ke status pending (AJAX)
     */
    public function kembalikan_submission() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_submission = $this->input->post('id_submission');
        
        if (!$id_submission) {
            echo json_encode(array('success' => false, 'message' => 'ID submission tidak valid.'));
            return;
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission) {
            echo json_encode(array('success' => false, 'message' => 'Submission tidak ditemukan.'));
            return;
        }

        // Cek apakah submission sedang diproses oleh staff ini
        if ($submission['status'] !== 'diproses' || $submission['diproses_oleh'] != $this->session->userdata('id_pengguna')) {
            echo json_encode(array('success' => false, 'message' => 'Anda tidak dapat mengembalikan submission ini.'));
            return;
        }

        // Update status kembali ke pending
        $data_update = array(
            'status' => 'pending',
            'diproses_oleh' => null,
            'tanggal_diproses' => null
        );

        if ($this->Model_submission->update_submission($id_submission, $data_update)) {
            // Log aktivitas
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Mengembalikan submission ke pending',
                "Submission {$submission['nomor_submission']} dikembalikan ke status pending"
            );

            echo json_encode(array('success' => true, 'message' => 'Submission berhasil dikembalikan ke status pending.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mengembalikan submission.'));
        }
    }

    /**
     * Download file submission
     */
    public function download_file($id_submission, $field_name) {
        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission) {
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
     * Mendapatkan filter dari input GET
     */
    private function _get_filter() {
        return array(
            'status' => $this->input->get('status'),
            'id_template' => $this->input->get('id_template'),
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
     * Validasi form proses submission
     */
    private function _validasi_form_proses() {
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[disetujui,ditolak]');
        $this->form_validation->set_rules('catatan_staff', 'Catatan', 'required|min_length[10]|max_length[1000]');

        // Set pesan error dalam bahasa Indonesia
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('in_list', '{field} tidak valid.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter.');
    }

    /**
     * Kirim notifikasi email ke user (opsional)
     */
    private function _kirim_notifikasi_email($submission, $status, $catatan) {
        // Implementasi pengiriman email notifikasi
        // Bisa menggunakan library email CodeIgniter
        // Untuk saat ini hanya log saja
        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Kirim notifikasi email',
            "Notifikasi status $status untuk submission {$submission['nomor_submission']} ke {$submission['email_pengguna']}"
        );
    }
}
