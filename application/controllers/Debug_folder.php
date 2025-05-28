<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk debugging masalah folder
 */
class Debug_folder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Model_file_pribadi');
        $this->load->library('session');
    }

    public function index() {
        echo "<h2>Debug Folder System</h2>";
        echo "<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .success { color: green; }
            .error { color: red; }
            .warning { color: orange; }
            .info { color: blue; }
            pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
        </style>";

        // 1. Cek koneksi database
        echo "<h3>1. Database Connection</h3>";
        try {
            $this->db->get('pengguna', 1);
            echo "<p class='success'>✓ Database connection OK</p>";
        } catch (Exception $e) {
            echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
            return;
        }

        // 2. Cek tabel pengguna
        echo "<h3>2. Tabel Pengguna</h3>";
        if ($this->db->table_exists('pengguna')) {
            echo "<p class='success'>✓ Tabel pengguna exists</p>";
            $count = $this->db->count_all('pengguna');
            echo "<p class='info'>Total users: $count</p>";
        } else {
            echo "<p class='error'>✗ Tabel pengguna not found</p>";
        }

        // 3. Cek tabel folder_pribadi
        echo "<h3>3. Tabel Folder Pribadi</h3>";
        if ($this->db->table_exists('folder_pribadi')) {
            echo "<p class='success'>✓ Tabel folder_pribadi exists</p>";
            $count = $this->db->count_all('folder_pribadi');
            echo "<p class='info'>Total folders: $count</p>";
        } else {
            echo "<p class='error'>✗ Tabel folder_pribadi not found</p>";
            echo "<p class='info'>Trying to create table...</p>";
            
            // Coba buat tabel
            $result = $this->Model_file_pribadi->buat_tabel_manual();
            if ($result) {
                echo "<p class='success'>✓ Table created successfully</p>";
            } else {
                echo "<p class='error'>✗ Failed to create table</p>";
            }
        }

        // 4. Cek session
        echo "<h3>4. Session Check</h3>";
        $user_id = $this->session->userdata('id_pengguna');
        if ($user_id) {
            echo "<p class='success'>✓ User logged in (ID: $user_id)</p>";
            
            // Cek user di database
            $user = $this->db->get_where('pengguna', array('id_pengguna' => $user_id))->row();
            if ($user) {
                echo "<p class='success'>✓ User found in database: " . $user->nama_lengkap . "</p>";
            } else {
                echo "<p class='error'>✗ User not found in database</p>";
            }
        } else {
            echo "<p class='error'>✗ User not logged in</p>";
            echo "<p class='info'>Please login first</p>";
        }

        // 5. Test insert folder
        if ($user_id) {
            echo "<h3>5. Test Insert Folder</h3>";
            
            $test_data = array(
                'id_pengguna' => $user_id,
                'nama_folder' => 'Test Debug Folder ' . date('Y-m-d H:i:s'),
                'deskripsi' => 'Test folder for debugging'
            );
            
            try {
                $result = $this->Model_file_pribadi->tambah_folder($test_data);
                if ($result) {
                    echo "<p class='success'>✓ Test insert successful</p>";
                    
                    // Hapus test folder
                    $this->db->where('nama_folder', $test_data['nama_folder']);
                    $this->db->delete('folder_pribadi');
                    echo "<p class='info'>Test folder deleted</p>";
                } else {
                    echo "<p class='error'>✗ Test insert failed</p>";
                    $error = $this->db->error();
                    echo "<p class='error'>DB Error: " . print_r($error, true) . "</p>";
                }
            } catch (Exception $e) {
                echo "<p class='error'>✗ Exception during test insert: " . $e->getMessage() . "</p>";
            }
        }

        // 6. Cek CodeIgniter environment
        echo "<h3>6. CodeIgniter Environment</h3>";
        echo "<p><strong>Environment:</strong> " . ENVIRONMENT . "</p>";
        echo "<p><strong>CI Version:</strong> " . CI_VERSION . "</p>";
        echo "<p><strong>Base URL:</strong> " . base_url() . "</p>";
        echo "<p><strong>Site URL:</strong> " . site_url() . "</p>";

        // 7. Database config
        echo "<h3>7. Database Config</h3>";
        $db_config = $this->db->database;
        echo "<p><strong>Hostname:</strong> " . $this->db->hostname . "</p>";
        echo "<p><strong>Database:</strong> " . $this->db->database . "</p>";
        echo "<p><strong>Username:</strong> " . $this->db->username . "</p>";
        echo "<p><strong>Driver:</strong> " . $this->db->dbdriver . "</p>";

        // 8. Test AJAX endpoint
        echo "<h3>8. Test AJAX Endpoint</h3>";
        $ajax_url = site_url('user/file_pribadi/buat_folder');
        echo "<p><strong>AJAX URL:</strong> <a href='$ajax_url' target='_blank'>$ajax_url</a></p>";
        echo "<p class='warning'>Note: This URL should return 404 when accessed directly (normal behavior)</p>";

        echo "<hr>";
        echo "<h3>Recommendations:</h3>";
        echo "<ul>";
        echo "<li>Check browser console for JavaScript errors</li>";
        echo "<li>Check Network tab in Developer Tools</li>";
        echo "<li>Verify you're logged in as a user (not admin/staff)</li>";
        echo "<li>Try creating folder with simple name (no special characters)</li>";
        echo "</ul>";
    }

    public function test_ajax() {
        // Simulasi AJAX request untuk test
        if (!$this->session->userdata('id_pengguna')) {
            echo json_encode(array('success' => false, 'message' => 'Not logged in'));
            return;
        }

        $test_data = array(
            'id_pengguna' => $this->session->userdata('id_pengguna'),
            'nama_folder' => 'Test AJAX Folder ' . date('Y-m-d H:i:s'),
            'deskripsi' => 'Test folder via AJAX simulation'
        );

        try {
            $result = $this->Model_file_pribadi->tambah_folder($test_data);
            if ($result) {
                // Hapus test folder
                $this->db->where('nama_folder', $test_data['nama_folder']);
                $this->db->delete('folder_pribadi');
                
                echo json_encode(array('success' => true, 'message' => 'Test AJAX successful'));
            } else {
                $error = $this->db->error();
                echo json_encode(array('success' => false, 'message' => 'Database error', 'db_error' => $error));
            }
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'message' => 'Exception: ' . $e->getMessage()));
        }
    }
}
