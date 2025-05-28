<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Submission untuk User
 * Menangani pembuatan dan pengelolaan submission dokumen
 */
class Submission extends CI_Controller {

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
        $this->load->model('Model_submission');
        $this->load->model('Model_log_aktivitas');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    /**
     * Form buat submission baru
     */
    public function buat($id_template = null) {
        if (!$id_template) {
            show_404();
        }

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template || $template['status'] !== 'aktif') {
            show_404();
        }

        $data = array(
            'title' => 'Buat Submission - User Dashboard',
            'page_title' => 'Buat Submission: ' . $template['nama_template'],
            'breadcrumb' => array(
                'Dashboard' => 'user/dashboard',
                'Daftar Dokumen' => 'user/dokumen',
                'Detail Template' => 'user/dokumen/detail/' . $id_template,
                'Buat Submission' => ''
            ),
            'template' => $template
        );

        // Ambil field template
        $data['field_template'] = $this->Model_template_dokumen->ambil_field_by_template($id_template);

        if ($this->input->post()) {
            if ($this->_validasi_form_submission($data['field_template'])) {
                $result = $this->_proses_submission($template, $data['field_template']);

                if ($result['success']) {
                    $this->session->set_flashdata('success', 'Submission berhasil dibuat dengan nomor: ' . $result['nomor_submission']);
                    redirect('user/dokumen/detail_submission/' . $result['id_submission']);
                } else {
                    $this->session->set_flashdata('error', $result['message']);
                }
            }
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/submission/buat', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Edit submission (hanya jika status pending)
     */
    public function edit($id_submission = null) {
        if (!$id_submission) {
            show_404();
        }

        $submission = $this->Model_submission->ambil_submission_by_id($id_submission);
        if (!$submission || $submission['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            show_404();
        }

        // Hanya bisa edit jika status pending
        if ($submission['status'] !== 'pending') {
            $this->session->set_flashdata('error', 'Submission yang sudah diproses tidak dapat diedit.');
            redirect('user/dokumen/detail_submission/' . $id_submission);
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
            'submission' => $submission
        );

        // Ambil field template dan data submission
        $data['field_template'] = $this->Model_template_dokumen->ambil_field_by_template($submission['id_template']);
        $data['data_submission'] = $this->Model_submission->ambil_data_submission($id_submission);

        // Convert data submission ke format yang mudah diakses
        $data['submission_values'] = array();
        foreach ($data['data_submission'] as $field_data) {
            $data['submission_values'][$field_data['nama_field']] = $field_data['value'];
        }

        if ($this->input->post()) {
            if ($this->_validasi_form_submission($data['field_template'], 'edit')) {
                $result = $this->_proses_edit_submission($submission, $data['field_template']);

                if ($result['success']) {
                    $this->session->set_flashdata('success', 'Submission berhasil diperbarui.');
                    redirect('user/dokumen/detail_submission/' . $id_submission);
                } else {
                    $this->session->set_flashdata('error', $result['message']);
                }
            }
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/submission/edit', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Validasi form submission
     */
    private function _validasi_form_submission($field_template, $mode = 'buat') {
        foreach ($field_template as $field) {
            $rules = '';

            if ($field['wajib_diisi']) {
                if ($field['tipe_field'] === 'file' && $mode === 'edit') {
                    // File tidak wajib saat edit jika sudah ada file sebelumnya
                    $rules = 'trim';
                } else {
                    $rules = 'required';
                }
            } else {
                $rules = 'trim';
            }

            // Validasi khusus berdasarkan tipe field
            switch ($field['tipe_field']) {
                case 'email':
                    if ($field['wajib_diisi']) {
                        $rules .= '|valid_email';
                    } else {
                        $rules .= '|valid_email';
                    }
                    break;
                case 'number':
                    if ($field['wajib_diisi']) {
                        $rules .= '|numeric';
                    } else {
                        $rules .= '|numeric';
                    }
                    break;
                case 'url':
                    if ($field['wajib_diisi']) {
                        $rules .= '|valid_url';
                    } else {
                        $rules .= '|valid_url';
                    }
                    break;
            }

            $this->form_validation->set_rules($field['nama_field'], $field['nama_field'], $rules);
        }

        // Set pesan error dalam bahasa Indonesia
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('valid_email', '{field} harus berupa email yang valid.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('valid_url', '{field} harus berupa URL yang valid.');

        return $this->form_validation->run();
    }

    /**
     * Proses submission baru
     */
    private function _proses_submission($template, $field_template) {
        $this->db->trans_start();

        // Generate nomor submission
        $nomor_submission = $this->Model_submission->generate_nomor_submission();

        // Data submission utama
        $data_submission = array(
            'nomor_submission' => $nomor_submission,
            'id_template' => $template['id_template'],
            'id_pengguna' => $this->session->userdata('id_pengguna'),
            'status' => 'pending',
            'tanggal_submission' => date('Y-m-d H:i:s')
        );

        // Proses data field
        $data_field = array();
        $uploaded_files = array();

        foreach ($field_template as $field) {
            $field_value = '';

            if ($field['tipe_field'] === 'file') {
                // Handle upload file
                if (!empty($_FILES[$field['nama_field']]['name'])) {
                    $upload_result = $this->_upload_file($field['nama_field']);
                    if ($upload_result['success']) {
                        $field_value = $upload_result['file_name'];
                        $uploaded_files[] = $upload_result['file_name'];
                    } else {
                        // Rollback jika ada error upload
                        foreach ($uploaded_files as $file) {
                            if (file_exists('./uploads/dokumen/' . $file)) {
                                unlink('./uploads/dokumen/' . $file);
                            }
                        }
                        return array('success' => false, 'message' => $upload_result['error']);
                    }
                }
            } else {
                $field_value = $this->input->post($field['nama_field']);
            }

            $data_field[] = array(
                'id_field' => $field['id_field'],
                'nilai_field' => $field_value
            );
        }

        // Simpan submission
        $id_submission = $this->Model_submission->tambah_submission($data_submission, $data_field);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE || !$id_submission) {
            // Hapus file yang sudah diupload jika transaksi gagal
            foreach ($uploaded_files as $file) {
                if (file_exists('./uploads/dokumen/' . $file)) {
                    unlink('./uploads/dokumen/' . $file);
                }
            }
            return array('success' => false, 'message' => 'Gagal menyimpan submission.');
        }

        // Log aktivitas
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Membuat submission baru',
            "Membuat submission {$nomor_submission} untuk template {$template['nama_template']}"
        );

        return array(
            'success' => true,
            'id_submission' => $id_submission,
            'nomor_submission' => $nomor_submission
        );
    }

    /**
     * Proses edit submission
     */
    private function _proses_edit_submission($submission, $field_template) {
        $this->db->trans_start();

        // Ambil data submission lama
        $data_submission_lama = $this->Model_submission->ambil_data_submission($submission['id_submission']);
        $file_lama = array();
        foreach ($data_submission_lama as $data) {
            if ($data['tipe_field'] === 'file') {
                $file_lama[$data['nama_field']] = $data['value'];
            }
        }

        // Proses data field baru
        $data_field = array();
        $uploaded_files = array();

        foreach ($field_template as $field) {
            $field_value = '';

            if ($field['tipe_field'] === 'file') {
                // Handle upload file
                if (!empty($_FILES[$field['nama_field']]['name'])) {
                    $upload_result = $this->_upload_file($field['nama_field']);
                    if ($upload_result['success']) {
                        $field_value = $upload_result['file_name'];
                        $uploaded_files[] = $upload_result['file_name'];

                        // Hapus file lama jika ada
                        if (!empty($file_lama[$field['nama_field']])) {
                            $old_file = './uploads/dokumen/' . $file_lama[$field['nama_field']];
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                    } else {
                        // Rollback jika ada error upload
                        foreach ($uploaded_files as $file) {
                            if (file_exists('./uploads/dokumen/' . $file)) {
                                unlink('./uploads/dokumen/' . $file);
                            }
                        }
                        return array('success' => false, 'message' => $upload_result['error']);
                    }
                } else {
                    // Gunakan file lama jika tidak ada upload baru
                    $field_value = $file_lama[$field['nama_field']] ?? '';
                }
            } else {
                $field_value = $this->input->post($field['nama_field']);
            }

            $data_field[] = array(
                'id_field' => $field['id_field'],
                'nilai_field' => $field_value
            );
        }

        // Update submission
        $data_update = array(
            'tanggal_submission' => date('Y-m-d H:i:s') // Update timestamp
        );

        $result = $this->Model_submission->update_submission($submission['id_submission'], $data_update, $data_field);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE || !$result) {
            // Hapus file baru yang sudah diupload jika transaksi gagal
            foreach ($uploaded_files as $file) {
                if (file_exists('./uploads/dokumen/' . $file)) {
                    unlink('./uploads/dokumen/' . $file);
                }
            }
            return array('success' => false, 'message' => 'Gagal memperbarui submission.');
        }

        // Log aktivitas
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Mengedit submission',
            "Mengedit submission {$submission['nomor_submission']}"
        );

        return array('success' => true);
    }

    /**
     * Upload file
     */
    private function _upload_file($field_name) {
        $config['upload_path'] = './uploads/dokumen/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|jpg|jpeg|png|gif';
        $config['max_size'] = 10240; // 10MB
        $config['encrypt_name'] = TRUE;

        // Buat direktori jika belum ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            return array(
                'success' => true,
                'file_name' => $this->upload->data('file_name'),
                'file_size' => $this->upload->data('file_size')
            );
        } else {
            return array(
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            );
        }
    }
}
