<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dokumen untuk User
 * Menangani daftar template dokumen dan submission user
 */
class Dokumen extends CI_Controller {

    public function __construct() {
        parent::__construct();

        
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

        
        $config['base_url'] = base_url('user/dokumen/index');
        $filter = $this->_get_filter();
        $filter['status'] = 'aktif'; 
        $config['total_rows'] = $this->Model_template_dokumen->hitung_total_template($filter);
        $config['per_page'] = 12;
        $config['uri_segment'] = 4;

        
        $this->_setup_pagination($config);

        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;

        
        $data['templates'] = $this->Model_template_dokumen->ambil_semua_template($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];

        
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

        
        $data['field_template'] = $this->Model_template_dokumen->ambil_field_by_template($id_template);

        
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

        
        $config['base_url'] = base_url('user/dokumen/submission');
        $filter = $this->_get_filter();
        $filter['id_pengguna'] = $this->session->userdata('id_pengguna'); 
        $config['total_rows'] = $this->Model_submission->hitung_total_submission($filter);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;

        $this->_setup_pagination($config);

        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;

        
        $data['submission'] = $this->Model_submission->ambil_semua_submission($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];

        
        $data['statistik'] = array(
            'total' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'))),
            'pending' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'pending')),
            'diproses' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'diproses')),
            'disetujui' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'disetujui')),
            'ditolak' => $this->Model_submission->hitung_total_submission(array('id_pengguna' => $this->session->userdata('id_pengguna'), 'status' => 'ditolak'))
        );

        
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

        
        $data['data_submission'] = $this->Model_submission->ambil_data_submission($id_submission);

        
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

        
        if ($submission['status'] !== 'pending') {
            echo json_encode(array('success' => false, 'message' => 'Submission yang sudah diproses tidak dapat dihapus.'));
            return;
        }

        
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

        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Download file submission',
            "Download file {$field_name} dari submission {$submission['nomor_submission']}"
        );

        
        $this->load->helper('download');
        force_download($file_data['value'], file_get_contents($file_path));
    }

    /**
     * Edit submission (hanya jika status pending)
     */
    public function edit_submission($id_submission = null) {
        if (!$id_submission) {
            show_404();
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission || $submission['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            show_404();
        }

        
        if ($submission['status'] !== 'pending') {
            $this->session->set_flashdata('error_message', 'Submission ini tidak dapat diedit karena sudah diproses.');
            redirect('user/dokumen/detail_submission/' . $id_submission);
        }

        $template = $this->Model_template_dokumen->ambil_template_by_id($submission['id_template']);
        if (!$template) {
            show_404();
        }

        $data = array(
            'title' => 'Edit Submission - User Dashboard',
            'page_title' => 'Edit Submission: ' . $submission['nomor_submission'],
            'breadcrumb' => array(
                'Dashboard' => 'user/dashboard',
                'Submission Saya' => 'user/dokumen/submission',
                'Detail' => 'user/dokumen/detail_submission/' . $id_submission,
                'Edit' => ''
            ),
            'template' => $template,
            'submission' => $submission
        );

        
        $data['field_template'] = $this->Model_template_dokumen->ambil_field_by_template($submission['id_template']);
        $data['data_submission'] = $this->Model_submission->ambil_data_submission($id_submission);

        if ($this->input->post()) {
            if ($this->_validasi_form_submission($data['field_template'])) {
                $result = $this->_update_submission($id_submission, $template, $data['field_template']);

                if ($result['success']) {
                    $this->session->set_flashdata('success_message', 'Submission berhasil diperbarui.');
                    redirect('user/dokumen/detail_submission/' . $id_submission);
                } else {
                    $this->session->set_flashdata('error_message', $result['message']);
                }
            }
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/submission/edit', $data);
        $this->load->view('template/footer', $data);
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

    /**
     * Validasi form submission
     */
    private function _validasi_form_submission($field_template) {
        $this->load->library('form_validation');

        foreach ($field_template as $field) {
            $rules = array();

            if ($field['wajib_diisi']) {
                $rules[] = 'required';
            }

            switch ($field['tipe_field']) {
                case 'text':
                    $rules[] = 'max_length[255]';
                    break;
                case 'textarea':
                    $rules[] = 'max_length[1000]';
                    break;
                case 'number':
                    $rules[] = 'numeric';
                    break;
                case 'date':
                    $rules[] = 'valid_date';
                    break;
            }

            if (!empty($field['validasi'])) {
                $rules[] = $field['validasi'];
            }

            $this->form_validation->set_rules(
                'field_' . $field['id_field'],
                $field['nama_field'],
                implode('|', $rules)
            );
        }

        
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('valid_date', '{field} harus berupa tanggal yang valid.');

        return $this->form_validation->run();
    }

    /**
     * Update submission yang sudah ada
     */
    private function _update_submission($id_submission, $template, $field_template) {
        $this->load->library('upload');

        
        $this->Model_submission->hapus_data_submission($id_submission);

        $data_fields = array();
        $uploaded_files = array();

        foreach ($field_template as $field) {
            $field_name = 'field_' . $field['id_field'];

            if ($field['tipe_field'] === 'file') {
                
                if (!empty($_FILES[$field_name]['name'])) {
                    $upload_result = $this->_upload_file($field_name, $template);
                    if ($upload_result['success']) {
                        $uploaded_files[] = $upload_result['file_name'];
                        $data_fields[] = array(
                            'id_field' => $field['id_field'],
                            'nama_field' => $field['nama_field'],
                            'tipe_field' => $field['tipe_field'],
                            'value' => $upload_result['file_name']
                        );
                    } else {
                        
                        foreach ($uploaded_files as $file) {
                            $file_path = './uploads/dokumen/' . $file;
                            if (file_exists($file_path)) {
                                unlink($file_path);
                            }
                        }
                        return array('success' => false, 'message' => $upload_result['message']);
                    }
                } else {
                    
                    $old_data = $this->Model_submission->ambil_data_submission_by_field($id_submission, $field['id_field']);
                    if ($old_data) {
                        $data_fields[] = array(
                            'id_field' => $field['id_field'],
                            'nama_field' => $field['nama_field'],
                            'tipe_field' => $field['tipe_field'],
                            'value' => $old_data['value']
                        );
                    }
                }
            } else {
                
                $value = $this->input->post($field_name);
                $data_fields[] = array(
                    'id_field' => $field['id_field'],
                    'nama_field' => $field['nama_field'],
                    'tipe_field' => $field['tipe_field'],
                    'value' => $value
                );
            }
        }

        
        if ($this->Model_submission->tambah_data_submission($id_submission, $data_fields)) {
            
            $this->Model_submission->update_submission($id_submission, array(
                'tanggal_submission' => date('Y-m-d H:i:s')
            ));

            
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Memperbarui submission',
                'Template: ' . $template['nama_template']
            );

            return array('success' => true, 'id_submission' => $id_submission);
        } else {
            
            foreach ($uploaded_files as $file) {
                $file_path = './uploads/dokumen/' . $file;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            return array('success' => false, 'message' => 'Gagal memperbarui submission.');
        }
    }

    /**
     * Upload file untuk field tertentu
     */
    private function _upload_file($field_name, $template) {
        $config['upload_path'] = './uploads/dokumen/';
        $config['allowed_types'] = str_replace(',', '|', $template['tipe_file_diizinkan']);
        $config['max_size'] = $template['max_ukuran_file'] * 1024; 
        $config['encrypt_name'] = TRUE;

        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($field_name)) {
            return array('success' => false, 'message' => $this->upload->display_errors('', ''));
        }

        $upload_data = $this->upload->data();
        return array('success' => true, 'file_name' => $upload_data['file_name']);
    }
}
