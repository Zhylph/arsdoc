<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Jenis Dokumen untuk Staff
 * Mengelola CRUD jenis dokumen
 */
class Jenis_dokumen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
        
        if ($this->session->userdata('role') !== 'staff') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
        
        $this->load->model('Model_jenis_dokumen');
        $this->load->library('pagination');
    }

    /**
     * Halaman daftar jenis dokumen
     */
    public function index() {
        $data = array(
            'title' => 'Kelola Jenis Dokumen - Staff Dashboard',
            'page_title' => 'Kelola Jenis Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Jenis Dokumen' => ''
            )
        );

        
        $per_page = 10;
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;

        
        $filter = array();
        if ($this->input->get('status')) {
            $filter['status'] = $this->input->get('status');
        }
        if ($this->input->get('pencarian')) {
            $filter['pencarian'] = $this->input->get('pencarian');
        }

        
        $data['jenis_dokumen'] = $this->Model_jenis_dokumen->ambil_semua_jenis_dokumen($filter, $per_page, $offset);
        $total_rows = $this->Model_jenis_dokumen->hitung_semua_jenis_dokumen($filter);

        
        $config['base_url'] = site_url('staff/jenis_dokumen');
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

        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/jenis_dokumen/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Halaman tambah jenis dokumen
     */
    public function tambah() {
        $data = array(
            'title' => 'Tambah Jenis Dokumen - Staff Dashboard',
            'page_title' => 'Tambah Jenis Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Jenis Dokumen' => 'staff/jenis_dokumen',
                'Tambah' => ''
            )
        );

        if ($this->input->post()) {
            $this->_proses_tambah();
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('staff/jenis_dokumen/tambah', $data);
            $this->load->view('template/footer', $data);
        }
    }

    /**
     * Halaman edit jenis dokumen
     */
    public function edit($id_jenis = null) {
        if (!$id_jenis) {
            show_404();
        }

        $jenis_dokumen = $this->Model_jenis_dokumen->ambil_jenis_dokumen_by_id($id_jenis);
        if (!$jenis_dokumen) {
            show_404();
        }

        $data = array(
            'title' => 'Edit Jenis Dokumen - Staff Dashboard',
            'page_title' => 'Edit Jenis Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Jenis Dokumen' => 'staff/jenis_dokumen',
                'Edit' => ''
            ),
            'jenis_dokumen' => $jenis_dokumen
        );

        if ($this->input->post()) {
            $this->_proses_edit($id_jenis);
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('staff/jenis_dokumen/edit', $data);
            $this->load->view('template/footer', $data);
        }
    }

    /**
     * Halaman detail jenis dokumen
     */
    public function detail($id_jenis = null) {
        if (!$id_jenis) {
            show_404();
        }

        $jenis_dokumen = $this->Model_jenis_dokumen->ambil_jenis_dokumen_by_id($id_jenis);
        if (!$jenis_dokumen) {
            show_404();
        }

        $data = array(
            'title' => 'Detail Jenis Dokumen - Staff Dashboard',
            'page_title' => 'Detail Jenis Dokumen',
            'breadcrumb' => array(
                'Dashboard' => 'staff/dashboard',
                'Jenis Dokumen' => 'staff/jenis_dokumen',
                'Detail' => ''
            ),
            'jenis_dokumen' => $jenis_dokumen,
            'template_dokumen' => $this->Model_jenis_dokumen->ambil_template_by_jenis($id_jenis)
        );

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('staff/jenis_dokumen/detail', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Proses tambah jenis dokumen
     */
    private function _proses_tambah() {
        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis Dokumen', 'required|min_length[3]|max_length[100]|callback_cek_nama_jenis_unik');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $data_jenis = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'deskripsi' => $this->input->post('deskripsi'),
                'status' => $this->input->post('status'),
                'dibuat_oleh' => $this->session->userdata('id_pengguna')
            );

            if ($this->Model_jenis_dokumen->tambah_jenis_dokumen($data_jenis)) {
                
                $this->Model_jenis_dokumen->catat_aktivitas(
                    'Menambah jenis dokumen baru',
                    'Jenis dokumen: ' . $data_jenis['nama_jenis'],
                    $this->session->userdata('id_pengguna')
                );

                $this->session->set_flashdata('success_message', 'Jenis dokumen berhasil ditambahkan.');
                redirect('staff/jenis_dokumen');
            } else {
                $this->session->set_flashdata('error_message', 'Terjadi kesalahan saat menambah jenis dokumen.');
                $this->tambah();
            }
        }
    }

    /**
     * Proses edit jenis dokumen
     */
    private function _proses_edit($id_jenis) {
        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis Dokumen', 'required|min_length[3]|max_length[100]|callback_cek_nama_jenis_unik[' . $id_jenis . ']');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id_jenis);
        } else {
            $data_jenis = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'deskripsi' => $this->input->post('deskripsi'),
                'status' => $this->input->post('status')
            );

            if ($this->Model_jenis_dokumen->update_jenis_dokumen($id_jenis, $data_jenis)) {
                
                $this->Model_jenis_dokumen->catat_aktivitas(
                    'Mengupdate jenis dokumen',
                    'Jenis dokumen: ' . $data_jenis['nama_jenis'],
                    $this->session->userdata('id_pengguna')
                );

                $this->session->set_flashdata('success_message', 'Jenis dokumen berhasil diupdate.');
                redirect('staff/jenis_dokumen');
            } else {
                $this->session->set_flashdata('error_message', 'Terjadi kesalahan saat mengupdate jenis dokumen.');
                $this->edit($id_jenis);
            }
        }
    }

    /**
     * Hapus jenis dokumen (AJAX)
     */
    public function hapus() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_jenis = $this->input->post('id_jenis');
        $jenis_dokumen = $this->Model_jenis_dokumen->ambil_jenis_dokumen_by_id($id_jenis);

        if (!$jenis_dokumen) {
            echo json_encode(array('success' => false, 'message' => 'Jenis dokumen tidak ditemukan.'));
            return;
        }

        if ($this->Model_jenis_dokumen->hapus_jenis_dokumen($id_jenis)) {
            
            $this->Model_jenis_dokumen->catat_aktivitas(
                'Menghapus jenis dokumen',
                'Jenis dokumen: ' . $jenis_dokumen['nama_jenis'],
                $this->session->userdata('id_pengguna')
            );

            echo json_encode(array('success' => true, 'message' => 'Jenis dokumen berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Jenis dokumen tidak dapat dihapus karena masih digunakan oleh template dokumen.'));
        }
    }

    /**
     * Ubah status jenis dokumen (AJAX)
     */
    public function ubah_status() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_jenis = $this->input->post('id_jenis');
        $status = $this->input->post('status');

        $jenis_dokumen = $this->Model_jenis_dokumen->ambil_jenis_dokumen_by_id($id_jenis);
        if (!$jenis_dokumen) {
            echo json_encode(array('success' => false, 'message' => 'Jenis dokumen tidak ditemukan.'));
            return;
        }

        if ($this->Model_jenis_dokumen->ubah_status_jenis_dokumen($id_jenis, $status)) {
            
            $this->Model_jenis_dokumen->catat_aktivitas(
                'Mengubah status jenis dokumen',
                'Jenis dokumen: ' . $jenis_dokumen['nama_jenis'] . ' menjadi ' . $status,
                $this->session->userdata('id_pengguna')
            );

            echo json_encode(array('success' => true, 'message' => 'Status jenis dokumen berhasil diubah.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Terjadi kesalahan saat mengubah status.'));
        }
    }

    /**
     * Callback validation untuk cek nama jenis dokumen unik
     */
    public function cek_nama_jenis_unik($nama_jenis, $exclude_id = null) {
        if (!$this->Model_jenis_dokumen->cek_nama_jenis_tersedia($nama_jenis, $exclude_id)) {
            $this->form_validation->set_message('cek_nama_jenis_unik', 'Nama jenis dokumen sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}
