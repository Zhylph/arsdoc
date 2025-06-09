<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller File Pribadi untuk User
 * Menangani manajemen file pribadi user dengan folder management
 */
class File_pribadi extends CI_Controller {

    public function __construct() {
        parent::__construct();

        
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }

        if ($this->session->userdata('role') !== 'user') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }

        $this->load->model('Model_file_pribadi');
        $this->load->model('Model_log_aktivitas');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('download');
    }

    /**
     * Halaman utama file pribadi
     */
    public function index($id_folder = null) {
        $data = array(
            'title' => 'File Pribadi - User Dashboard',
            'page_title' => 'Manajemen File Pribadi',
            'breadcrumb' => array(
                'Dashboard' => 'user/dashboard',
                'File Pribadi' => ''
            )
        );

        
        $current_folder = null;
        if ($id_folder) {
            $current_folder = $this->Model_file_pribadi->ambil_folder_by_id($id_folder);
            if (!$current_folder || $current_folder['id_pengguna'] != $this->session->userdata('id_pengguna')) {
                show_404();
            }
            $data['page_title'] = 'File Pribadi - ' . $current_folder['nama_folder'];
        }

        $data['current_folder'] = $current_folder;
        $data['id_folder'] = $id_folder;

        
        $config['base_url'] = base_url('user/file_pribadi/index/' . ($id_folder ? $id_folder : ''));
        $filter = $this->_get_filter();
        $filter['id_pengguna'] = $this->session->userdata('id_pengguna');
        $filter['id_folder'] = $id_folder;
        $config['total_rows'] = $this->Model_file_pribadi->hitung_total_file($filter);
        $config['per_page'] = 20;
        $config['uri_segment'] = $id_folder ? 5 : 4;

        $this->_setup_pagination($config);

        $offset = $this->uri->segment($config['uri_segment']) ? $this->uri->segment($config['uri_segment']) : 0;

        
        $data['files'] = $this->Model_file_pribadi->ambil_semua_file($filter, $config['per_page'], $offset);
        $data['folders'] = $this->Model_file_pribadi->ambil_folder_by_parent($this->session->userdata('id_pengguna'), $id_folder);
        $data['pagination'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['total_rows'] = $config['total_rows'];

        
        $data['statistik'] = $this->Model_file_pribadi->ambil_statistik_file($this->session->userdata('id_pengguna'));

        
        $data['folder_breadcrumb'] = $this->Model_file_pribadi->ambil_folder_breadcrumb($id_folder);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/file_pribadi/index', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * Upload file baru
     */
    public function upload($id_folder = null) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        
        if ($id_folder) {
            $folder = $this->Model_file_pribadi->ambil_folder_by_id($id_folder);
            if (!$folder || $folder['id_pengguna'] != $this->session->userdata('id_pengguna')) {
                echo json_encode(array('success' => false, 'message' => 'Folder tidak valid.'));
                return;
            }
        }

        
        $config['upload_path'] = './uploads/file_pribadi/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|jpg|jpeg|png|gif|txt|zip|rar';
        $config['max_size'] = 10240; 
        $config['encrypt_name'] = TRUE;

        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            echo json_encode(array('success' => false, 'message' => $this->upload->display_errors('', '')));
            return;
        }

        $upload_data = $this->upload->data();

        
        $data_file = array(
            'id_pengguna' => $this->session->userdata('id_pengguna'),
            'id_folder' => $id_folder,
            'nama_file' => $upload_data['orig_name'],
            'nama_file_sistem' => $upload_data['file_name'],
            'ukuran_file' => $upload_data['file_size'],
            'tipe_file' => $upload_data['file_ext'],
            'deskripsi' => $this->input->post('deskripsi')
        );

        if ($this->Model_file_pribadi->tambah_file($data_file)) {
            
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Upload file pribadi',
                "Upload file: {$upload_data['orig_name']}"
            );

            echo json_encode(array('success' => true, 'message' => 'File berhasil diupload.'));
        } else {
            
            unlink($upload_data['full_path']);
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan data file.'));
        }
    }

    /**
     * Buat folder baru
     */
    public function buat_folder() {
        
        $old_error_reporting = error_reporting(0);

        
        while (ob_get_level()) {
            ob_end_clean();
        }

        
        header('Content-Type: application/json');
        ob_start();

        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request'));
            ob_end_flush();
            error_reporting($old_error_reporting);
            exit;
        }

        try {
            
            if (!$this->session->userdata('id_pengguna')) {
                echo json_encode(array('success' => false, 'message' => 'Sesi telah berakhir. Silakan login kembali.'));
                ob_end_flush();
                error_reporting($old_error_reporting);
                exit;
            }

            $nama_folder = trim($this->input->post('nama_folder'));
            $id_parent = $this->input->post('id_parent');
            $deskripsi = trim($this->input->post('deskripsi'));

            
            if (empty($nama_folder)) {
                echo json_encode(array('success' => false, 'message' => 'Nama folder harus diisi.'));
                ob_end_flush();
                error_reporting($old_error_reporting);
                exit;
            }

            
            if (preg_match('/[<>:"\\/\\\\|?*]/', $nama_folder)) {
                echo json_encode(array('success' => false, 'message' => 'Nama folder mengandung karakter yang tidak diizinkan.'));
                ob_end_flush();
                error_reporting($old_error_reporting);
                exit;
            }

            
            if (strlen($nama_folder) > 255) {
                echo json_encode(array('success' => false, 'message' => 'Nama folder terlalu panjang (maksimal 255 karakter).'));
                ob_end_flush();
                error_reporting($old_error_reporting);
                exit;
            }

            
            if (empty($id_parent)) {
                $id_parent = null;
            }

            
            if ($id_parent) {
                $parent_folder = $this->Model_file_pribadi->ambil_folder_by_id($id_parent);
                if (!$parent_folder || $parent_folder['id_pengguna'] != $this->session->userdata('id_pengguna')) {
                    echo json_encode(array('success' => false, 'message' => 'Parent folder tidak valid.'));
                    ob_end_flush();
                    error_reporting($old_error_reporting);
                    exit;
                }
            }

            
            if ($this->Model_file_pribadi->cek_nama_folder_exists($this->session->userdata('id_pengguna'), $nama_folder, $id_parent)) {
                echo json_encode(array('success' => false, 'message' => 'Nama folder sudah ada di lokasi ini.'));
                ob_end_flush();
                error_reporting($old_error_reporting);
                exit;
            }

            $data_folder = array(
                'id_pengguna' => $this->session->userdata('id_pengguna'),
                'id_parent' => $id_parent,
                'nama_folder' => $nama_folder,
                'deskripsi' => $deskripsi
            );

            
            $result = $this->Model_file_pribadi->tambah_folder($data_folder);

            if ($result) {
                
                try {
                    $this->Model_log_aktivitas->tambah_log(
                        $this->session->userdata('id_pengguna'),
                        'Membuat folder pribadi',
                        "Membuat folder: $nama_folder"
                    );
                } catch (Exception $log_error) {
                    
                    
                    error_log('Gagal log aktivitas: ' . $log_error->getMessage());
                }

                echo json_encode(array('success' => true, 'message' => 'Folder berhasil dibuat.'));
                ob_end_flush();
                error_reporting($old_error_reporting);
                exit;
            } else {
                
                $db_error = $this->db->error();
                $error_message = 'Gagal membuat folder.';

                if (!empty($db_error['message'])) {
                    
                    error_log('Database error saat membuat folder: ' . $db_error['message']);

                    
                    if (strpos($db_error['message'], 'foreign key constraint') !== false) {
                        $error_message = 'Terjadi kesalahan referensi data. Silakan coba lagi.';
                    } elseif (strpos($db_error['message'], 'Duplicate entry') !== false) {
                        $error_message = 'Nama folder sudah ada di lokasi ini.';
                    }
                }

                echo json_encode(array('success' => false, 'message' => $error_message));
                ob_end_flush();
                error_reporting($old_error_reporting);
                exit;
            }

        } catch (Exception $e) {
            
            error_log('Exception saat membuat folder: ' . $e->getMessage());
            echo json_encode(array('success' => false, 'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'));
            ob_end_flush();
            error_reporting($old_error_reporting);
            exit;
        }
    }

    /**
     * Debug method untuk troubleshooting
     */
    public function debug_buat_folder() {
        
        echo "<h2>Debug Buat Folder</h2>";
        echo "<style>body{font-family:Arial;margin:20px;} .error{color:red;} .success{color:green;} .info{color:blue;}</style>";

        
        echo "<h3>1. Session Check</h3>";
        $user_id = $this->session->userdata('id_pengguna');
        if ($user_id) {
            echo "<p class='success'>✓ User ID: $user_id</p>";
        } else {
            echo "<p class='error'>✗ No user session</p>";
            return;
        }

        
        echo "<h3>2. Database Check</h3>";
        if ($this->db->table_exists('folder_pribadi')) {
            echo "<p class='success'>✓ Table folder_pribadi exists</p>";
        } else {
            echo "<p class='error'>✗ Table folder_pribadi not found</p>";
            return;
        }

        
        echo "<h3>3. Test Insert</h3>";
        $test_data = array(
            'id_pengguna' => $user_id,
            'nama_folder' => 'Debug Test ' . date('H:i:s'),
            'deskripsi' => 'Test debug folder'
        );

        echo "<p class='info'>Test data: " . json_encode($test_data) . "</p>";

        
        try {
            $result = $this->Model_file_pribadi->tambah_folder($test_data);
            if ($result) {
                echo "<p class='success'>✓ Insert successful</p>";

                
                $this->db->where('nama_folder', $test_data['nama_folder']);
                $this->db->delete('folder_pribadi');
                echo "<p class='info'>Test data cleaned up</p>";
            } else {
                echo "<p class='error'>✗ Insert failed</p>";
                $error = $this->db->error();
                echo "<p class='error'>DB Error: " . print_r($error, true) . "</p>";
            }
        } catch (Exception $e) {
            echo "<p class='error'>✗ Exception: " . $e->getMessage() . "</p>";
        }

        echo "<hr><p><a href='" . site_url('user/file_pribadi') . "'>Back to File Pribadi</a></p>";
    }

    /**
     * Test AJAX endpoint untuk debugging
     */
    public function test_ajax() {
        
        header('Content-Type: application/json');
        ob_clean();

        
        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Bukan AJAX request'));
            return;
        }

        
        $user_id = $this->session->userdata('id_pengguna');
        if (!$user_id) {
            echo json_encode(array('success' => false, 'message' => 'User tidak login'));
            return;
        }

        
        $nama_folder = $this->input->post('nama_folder');
        $id_parent = $this->input->post('id_parent');
        $deskripsi = $this->input->post('deskripsi');

        
        echo json_encode(array(
            'success' => true,
            'message' => 'Test AJAX berhasil',
            'data' => array(
                'user_id' => $user_id,
                'nama_folder' => $nama_folder,
                'id_parent' => $id_parent,
                'deskripsi' => $deskripsi,
                'post_data' => $_POST
            )
        ));
        exit; 
    }

    /**
     * Buat folder sederhana tanpa logging untuk test
     */
    public function buat_folder_simple() {
        
        header('Content-Type: application/json');
        ob_clean();

        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request'));
            exit;
        }

        
        $user_id = $this->session->userdata('id_pengguna');
        if (!$user_id) {
            echo json_encode(array('success' => false, 'message' => 'User tidak login'));
            exit;
        }

        $nama_folder = trim($this->input->post('nama_folder'));
        if (empty($nama_folder)) {
            echo json_encode(array('success' => false, 'message' => 'Nama folder harus diisi'));
            exit;
        }

        
        $data = array(
            'id_pengguna' => $user_id,
            'nama_folder' => $nama_folder,
            'deskripsi' => $this->input->post('deskripsi'),
            'id_parent' => $this->input->post('id_parent') ?: null,
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('folder_pribadi', $data)) {
            echo json_encode(array('success' => true, 'message' => 'Folder berhasil dibuat'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal membuat folder'));
        }
        exit;
    }

    /**
     * Method untuk debug response JSON
     */
    public function debug_json_response() {
        
        header('Content-Type: application/json');
        ob_clean();

        
        echo json_encode(array(
            'success' => true,
            'message' => 'Test JSON response berhasil',
            'timestamp' => date('Y-m-d H:i:s'),
            'data' => array(
                'test' => 'value',
                'number' => 123
            )
        ));
        exit;
    }

    /**
     * Buat folder tanpa logging untuk menguji masalah
     */
    public function buat_folder_no_log() {
        
        while (ob_get_level()) {
            ob_end_clean();
        }

        
        header('Content-Type: application/json');
        ob_start();

        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request'));
            ob_end_flush();
            exit;
        }

        
        $user_id = $this->session->userdata('id_pengguna');
        if (!$user_id) {
            echo json_encode(array('success' => false, 'message' => 'User tidak login'));
            ob_end_flush();
            exit;
        }

        $nama_folder = trim($this->input->post('nama_folder'));
        if (empty($nama_folder)) {
            echo json_encode(array('success' => false, 'message' => 'Nama folder harus diisi'));
            ob_end_flush();
            exit;
        }

        
        $data = array(
            'id_pengguna' => $user_id,
            'nama_folder' => $nama_folder,
            'deskripsi' => $this->input->post('deskripsi'),
            'id_parent' => $this->input->post('id_parent') ?: null,
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('folder_pribadi', $data)) {
            echo json_encode(array('success' => true, 'message' => 'Folder berhasil dibuat'));
        } else {
            $db_error = $this->db->error();
            echo json_encode(array('success' => false, 'message' => 'Gagal membuat folder: ' . $db_error['message']));
        }
        ob_end_flush();
        exit;
    }

    /**
     * Download file
     */
    public function download($id_file) {
        $file = $this->Model_file_pribadi->ambil_file_by_id($id_file);

        if (!$file || $file['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            show_404();
        }

        $file_path = './uploads/file_pribadi/' . $file['nama_file_sistem'];

        if (!file_exists($file_path)) {
            show_404();
        }

        
        $this->Model_file_pribadi->update_counter_download($id_file);

        
        $this->Model_log_aktivitas->tambah_log(
            $this->session->userdata('id_pengguna'),
            'Download file pribadi',
            "Download file: {$file['nama_file']}"
        );

        
        force_download($file['nama_file'], file_get_contents($file_path));
    }

    /**
     * Hapus file
     */
    public function hapus_file() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_file = $this->input->post('id_file');

        if (!$id_file) {
            echo json_encode(array('success' => false, 'message' => 'ID file tidak valid.'));
            return;
        }

        $file = $this->Model_file_pribadi->ambil_file_by_id($id_file);
        if (!$file || $file['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            echo json_encode(array('success' => false, 'message' => 'File tidak ditemukan.'));
            return;
        }

        if ($this->Model_file_pribadi->hapus_file($id_file)) {
            
            $file_path = './uploads/file_pribadi/' . $file['nama_file_sistem'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Menghapus file pribadi',
                "Menghapus file: {$file['nama_file']}"
            );

            echo json_encode(array('success' => true, 'message' => 'File berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus file.'));
        }
    }

    /**
     * Hapus folder
     */
    public function hapus_folder() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_folder = $this->input->post('id_folder');

        if (!$id_folder) {
            echo json_encode(array('success' => false, 'message' => 'ID folder tidak valid.'));
            return;
        }

        $folder = $this->Model_file_pribadi->ambil_folder_by_id($id_folder);
        if (!$folder || $folder['id_pengguna'] != $this->session->userdata('id_pengguna')) {
            echo json_encode(array('success' => false, 'message' => 'Folder tidak ditemukan.'));
            return;
        }

        
        $jumlah_file = $this->Model_file_pribadi->hitung_total_file(array('id_folder' => $id_folder));
        $jumlah_subfolder = $this->Model_file_pribadi->hitung_total_folder(array('id_parent' => $id_folder));

        if ($jumlah_file > 0 || $jumlah_subfolder > 0) {
            echo json_encode(array('success' => false, 'message' => 'Folder tidak kosong. Hapus semua file dan subfolder terlebih dahulu.'));
            return;
        }

        if ($this->Model_file_pribadi->hapus_folder($id_folder)) {
            
            $this->Model_log_aktivitas->tambah_log(
                $this->session->userdata('id_pengguna'),
                'Menghapus folder pribadi',
                "Menghapus folder: {$folder['nama_folder']}"
            );

            echo json_encode(array('success' => true, 'message' => 'Folder berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus folder.'));
        }
    }

    /**
     * Rename file atau folder
     */
    public function rename() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $type = $this->input->post('type'); 
        $id = $this->input->post('id');
        $nama_baru = $this->input->post('nama_baru');

        if (empty($nama_baru)) {
            echo json_encode(array('success' => false, 'message' => 'Nama baru harus diisi.'));
            return;
        }

        if ($type === 'file') {
            $file = $this->Model_file_pribadi->ambil_file_by_id($id);
            if (!$file || $file['id_pengguna'] != $this->session->userdata('id_pengguna')) {
                echo json_encode(array('success' => false, 'message' => 'File tidak ditemukan.'));
                return;
            }

            if ($this->Model_file_pribadi->update_file($id, array('nama_file' => $nama_baru))) {
                $this->Model_log_aktivitas->tambah_log(
                    $this->session->userdata('id_pengguna'),
                    'Rename file pribadi',
                    "Rename file dari '{$file['nama_file']}' menjadi '$nama_baru'"
                );
                echo json_encode(array('success' => true, 'message' => 'File berhasil direname.'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Gagal rename file.'));
            }
        } else {
            $folder = $this->Model_file_pribadi->ambil_folder_by_id($id);
            if (!$folder || $folder['id_pengguna'] != $this->session->userdata('id_pengguna')) {
                echo json_encode(array('success' => false, 'message' => 'Folder tidak ditemukan.'));
                return;
            }

            
            if ($this->Model_file_pribadi->cek_nama_folder_exists($this->session->userdata('id_pengguna'), $nama_baru, $folder['id_parent'], $id)) {
                echo json_encode(array('success' => false, 'message' => 'Nama folder sudah ada di lokasi ini.'));
                return;
            }

            if ($this->Model_file_pribadi->update_folder($id, array('nama_folder' => $nama_baru))) {
                $this->Model_log_aktivitas->tambah_log(
                    $this->session->userdata('id_pengguna'),
                    'Rename folder pribadi',
                    "Rename folder dari '{$folder['nama_folder']}' menjadi '$nama_baru'"
                );
                echo json_encode(array('success' => true, 'message' => 'Folder berhasil direname.'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Gagal rename folder.'));
            }
        }
    }

    /**
     * Mendapatkan filter dari input GET
     */
    private function _get_filter() {
        return array(
            'tipe_file' => $this->input->get('tipe_file'),
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
