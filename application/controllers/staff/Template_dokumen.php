<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Template Dokumen untuk Staff
 * Mengelola CRUD template dokumen dengan field dinamis
 */
class Template_dokumen extends CI_Controller {

    public function __construct() {
        parent::__construct();

        
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }

        if ($this->session->userdata('role') !== 'staff') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }

        $this->load->model('Model_template_dokumen');
        $this->load->model('Model_jenis_dokumen');
        $this->load->library('pagination');
        $this->load->helper('text');
    }

    /**
     * Halaman daftar template dokumen
     */
    public function index() {
        $data = array(
            'title' => 'Kelola Template Dokumen - Staff Dashboard',
            'page_title' => 'Kelola Template Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Template Dokumen' => ''
            )
        );

        
        $per_page = 10;
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;

        
        $filter = array();
        if ($this->input->get('status')) {
            $filter['status'] = $this->input->get('status');
        }
        if ($this->input->get('id_jenis')) {
            $filter['id_jenis'] = $this->input->get('id_jenis');
        }
        if ($this->input->get('pencarian')) {
            $filter['pencarian'] = $this->input->get('pencarian');
        }

        
        $data['template_dokumen'] = $this->Model_template_dokumen->ambil_semua_template($filter, $per_page, $offset);
        $total_rows = $this->Model_template_dokumen->hitung_semua_template($filter);

        
        $config['base_url'] = site_url('staff/template_dokumen');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;

        
        $config['full_tag_open'] = '<nav><ul class="flex items-center -space-x-px h-8 text-sm">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'Pertama';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Terakhir';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Selanjutnya';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Sebelumnya';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><span class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li><a class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700" href="';
        $config['num_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $total_rows;
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;

        
        $data['jenis_dokumen'] = $this->Model_jenis_dokumen->ambil_jenis_dokumen_aktif();

        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/template_dokumen/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Halaman tambah template dokumen
     */
    public function tambah() {
        $data = array(
            'title' => 'Tambah Template Dokumen - Staff Dashboard',
            'page_title' => 'Tambah Template Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Template Dokumen' => 'staff/template_dokumen',
                'Tambah' => ''
            )
        );

        
        $data['jenis_dokumen'] = $this->Model_jenis_dokumen->ambil_jenis_dokumen_aktif();

        
        $data['selected_jenis'] = $this->input->get('jenis');

        if ($this->input->post()) {
            $this->_proses_tambah();
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('staff/template_dokumen/tambah', $data);
            $this->load->view('template/footer', $data);
        }
    }

    /**
     * Halaman edit template dokumen
     */
    public function edit($id_template = null) {
        if (!$id_template) {
            show_404();
        }

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template) {
            show_404();
        }

        $data = array(
            'title' => 'Edit Template Dokumen - Staff Dashboard',
            'page_title' => 'Edit Template Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Template Dokumen' => 'staff/template_dokumen',
                'Edit' => ''
            ),
            'template' => $template,
            'fields' => $this->Model_template_dokumen->ambil_field_by_template($id_template),
            'jenis_dokumen' => $this->Model_jenis_dokumen->ambil_jenis_dokumen_aktif()
        );

        if ($this->input->post()) {
            $this->_proses_edit($id_template);
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('staff/template_dokumen/edit', $data);
            $this->load->view('template/footer', $data);
        }
    }

    /**
     * Halaman detail template dokumen
     */
    public function detail($id_template = null) {
        if (!$id_template) {
            show_404();
        }

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template) {
            show_404();
        }

        $data = array(
            'title' => 'Detail Template Dokumen - Staff Dashboard',
            'page_title' => 'Detail Template Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Template Dokumen' => 'staff/template_dokumen',
                'Detail' => ''
            ),
            'template' => $template,
            'fields' => $this->Model_template_dokumen->ambil_field_by_template($id_template),
            'submission_terbaru' => $this->Model_template_dokumen->ambil_submission_by_template($id_template, 10)
        );

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/template_dokumen/detail', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Proses tambah template dokumen
     */
    private function _proses_tambah() {
        $this->form_validation->set_rules('id_jenis', 'Jenis Dokumen', 'required|numeric');
        $this->form_validation->set_rules('nama_template', 'Nama Template', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');
        $this->form_validation->set_rules('instruksi_upload', 'Instruksi Upload', 'max_length[1000]');
        $this->form_validation->set_rules('max_ukuran_file', 'Maksimal Ukuran File', 'required|numeric|greater_than[0]|less_than_equal_to[10]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

        
        $id_jenis = $this->input->post('id_jenis');
        $nama_template = $this->input->post('nama_template');
        if ($id_jenis && $nama_template) {
            if (!$this->Model_template_dokumen->cek_nama_template_tersedia($nama_template, $id_jenis)) {
                $this->form_validation->set_rules('nama_template', 'Nama Template', 'callback_cek_nama_template_unik');
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            
            $tipe_file = $this->input->post('tipe_file_diizinkan');
            $max_ukuran_mb = $this->input->post('max_ukuran_file');
            $max_ukuran_bytes = $max_ukuran_mb * 1024 * 1024; 

            $data_template = array(
                'id_jenis' => $this->input->post('id_jenis'),
                'nama_template' => $this->input->post('nama_template'),
                'deskripsi' => $this->input->post('deskripsi'),
                'instruksi_upload' => $this->input->post('instruksi_upload'),
                'max_ukuran_file' => $max_ukuran_bytes,
                'tipe_file_diizinkan' => is_array($tipe_file) ? implode(',', $tipe_file) : '',
                'status' => $this->input->post('status'),
                'dibuat_oleh' => $this->session->userdata('id_pengguna')
            );

            
            $data_fields = $this->_proses_fields();

            $id_template = $this->Model_template_dokumen->tambah_template($data_template, $data_fields);

            if ($id_template) {
                
                $this->Model_template_dokumen->catat_aktivitas(
                    'Menambah template dokumen baru',
                    'Template: ' . $data_template['nama_template'],
                    $this->session->userdata('id_pengguna')
                );

                $this->session->set_flashdata('success_message', 'Template dokumen berhasil ditambahkan.');
                redirect('staff/template_dokumen/detail/' . $id_template);
            } else {
                $this->session->set_flashdata('error_message', 'Terjadi kesalahan saat menambah template dokumen.');
                $this->tambah();
            }
        }
    }

    /**
     * Proses edit template dokumen
     */
    private function _proses_edit($id_template) {
        $this->form_validation->set_rules('id_jenis', 'Jenis Dokumen', 'required|numeric');
        $this->form_validation->set_rules('nama_template', 'Nama Template', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');
        $this->form_validation->set_rules('instruksi_upload', 'Instruksi Upload', 'max_length[1000]');
        $this->form_validation->set_rules('max_ukuran_file', 'Maksimal Ukuran File', 'required|numeric|greater_than[0]|less_than_equal_to[10]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

        
        $id_jenis = $this->input->post('id_jenis');
        $nama_template = $this->input->post('nama_template');
        if ($id_jenis && $nama_template) {
            if (!$this->Model_template_dokumen->cek_nama_template_tersedia($nama_template, $id_jenis, $id_template)) {
                $this->form_validation->set_rules('nama_template', 'Nama Template', 'callback_cek_nama_template_unik');
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id_template);
        } else {
            
            $tipe_file = $this->input->post('tipe_file_diizinkan');
            $max_ukuran_mb = $this->input->post('max_ukuran_file');
            $max_ukuran_bytes = $max_ukuran_mb * 1024 * 1024; 

            $data_template = array(
                'id_jenis' => $this->input->post('id_jenis'),
                'nama_template' => $this->input->post('nama_template'),
                'deskripsi' => $this->input->post('deskripsi'),
                'instruksi_upload' => $this->input->post('instruksi_upload'),
                'max_ukuran_file' => $max_ukuran_bytes,
                'tipe_file_diizinkan' => is_array($tipe_file) ? implode(',', $tipe_file) : '',
                'status' => $this->input->post('status')
            );

            
            $data_fields = $this->_proses_fields();

            if ($this->Model_template_dokumen->update_template($id_template, $data_template, $data_fields)) {
                
                $this->Model_template_dokumen->catat_aktivitas(
                    'Mengupdate template dokumen',
                    'Template: ' . $data_template['nama_template'],
                    $this->session->userdata('id_pengguna')
                );

                $this->session->set_flashdata('success_message', 'Template dokumen berhasil diupdate.');
                redirect('staff/template_dokumen/detail/' . $id_template);
            } else {
                $this->session->set_flashdata('error_message', 'Terjadi kesalahan saat mengupdate template dokumen.');
                $this->edit($id_template);
            }
        }
    }

    /**
     * Proses data fields dari form
     */
    private function _proses_fields() {
        $fields = array();
        $fields_data = $this->input->post('fields');

        if ($fields_data && is_array($fields_data)) {
            foreach ($fields_data as $index => $field_data) {
                if (!empty($field_data['nama_field'])) {
                    
                    $wajib_diisi = ($field_data['wajib_diisi'] === 'ya') ? 1 : 0;

                    $fields[] = array(
                        'nama_field' => $field_data['nama_field'],
                        'tipe_field' => $field_data['tipe_field'],
                        'wajib_diisi' => $wajib_diisi,
                        'placeholder' => $field_data['placeholder'] ?? '',
                        'urutan' => $field_data['urutan'] ?? $index
                        
                        
                    );
                }
            }
        }

        return $fields;
    }

    /**
     * Hapus template dokumen (AJAX)
     */
    public function hapus() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_template = $this->input->post('id_template');
        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);

        if (!$template) {
            echo json_encode(array('success' => false, 'message' => 'Template dokumen tidak ditemukan.'));
            return;
        }

        if ($this->Model_template_dokumen->hapus_template($id_template)) {
            
            $this->Model_template_dokumen->catat_aktivitas(
                'Menghapus template dokumen',
                'Template: ' . $template['nama_template'],
                $this->session->userdata('id_pengguna')
            );

            echo json_encode(array('success' => true, 'message' => 'Template dokumen berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Template dokumen tidak dapat dihapus karena masih digunakan untuk submission.'));
        }
    }

    /**
     * Ubah status template dokumen (AJAX)
     */
    public function ubah_status() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_template = $this->input->post('id_template');
        $status = $this->input->post('status');

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template) {
            echo json_encode(array('success' => false, 'message' => 'Template dokumen tidak ditemukan.'));
            return;
        }

        if ($this->Model_template_dokumen->ubah_status_template($id_template, $status)) {
            
            $this->Model_template_dokumen->catat_aktivitas(
                'Mengubah status template dokumen',
                'Template: ' . $template['nama_template'] . ' menjadi ' . $status,
                $this->session->userdata('id_pengguna')
            );

            echo json_encode(array('success' => true, 'message' => 'Status template dokumen berhasil diubah.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Terjadi kesalahan saat mengubah status.'));
        }
    }

    /**
     * Duplikasi template dokumen (AJAX)
     */
    public function duplikasi() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_template = $this->input->post('id_template');
        $nama_baru = $this->input->post('nama_baru');

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template) {
            echo json_encode(array('success' => false, 'message' => 'Template dokumen tidak ditemukan.'));
            return;
        }

        
        if (!$this->Model_template_dokumen->cek_nama_template_tersedia($nama_baru, $template['id_jenis'])) {
            echo json_encode(array('success' => false, 'message' => 'Nama template sudah digunakan dalam jenis dokumen yang sama.'));
            return;
        }

        $id_template_baru = $this->Model_template_dokumen->duplikasi_template($id_template, $nama_baru, $this->session->userdata('id_pengguna'));

        if ($id_template_baru) {
            
            $this->Model_template_dokumen->catat_aktivitas(
                'Menduplikasi template dokumen',
                'Template asli: ' . $template['nama_template'] . ', Template baru: ' . $nama_baru,
                $this->session->userdata('id_pengguna')
            );

            echo json_encode(array(
                'success' => true,
                'message' => 'Template dokumen berhasil diduplikasi.',
                'redirect' => site_url('staff/template_dokumen/detail/' . $id_template_baru)
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Terjadi kesalahan saat menduplikasi template.'));
        }
    }

    /**
     * Callback validation untuk cek nama template unik
     */
    public function cek_nama_template_unik($nama_template) {
        $this->form_validation->set_message('cek_nama_template_unik', 'Nama template sudah digunakan dalam jenis dokumen yang sama.');
        return FALSE;
    }
}
