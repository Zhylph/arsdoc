<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Manajemen Pengguna untuk Admin
 * Menangani CRUD lengkap untuk manajemen pengguna
 */
class Pengguna extends CI_Controller {

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
        $this->load->model('Model_log_aktivitas');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    /**
     * Halaman daftar pengguna dengan pagination dan filter
     */
    public function index() {
        $data = array(
            'title' => 'Manajemen Pengguna - Admin Dashboard',
            'page_title' => 'Manajemen Pengguna',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Manajemen Pengguna' => ''
            )
        );

        // Konfigurasi pagination
        $config['base_url'] = base_url('admin/pengguna/index');
        $config['total_rows'] = $this->Model_pengguna->hitung_total_pengguna($this->_get_filter());
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;

        // Styling pagination dengan Flowbite
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
        $config['cur_tag_open'] = '<li><span class="px-3 py-2 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->load->library('pagination', $config);

        $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;

        // Ambil data pengguna dengan filter dan pagination
        $filter = $this->_get_filter();
        $data['pengguna'] = $this->Model_pengguna->ambil_semua_pengguna($filter, $config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/pengguna/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Halaman tambah pengguna baru
     */
    public function tambah() {
        $data = array(
            'title' => 'Tambah Pengguna - Admin Dashboard',
            'page_title' => 'Tambah Pengguna Baru',
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Manajemen Pengguna' => 'admin/pengguna',
                'Tambah Pengguna' => ''
            )
        );

        if ($this->input->post()) {
            $this->_validasi_form();

            if ($this->form_validation->run() === TRUE) {
                $data_pengguna = array(
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role'),
                    'status' => $this->input->post('status')
                );

                // Handle upload foto profil
                if (!empty($_FILES['foto_profil']['name'])) {
                    $upload_result = $this->_upload_foto_profil();
                    if ($upload_result['success']) {
                        $data_pengguna['foto_profil'] = $upload_result['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $upload_result['error']);
                        redirect('admin/pengguna/tambah');
                    }
                }

                if ($this->Model_pengguna->tambah_pengguna($data_pengguna)) {
                    // Log aktivitas
                    $this->Model_log_aktivitas->tambah_log(
                        $this->session->userdata('id_pengguna'),
                        'Menambah pengguna baru',
                        'Menambah pengguna: ' . $data_pengguna['nama_lengkap'] . ' (' . $data_pengguna['email'] . ')'
                    );

                    $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan.');
                    redirect('admin/pengguna');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan pengguna.');
                }
            }
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/pengguna/tambah', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Halaman edit pengguna
     */
    public function edit($id_pengguna = null) {
        if (!$id_pengguna) {
            show_404();
        }

        $pengguna = $this->Model_pengguna->ambil_pengguna_by_id($id_pengguna);
        if (!$pengguna) {
            show_404();
        }

        $data = array(
            'title' => 'Edit Pengguna - Admin Dashboard',
            'page_title' => 'Edit Pengguna: ' . $pengguna['nama_lengkap'],
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Manajemen Pengguna' => 'admin/pengguna',
                'Edit Pengguna' => ''
            ),
            'pengguna' => $pengguna
        );

        if ($this->input->post()) {
            $this->_validasi_form('edit', $id_pengguna);

            if ($this->form_validation->run() === TRUE) {
                $data_pengguna = array(
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'email' => $this->input->post('email'),
                    'role' => $this->input->post('role'),
                    'status' => $this->input->post('status')
                );

                // Update password jika diisi
                if (!empty($this->input->post('password'))) {
                    $data_pengguna['password'] = $this->input->post('password');
                }

                // Handle upload foto profil
                if (!empty($_FILES['foto_profil']['name'])) {
                    $upload_result = $this->_upload_foto_profil();
                    if ($upload_result['success']) {
                        // Hapus foto lama jika ada
                        if (!empty($pengguna['foto_profil']) && file_exists('./uploads/profil/' . $pengguna['foto_profil'])) {
                            unlink('./uploads/profil/' . $pengguna['foto_profil']);
                        }
                        $data_pengguna['foto_profil'] = $upload_result['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $upload_result['error']);
                        redirect('admin/pengguna/edit/' . $id_pengguna);
                    }
                }

                if ($this->Model_pengguna->update_pengguna($id_pengguna, $data_pengguna)) {
                    // Log aktivitas
                    $this->Model_log_aktivitas->tambah_log(
                        $this->session->userdata('id_pengguna'),
                        'Mengupdate data pengguna',
                        'Mengupdate pengguna: ' . $data_pengguna['nama_lengkap'] . ' (ID: ' . $id_pengguna . ')'
                    );

                    $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui.');
                    redirect('admin/pengguna');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data pengguna.');
                }
            }
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/pengguna/edit', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Halaman detail pengguna
     */
    public function detail($id_pengguna = null) {
        if (!$id_pengguna) {
            show_404();
        }

        $pengguna = $this->Model_pengguna->ambil_pengguna_by_id($id_pengguna);
        if (!$pengguna) {
            show_404();
        }

        $data = array(
            'title' => 'Detail Pengguna - Admin Dashboard',
            'page_title' => 'Detail Pengguna: ' . $pengguna['nama_lengkap'],
            'breadcrumb' => array(
                'Dashboard' => 'admin/dashboard',
                'Manajemen Pengguna' => 'admin/pengguna',
                'Detail Pengguna' => ''
            ),
            'pengguna' => $pengguna
        );

        // Ambil statistik pengguna
        $data['statistik'] = $this->Model_pengguna->ambil_statistik_pengguna($id_pengguna);

        // Ambil aktivitas terbaru pengguna
        $data['aktivitas_terbaru'] = $this->Model_log_aktivitas->ambil_aktivitas_by_pengguna($id_pengguna, 10);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/pengguna/detail', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Hapus pengguna (AJAX)
     */
    public function hapus() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_pengguna = $this->input->post('id_pengguna');

        if (!$id_pengguna) {
            echo json_encode(array('success' => false, 'message' => 'ID pengguna tidak valid.'));
            return;
        }

        // Cek apakah pengguna ada
        $pengguna = $this->Model_pengguna->ambil_pengguna_by_id($id_pengguna);
        if (!$pengguna) {
            echo json_encode(array('success' => false, 'message' => 'Pengguna tidak ditemukan.'));
            return;
        }

        // Tidak boleh menghapus diri sendiri
        if ($id_pengguna == $this->session->userdata('id_pengguna')) {
            echo json_encode(array('success' => false, 'message' => 'Anda tidak dapat menghapus akun sendiri.'));
            return;
        }

        if ($this->Model_pengguna->hapus_pengguna($id_pengguna)) {
            // Hapus foto profil jika ada
            if (!empty($pengguna['foto_profil']) && file_exists('./uploads/profil/' . $pengguna['foto_profil'])) {
                unlink('./uploads/profil/' . $pengguna['foto_profil']);
            }

            // Log aktivitas
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Menghapus pengguna',
                'Menghapus pengguna: ' . $pengguna['nama_lengkap'] . ' (ID: ' . $id_pengguna . ')'
            );

            echo json_encode(array('success' => true, 'message' => 'Pengguna berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus pengguna.'));
        }
    }

    /**
     * Toggle status pengguna (AJAX)
     */
    public function toggle_status() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_pengguna = $this->input->post('id_pengguna');
        $status = $this->input->post('status');

        if (!$id_pengguna || !in_array($status, array('aktif', 'nonaktif'))) {
            echo json_encode(array('success' => false, 'message' => 'Data tidak valid.'));
            return;
        }

        // Tidak boleh menonaktifkan diri sendiri
        if ($id_pengguna == $this->session->userdata('id_pengguna') && $status == 'nonaktif') {
            echo json_encode(array('success' => false, 'message' => 'Anda tidak dapat menonaktifkan akun sendiri.'));
            return;
        }

        $pengguna = $this->Model_pengguna->ambil_pengguna_by_id($id_pengguna);
        if (!$pengguna) {
            echo json_encode(array('success' => false, 'message' => 'Pengguna tidak ditemukan.'));
            return;
        }

        if ($this->Model_pengguna->update_pengguna($id_pengguna, array('status' => $status))) {
            // Log aktivitas
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Mengubah status pengguna',
                'Mengubah status pengguna ' . $pengguna['nama_lengkap'] . ' menjadi ' . $status
            );

            echo json_encode(array('success' => true, 'message' => 'Status pengguna berhasil diubah.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mengubah status pengguna.'));
        }
    }

    /**
     * Export data pengguna ke Excel
     */
    public function export() {
        $filter = $this->_get_filter();
        $pengguna = $this->Model_pengguna->ambil_semua_pengguna($filter);

        // Set header untuk download Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="data_pengguna_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        // Load view untuk export
        $data['pengguna'] = $pengguna;
        $this->load->view('admin/pengguna/export', $data);
    }

    /**
     * Mendapatkan filter dari input GET
     */
    private function _get_filter() {
        return array(
            'role' => $this->input->get('role'),
            'status' => $this->input->get('status'),
            'pencarian' => $this->input->get('pencarian')
        );
    }

    /**
     * Validasi form pengguna
     */
    private function _validasi_form($mode = 'tambah', $id_pengguna = null) {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|min_length[3]|max_length[100]');

        // Validasi email dengan pengecekan unique
        if ($mode == 'tambah') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[pengguna.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__cek_email_unique[' . $id_pengguna . ']');
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        }

        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,staff,user]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

        // Set pesan error dalam bahasa Indonesia
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter.');
        $this->form_validation->set_message('valid_email', '{field} harus berupa email yang valid.');
        $this->form_validation->set_message('is_unique', '{field} sudah digunakan.');
        $this->form_validation->set_message('in_list', '{field} tidak valid.');
    }

    /**
     * Callback untuk validasi email unique saat edit
     */
    public function _cek_email_unique($email, $id_pengguna) {
        $pengguna = $this->Model_pengguna->ambil_pengguna_by_email($email);
        if ($pengguna && $pengguna['id_pengguna'] != $id_pengguna) {
            $this->form_validation->set_message('_cek_email_unique', 'Email sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Upload foto profil
     */
    private function _upload_foto_profil() {
        $config['upload_path'] = './uploads/profil/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // 2MB
        $config['max_width'] = 1024;
        $config['max_height'] = 1024;
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto_profil')) {
            return array(
                'success' => true,
                'file_name' => $this->upload->data('file_name')
            );
        } else {
            return array(
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            );
        }
    }
}