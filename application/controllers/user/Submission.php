<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Submission untuk User
 * Menangani pembuatan dan pengelolaan submission dokumen
 */
class Submission extends CI_Controller {

    private $file_validation_errors = array();

    /**
     * Test method untuk debug
     */
    public function test() {
        echo "Submission controller is working!<br>";
        echo "Session data: " . print_r($this->session->all_userdata(), true);
        log_message('debug', 'Submission::test() called successfully');
    }

    /**
     * Test method tanpa session check
     */
    public function test_no_auth() {
        echo "Submission controller accessible without auth!<br>";
        echo "Current time: " . date('Y-m-d H:i:s');
    }

    /**
     * Debug form submission
     */
    public function debug_form($id_template = null) {
        echo "<h2>Debug Form Submission</h2>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;}</style>";
        echo "<p class='info'>Template ID: " . $id_template . "</p>";
        echo "<p class='info'>Request Method: " . $this->input->method() . "</p>";
        echo "<p class='info'>Is POST: " . ($this->input->post() ? 'YES' : 'NO') . "</p>";

        if ($this->input->post()) {
            echo "<h3>POST Data Received:</h3>";
            echo "<pre class='info'>" . print_r($_POST, true) . "</pre>";

            echo "<h3>FILES Data Received:</h3>";
            echo "<pre class='info'>" . print_r($_FILES, true) . "</pre>";

            echo "<p class='success'>✓ Form submission berhasil diterima!</p>";
        } else {
            echo "<p class='info'>Belum ada POST data. Silakan submit form.</p>";
        }

        echo "<h3>Session Data:</h3>";
        echo "<pre class='info'>" . print_r($this->session->all_userdata(), true) . "</pre>";

        echo "<h3>Test Form:</h3>";
        echo '<form method="POST" enctype="multipart/form-data">';
        echo '<p>Nama: <input type="text" name="nama" required></p>';
        echo '<p>File: <input type="file" name="test_file" required></p>';
        echo '<p><button type="submit">Submit Test</button></p>';
        echo '</form>';
    }

    /**
     * Test method untuk form buat submission tanpa autentikasi
     */
    public function test_buat($id_template = 1) {
        echo "<h1>Test Buat Submission (No Auth)</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;}</style>";

        // Load models manually
        $this->load->model('Model_template_dokumen');
        $this->load->model('Model_submission');

        echo "<p class='info'>Template ID: " . $id_template . "</p>";
        echo "<p class='info'>Request Method: " . $this->input->method() . "</p>";
        echo "<p class='info'>Is POST: " . ($this->input->post() ? 'YES' : 'NO') . "</p>";

        // Get template
        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template) {
            echo "<p class='error'>Template tidak ditemukan!</p>";
            return;
        }

        echo "<h2>Template Info:</h2>";
        echo "<pre class='info'>" . print_r($template, true) . "</pre>";

        // Get fields
        $fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);
        echo "<h2>Template Fields (" . count($fields) . "):</h2>";
        echo "<pre class='info'>" . print_r($fields, true) . "</pre>";

        // Process form submission
        if ($this->input->post()) {
            echo "<h2 class='success'>Form Submitted!</h2>";
            echo "<h3>POST Data:</h3>";
            echo "<pre class='info'>" . print_r($_POST, true) . "</pre>";
            echo "<h3>FILES Data:</h3>";
            echo "<pre class='info'>" . print_r($_FILES, true) . "</pre>";

            // Test file upload
            if (!empty($_FILES)) {
                echo "<h3>File Upload Test:</h3>";
                foreach ($_FILES as $field_name => $file) {
                    echo "<p class='info'>Field: {$field_name}</p>";
                    echo "<p class='info'>Name: {$file['name']}</p>";
                    echo "<p class='info'>Size: {$file['size']} bytes</p>";
                    echo "<p class='info'>Type: {$file['type']}</p>";
                    echo "<p class='info'>Error: {$file['error']}</p>";

                    if ($file['error'] === UPLOAD_ERR_OK) {
                        echo "<p class='success'>✓ File {$field_name} siap untuk diupload</p>";
                    } else {
                        echo "<p class='error'>✗ File {$field_name} error: " . $file['error'] . "</p>";
                    }
                }
            }
        }

        // Generate form
        echo "<h2>Test Submission Form:</h2>";
        echo '<form method="POST" enctype="multipart/form-data" style="border:1px solid #ccc;padding:20px;background:#f9f9f9;">';

        foreach ($fields as $field) {
            echo "<div style='margin-bottom: 15px;'>";
            echo "<label style='font-weight:bold;display:block;margin-bottom:5px;'>" . ucfirst(str_replace('_', ' ', $field['nama_field'])) . ":</label>";

            if ($field['tipe_field'] === 'text') {
                echo '<input type="text" name="' . $field['nama_field'] . '" style="width:100%;padding:8px;" ' . ($field['wajib_diisi'] ? 'required' : '') . '>';
            } elseif ($field['tipe_field'] === 'textarea') {
                echo '<textarea name="' . $field['nama_field'] . '" style="width:100%;padding:8px;height:100px;" ' . ($field['wajib_diisi'] ? 'required' : '') . '></textarea>';
            } elseif ($field['tipe_field'] === 'file') {
                echo '<input type="file" name="' . $field['nama_field'] . '" style="width:100%;padding:8px;" ' . ($field['wajib_diisi'] ? 'required' : '') . '>';
            } elseif ($field['tipe_field'] === 'select') {
                echo '<select name="' . $field['nama_field'] . '" style="width:100%;padding:8px;" ' . ($field['wajib_diisi'] ? 'required' : '') . '>';
                echo '<option value="">Pilih...</option>';
                if (!empty($field['opsi_pilihan'])) {
                    $options = explode(',', $field['opsi_pilihan']);
                    foreach ($options as $option) {
                        echo '<option value="' . trim($option) . '">' . trim($option) . '</option>';
                    }
                }
                echo '</select>';
            }

            if ($field['wajib_diisi']) {
                echo " <span style='color:red;'>*</span>";
            }
            echo "</div>";
        }

        echo '<p><button type="submit" style="background:#007cba;color:white;padding:12px 24px;border:none;cursor:pointer;font-size:16px;">Submit Test</button></p>';
        echo '</form>';

        echo "<p><a href='" . base_url('user/submission/buat/' . $id_template) . "'>Test Original Form</a></p>";
    }

    /**
     * Debug template data
     */
    public function debug_template($id_template = 1) {
        echo "<h1>Debug Template Data</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;}</style>";

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);

        if (!$template) {
            echo "<p class='error'>Template tidak ditemukan!</p>";
            return;
        }

        echo "<h2>Template Data:</h2>";
        echo "<pre class='info'>" . print_r($template, true) . "</pre>";

        echo "<h2>Max File Size Analysis:</h2>";
        if (isset($template['max_ukuran_file'])) {
            $bytes = $template['max_ukuran_file'];
            $kb = round($bytes / 1024, 2);
            $mb = round($bytes / 1024 / 1024, 2);

            echo "<p class='info'>Raw value: {$bytes} bytes</p>";
            echo "<p class='info'>In KB: {$kb} KB</p>";
            echo "<p class='info'>In MB: {$mb} MB</p>";
        } else {
            echo "<p class='error'>max_ukuran_file field not found!</p>";
        }

        echo "<h2>PHP Upload Limits:</h2>";
        echo "<p class='info'>upload_max_filesize: " . ini_get('upload_max_filesize') . "</p>";
        echo "<p class='info'>post_max_size: " . ini_get('post_max_size') . "</p>";
        echo "<p class='info'>max_file_uploads: " . ini_get('max_file_uploads') . "</p>";
        echo "<p class='info'>memory_limit: " . ini_get('memory_limit') . "</p>";

        $fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);
        echo "<h2>Template Fields:</h2>";
        echo "<pre class='info'>" . print_r($fields, true) . "</pre>";
    }

    /**
     * Fix template max file size (convert MB to bytes if needed)
     */
    public function fix_template_size() {
        echo "<h1>Fix Template Max File Size</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;}</style>";

        // Get all templates
        $this->db->select('id_template, nama_template, max_ukuran_file');
        $this->db->from('template_dokumen');
        $templates = $this->db->get()->result_array();

        echo "<h2>Templates to Fix:</h2>";

        foreach ($templates as $template) {
            $current_size = $template['max_ukuran_file'];

            // If size is less than 1000, it's probably in MB, convert to bytes
            if ($current_size < 1000) {
                $new_size = $current_size * 1024 * 1024;

                echo "<p class='info'>Template: {$template['nama_template']}</p>";
                echo "<p class='info'>Current: {$current_size} (probably MB) -> New: {$new_size} bytes (" . round($new_size / 1024 / 1024, 1) . " MB)</p>";

                // Update database
                $this->db->where('id_template', $template['id_template']);
                $this->db->update('template_dokumen', array('max_ukuran_file' => $new_size));

                echo "<p class='success'>✓ Updated!</p>";
            } else {
                echo "<p class='info'>Template: {$template['nama_template']} - Size: {$current_size} bytes (" . round($current_size / 1024 / 1024, 1) . " MB) - OK</p>";
            }
            echo "<hr>";
        }

        echo "<p class='success'>Fix completed!</p>";
    }

    /**
     * Debug database tables
     */
    public function debug_tables() {
        echo "<h1>Debug Database Tables</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;} table{border-collapse:collapse;width:100%;margin:10px 0;} th,td{border:1px solid #ccc;padding:8px;text-align:left;}</style>";

        // Check submission_dokumen table
        echo "<h2>Submission Dokumen Table:</h2>";
        $this->db->select('*');
        $this->db->from('submission_dokumen');
        $this->db->limit(5);
        $submissions = $this->db->get()->result_array();

        if (empty($submissions)) {
            echo "<p class='info'>No submissions found in database.</p>";
        } else {
            echo "<table>";
            echo "<tr>";
            foreach (array_keys($submissions[0]) as $column) {
                echo "<th>{$column}</th>";
            }
            echo "</tr>";
            foreach ($submissions as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        // Check template_dokumen table
        echo "<h2>Template Dokumen Table:</h2>";
        $this->db->select('id_template, nama_template, max_ukuran_file, tipe_file_diizinkan, status');
        $this->db->from('template_dokumen');
        $templates = $this->db->get()->result_array();

        echo "<table>";
        echo "<tr><th>ID</th><th>Nama</th><th>Max Size (bytes)</th><th>Max Size (MB)</th><th>Allowed Types</th><th>Status</th></tr>";
        foreach ($templates as $template) {
            $maxSizeMB = round($template['max_ukuran_file'] / 1024 / 1024, 1);
            echo "<tr>";
            echo "<td>{$template['id_template']}</td>";
            echo "<td>{$template['nama_template']}</td>";
            echo "<td>{$template['max_ukuran_file']}</td>";
            echo "<td>{$maxSizeMB} MB</td>";
            echo "<td>{$template['tipe_file_diizinkan']}</td>";
            echo "<td>{$template['status']}</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Check field_dokumen table
        echo "<h2>Field Dokumen for Template 1:</h2>";
        $this->db->select('*');
        $this->db->from('field_dokumen');
        $this->db->where('id_template', 1);
        $fields = $this->db->get()->result_array();

        if (empty($fields)) {
            echo "<p class='error'>No fields found for template 1!</p>";
        } else {
            echo "<table>";
            echo "<tr>";
            foreach (array_keys($fields[0]) as $column) {
                echo "<th>{$column}</th>";
            }
            echo "</tr>";
            foreach ($fields as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        // Check database connection
        echo "<h2>Database Info:</h2>";
        echo "<p class='info'>Database: " . $this->db->database . "</p>";
        echo "<p class='info'>Last query: " . $this->db->last_query() . "</p>";
    }

    /**
     * Setup template fields if missing
     */
    public function setup_template_fields($id_template = 1) {
        echo "<h1>Setup Template Fields</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;}</style>";

        // Check if template exists
        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template) {
            echo "<p class='error'>Template {$id_template} tidak ditemukan!</p>";
            return;
        }

        echo "<p class='info'>Template: {$template['nama_template']}</p>";

        // Check existing fields
        $existing_fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);
        echo "<p class='info'>Existing fields: " . count($existing_fields) . "</p>";

        if (empty($existing_fields)) {
            echo "<p class='info'>No fields found. Creating default fields...</p>";

            // Create default fields
            $default_fields = array(
                array(
                    'id_template' => $id_template,
                    'nama_field' => 'skp',
                    'tipe_field' => 'file',
                    'wajib_diisi' => 1,
                    'urutan' => 1,
                    'placeholder' => 'Upload file SKP'
                ),
                array(
                    'id_template' => $id_template,
                    'nama_field' => 'ekin',
                    'tipe_field' => 'file',
                    'wajib_diisi' => 1,
                    'urutan' => 2,
                    'placeholder' => 'Upload file EKIN'
                )
            );

            foreach ($default_fields as $field) {
                $this->db->insert('field_dokumen', $field);
                echo "<p class='success'>✓ Created field: {$field['nama_field']}</p>";
            }

            echo "<p class='success'>Default fields created successfully!</p>";
        } else {
            echo "<p class='info'>Fields already exist:</p>";
            foreach ($existing_fields as $field) {
                echo "<p class='info'>- {$field['nama_field']} ({$field['tipe_field']}) - Required: " . ($field['wajib_diisi'] ? 'Yes' : 'No') . "</p>";
            }
        }

        echo "<p><a href='" . base_url('user/submission/buat/' . $id_template) . "'>Test Form</a></p>";
    }

    /**
     * Debug database connection and submission process
     */
    public function debug_submission($id_template = 1) {
        echo "<h1>Debug Submission Process</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;}</style>";

        // Test database connection
        echo "<h2>1. Database Connection Test</h2>";
        try {
            $db_status = $this->db->initialize();
            echo "<p class='success'>✓ Database connection successful</p>";

            // Test basic query
            $query = $this->db->query("SELECT COUNT(*) as count FROM submission_dokumen");
            $result = $query->row();
            echo "<p class='info'>Current submissions in database: " . $result->count . "</p>";
        } catch (Exception $e) {
            echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
            return;
        }

        // Test template data
        echo "<h2>2. Template Data Test</h2>";
        $this->load->model('Model_template_dokumen');
        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if ($template) {
            echo "<p class='success'>✓ Template found: " . $template['nama_template'] . "</p>";
            echo "<p class='info'>Template ID: " . $template['id_template'] . "</p>";
            echo "<p class='info'>Template Status: " . $template['status'] . "</p>";
        } else {
            echo "<p class='error'>✗ Template not found with ID: " . $id_template . "</p>";
            return;
        }

        // Test field template
        echo "<h2>3. Field Template Test</h2>";
        $fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);
        if (!empty($fields)) {
            echo "<p class='success'>✓ Found " . count($fields) . " fields</p>";
            echo "<table border='1' style='border-collapse:collapse;'>";
            echo "<tr><th>Field Name</th><th>Type</th><th>Required</th><th>Order</th></tr>";
            foreach ($fields as $field) {
                $is_required = ($field['wajib_diisi'] === 'ya' || $field['wajib_diisi'] === '1' || $field['wajib_diisi'] == 1);
                echo "<tr>";
                echo "<td>" . $field['nama_field'] . "</td>";
                echo "<td>" . $field['tipe_field'] . "</td>";
                echo "<td>" . ($is_required ? 'YES' : 'NO') . " (" . $field['wajib_diisi'] . ")</td>";
                echo "<td>" . $field['urutan'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='error'>✗ No fields found for template</p>";
            return;
        }

        // Test submission model
        echo "<h2>4. Submission Model Test</h2>";
        $this->load->model('Model_submission');
        $nomor_test = $this->Model_submission->generate_nomor_submission();
        echo "<p class='success'>✓ Generated submission number: " . $nomor_test . "</p>";

        // Test upload directory
        echo "<h2>5. Upload Directory Test</h2>";
        $upload_dir = './uploads/dokumen/';
        if (!is_dir($upload_dir)) {
            if (mkdir($upload_dir, 0755, true)) {
                echo "<p class='success'>✓ Upload directory created: " . realpath($upload_dir) . "</p>";
            } else {
                echo "<p class='error'>✗ Failed to create upload directory</p>";
            }
        } else {
            echo "<p class='success'>✓ Upload directory exists: " . realpath($upload_dir) . "</p>";
            echo "<p class='info'>Directory permissions: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "</p>";
        }

        // Test session
        echo "<h2>6. Session Test</h2>";
        if ($this->session->userdata('logged_in')) {
            echo "<p class='success'>✓ User is logged in</p>";
            echo "<p class='info'>User ID: " . $this->session->userdata('id_pengguna') . "</p>";
            echo "<p class='info'>User Role: " . $this->session->userdata('role') . "</p>";
            echo "<p class='info'>User Name: " . $this->session->userdata('nama_lengkap') . "</p>";
        } else {
            echo "<p class='error'>✗ User is not logged in</p>";
        }

        echo "<h2>7. Test Links</h2>";
        echo "<p><a href='" . base_url('user/submission/buat/' . $id_template) . "'>Go to Submission Form</a></p>";
        echo "<p><a href='" . base_url('user/submission/test_simple_form/' . $id_template) . "'>Test Simple Form</a></p>";
        echo "<p><a href='" . base_url('user/submission/test_form_detection/' . $id_template) . "'>Test Form Detection</a></p>";
        echo "<p><a href='" . base_url('user/submission/test_filename_format') . "'>Test Format Nama File</a></p>";
    }

    /**
     * Test simple form submission
     */
    public function test_simple_form($id_template = 1) {
        echo "<h1>Test Simple Form Submission</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;} form{margin:20px 0;} input,textarea{margin:5px;padding:8px;width:300px;} button{padding:10px 20px;background:#007cba;color:white;border:none;cursor:pointer;}</style>";

        // Load required models
        $this->load->model('Model_template_dokumen');
        $this->load->model('Model_submission');

        // Handle form submission
        if ($this->input->post()) {
            echo "<h2>Processing Form Submission...</h2>";

            // Get template data
            $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
            if (!$template) {
                echo "<p class='error'>Template not found!</p>";
                return;
            }

            // Get fields
            $fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);
            if (empty($fields)) {
                echo "<p class='error'>No fields found for template!</p>";
                return;
            }

            // Prepare submission data
            $nomor_submission = $this->Model_submission->generate_nomor_submission();
            $data_submission = array(
                'id_template' => $id_template,
                'id_pengguna' => 3, // User Demo ID
                'nomor_submission' => $nomor_submission,
                'status' => 'pending'
            );

            echo "<p class='info'>Generated submission number: " . $nomor_submission . "</p>";

            // Prepare field data
            $data_fields = array();
            $upload_success = true;
            $upload_errors = array();

            foreach ($fields as $field) {
                $field_name = $field['nama_field'];
                $is_required = ($field['wajib_diisi'] === 'ya' || $field['wajib_diisi'] === '1' || $field['wajib_diisi'] == 1);

                if ($field['tipe_field'] === 'file') {
                    // Handle file upload
                    if (!empty($_FILES[$field_name]['name'])) {
                        $upload_dir = './uploads/dokumen/';
                        if (!is_dir($upload_dir)) {
                            mkdir($upload_dir, 0755, true);
                        }

                        // Generate custom filename format: NamaField_NamaUser_TanggalUpload_KodeUnik.ext
                        $original_name = $_FILES[$field_name]['name'];
                        $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);

                        // Ambil nama user (untuk test gunakan UserDemo)
                        $nama_user_clean = 'UserDemo';

                        // Format tanggal: ddmmyyyy
                        $tanggal_upload = date('dmY');

                        // Generate kode unik 3 karakter
                        $kode_unik = strtoupper(substr(md5(uniqid()), 0, 3));

                        // Format: NamaField_NamaUser_TanggalUpload_KodeUnik.ext
                        $new_filename = $field_name . '_' . $nama_user_clean . '_' . $tanggal_upload . '_' . $kode_unik . '.' . $file_extension;
                        $upload_path = $upload_dir . $new_filename;

                        if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_path)) {
                            $data_fields[] = array(
                                'id_field' => $field['id_field'],
                                'nilai_field' => null,
                                'nama_file' => $_FILES[$field_name]['name'],
                                'path_file' => $upload_path,
                                'ukuran_file' => $_FILES[$field_name]['size']
                            );
                            echo "<p class='success'>✓ File uploaded: " . $_FILES[$field_name]['name'] . "</p>";
                        } else {
                            $upload_success = false;
                            $upload_errors[] = "Failed to upload file: " . $_FILES[$field_name]['name'];
                        }
                    } elseif ($is_required) {
                        $upload_success = false;
                        $upload_errors[] = "Required file missing: " . $field_name;
                    }
                } else {
                    // Handle other field types
                    $field_value = $this->input->post($field_name);
                    if (!empty($field_value) || !$is_required) {
                        $data_fields[] = array(
                            'id_field' => $field['id_field'],
                            'nilai_field' => $field_value,
                            'nama_file' => null,
                            'path_file' => null,
                            'ukuran_file' => null
                        );
                        echo "<p class='success'>✓ Field saved: " . $field_name . " = " . $field_value . "</p>";
                    } elseif ($is_required) {
                        $upload_success = false;
                        $upload_errors[] = "Required field missing: " . $field_name;
                    }
                }
            }

            // Show errors if any
            if (!empty($upload_errors)) {
                echo "<h3 class='error'>Validation Errors:</h3>";
                foreach ($upload_errors as $error) {
                    echo "<p class='error'>✗ " . $error . "</p>";
                }
            }

            // Save to database if no errors
            if ($upload_success) {
                $id_submission = $this->Model_submission->tambah_submission($data_submission, $data_fields);
                if ($id_submission) {
                    echo "<h3 class='success'>✓ Submission saved successfully!</h3>";
                    echo "<p class='info'>Submission ID: " . $id_submission . "</p>";
                    echo "<p class='info'>Submission Number: " . $nomor_submission . "</p>";

                    // Log activity
                    $this->load->model('Model_log_aktivitas');
                    $this->Model_log_aktivitas->tambah_log(
                        3, // User Demo ID
                        'Membuat submission baru',
                        'Membuat submission ' . $nomor_submission . ' untuk template ' . $template['nama_template']
                    );
                    echo "<p class='success'>✓ Activity logged</p>";
                } else {
                    echo "<h3 class='error'>✗ Failed to save submission to database</h3>";
                }
            } else {
                echo "<h3 class='error'>✗ Submission not saved due to validation errors</h3>";
            }

            echo "<hr>";
        }

        // Show form
        echo "<h2>Test Form</h2>";
        echo "<form method='post' enctype='multipart/form-data'>";

        // Get template and fields
        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if ($template) {
            echo "<h3>Template: " . $template['nama_template'] . "</h3>";
            echo "<p>" . $template['deskripsi'] . "</p>";

            $fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    $is_required = ($field['wajib_diisi'] === 'ya' || $field['wajib_diisi'] === '1' || $field['wajib_diisi'] == 1);
                    $required_text = $is_required ? ' *' : '';

                    echo "<div style='margin:10px 0;'>";
                    echo "<label>" . ucfirst(str_replace('_', ' ', $field['nama_field'])) . $required_text . ":</label><br>";

                    if ($field['tipe_field'] === 'file') {
                        echo "<input type='file' name='" . $field['nama_field'] . "'" . ($is_required ? ' required' : '') . ">";
                    } elseif ($field['tipe_field'] === 'textarea') {
                        echo "<textarea name='" . $field['nama_field'] . "'" . ($is_required ? ' required' : '') . "></textarea>";
                    } else {
                        echo "<input type='text' name='" . $field['nama_field'] . "'" . ($is_required ? ' required' : '') . ">";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p class='error'>No fields found for this template</p>";
            }
        } else {
            echo "<p class='error'>Template not found</p>";
        }

        echo "<div style='margin:20px 0;'>";
        echo "<button type='submit'>Submit Test Form</button>";
        echo "</div>";
        echo "</form>";

        echo "<p><a href='" . base_url('user/submission/debug_submission/' . $id_template) . "'>← Back to Debug</a></p>";
    }

    /**
     * Test form submission detection
     */
    public function test_form_detection($id_template = 1) {
        echo "<h1>Test Form Submission Detection</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;} form{margin:20px 0;} input,textarea{margin:5px;padding:8px;width:300px;} button{padding:10px 20px;background:#007cba;color:white;border:none;cursor:pointer;}</style>";

        echo "<h2>Current Request Analysis</h2>";
        echo "<p class='info'>Request Method: " . $this->input->method() . "</p>";
        echo "<p class='info'>Is POST: " . ($this->input->post() ? 'YES' : 'NO') . "</p>";
        echo "<p class='info'>Has FILES: " . (!empty($_FILES) ? 'YES' : 'NO') . "</p>";
        echo "<p class='info'>Form Submitted: " . (($this->input->post() || !empty($_FILES)) ? 'YES' : 'NO') . "</p>";

        echo "<h3>POST Data:</h3>";
        echo "<pre>" . print_r($_POST, true) . "</pre>";

        echo "<h3>FILES Data:</h3>";
        echo "<pre>" . print_r($_FILES, true) . "</pre>";

        // Check if form was submitted (either POST data or FILES data)
        $form_submitted = ($this->input->post() || !empty($_FILES));

        if ($form_submitted) {
            echo "<h2 class='success'>✓ Form Submission Detected!</h2>";

            // Test the actual submission process
            $this->load->model('Model_template_dokumen');
            $this->load->model('Model_submission');

            $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
            $fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);

            if ($template && !empty($fields)) {
                echo "<h3>Processing Submission...</h3>";

                // Simulate the submission process
                $nomor_submission = $this->Model_submission->generate_nomor_submission();
                echo "<p class='info'>Generated submission number: " . $nomor_submission . "</p>";

                // Prepare submission data
                $data_submission = array(
                    'id_template' => $id_template,
                    'id_pengguna' => 3, // User Demo ID
                    'nomor_submission' => $nomor_submission,
                    'status' => 'pending'
                );

                // Prepare field data
                $data_fields = array();
                $upload_success = true;
                $upload_errors = array();

                foreach ($fields as $field) {
                    $field_name = $field['nama_field'];
                    $is_required = ($field['wajib_diisi'] === 'ya' || $field['wajib_diisi'] === '1' || $field['wajib_diisi'] == 1);

                    if ($field['tipe_field'] === 'file') {
                        // Handle file upload
                        if (!empty($_FILES[$field_name]['name'])) {
                            $upload_dir = './uploads/dokumen/';
                            if (!is_dir($upload_dir)) {
                                mkdir($upload_dir, 0755, true);
                            }

                            // Generate custom filename format: NamaField_NamaUser_TanggalUpload_KodeUnik.ext
                            $original_name = $_FILES[$field_name]['name'];
                            $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);

                            // Ambil nama user (untuk test gunakan UserDemo)
                            $nama_user_clean = 'UserDemo';

                            // Format tanggal: ddmmyyyy
                            $tanggal_upload = date('dmY');

                            // Generate kode unik 3 karakter
                            $kode_unik = strtoupper(substr(md5(uniqid()), 0, 3));

                            // Format: NamaField_NamaUser_TanggalUpload_KodeUnik.ext
                            $new_filename = $field_name . '_' . $nama_user_clean . '_' . $tanggal_upload . '_' . $kode_unik . '.' . $file_extension;
                            $upload_path = $upload_dir . $new_filename;

                            if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_path)) {
                                $data_fields[] = array(
                                    'id_field' => $field['id_field'],
                                    'nilai_field' => null,
                                    'nama_file' => $_FILES[$field_name]['name'],
                                    'path_file' => $upload_path,
                                    'ukuran_file' => $_FILES[$field_name]['size']
                                );
                                echo "<p class='success'>✓ File uploaded: " . $_FILES[$field_name]['name'] . "</p>";
                            } else {
                                $upload_success = false;
                                $upload_errors[] = "Failed to upload file: " . $_FILES[$field_name]['name'];
                            }
                        } elseif ($is_required) {
                            $upload_success = false;
                            $upload_errors[] = "Required file missing: " . $field_name;
                        }
                    } else {
                        // Handle other field types
                        $field_value = $this->input->post($field_name);
                        if (!empty($field_value) || !$is_required) {
                            $data_fields[] = array(
                                'id_field' => $field['id_field'],
                                'nilai_field' => $field_value,
                                'nama_file' => null,
                                'path_file' => null,
                                'ukuran_file' => null
                            );
                            echo "<p class='success'>✓ Field saved: " . $field_name . " = " . $field_value . "</p>";
                        } elseif ($is_required) {
                            $upload_success = false;
                            $upload_errors[] = "Required field missing: " . $field_name;
                        }
                    }
                }

                // Show errors if any
                if (!empty($upload_errors)) {
                    echo "<h3 class='error'>Validation Errors:</h3>";
                    foreach ($upload_errors as $error) {
                        echo "<p class='error'>✗ " . $error . "</p>";
                    }
                }

                // Save to database if no errors
                if ($upload_success) {
                    $id_submission = $this->Model_submission->tambah_submission($data_submission, $data_fields);
                    if ($id_submission) {
                        echo "<h3 class='success'>✓ Submission saved successfully!</h3>";
                        echo "<p class='info'>Submission ID: " . $id_submission . "</p>";
                        echo "<p class='info'>Submission Number: " . $nomor_submission . "</p>";

                        // Log activity
                        $this->load->model('Model_log_aktivitas');
                        $this->Model_log_aktivitas->tambah_log(
                            3, // User Demo ID
                            'Membuat submission baru',
                            'Membuat submission ' . $nomor_submission . ' untuk template ' . $template['nama_template']
                        );
                        echo "<p class='success'>✓ Activity logged</p>";
                    } else {
                        echo "<h3 class='error'>✗ Failed to save submission to database</h3>";
                    }
                } else {
                    echo "<h3 class='error'>✗ Submission not saved due to validation errors</h3>";
                }
            }
        } else {
            echo "<h2>Form Not Submitted - Showing Test Form</h2>";
        }

        // Show test form
        echo "<h2>Test Form</h2>";
        echo "<form method='post' enctype='multipart/form-data'>";
        echo "<div style='margin:10px 0;'>";
        echo "<label>SKP File:</label><br>";
        echo "<input type='file' name='SKP'>";
        echo "</div>";
        echo "<div style='margin:10px 0;'>";
        echo "<label>EKIN File:</label><br>";
        echo "<input type='file' name='EKIN'>";
        echo "</div>";
        echo "<div style='margin:20px 0;'>";
        echo "<button type='submit'>Test Submit</button>";
        echo "</div>";
        echo "</form>";

        echo "<p><a href='" . base_url('user/submission/debug_submission/' . $id_template) . "'>← Back to Debug</a></p>";
    }

    public function __construct() {
        parent::__construct();

        // Skip auth check untuk test methods
        $method = $this->router->fetch_method();
        if (in_array($method, array('test_no_auth', 'debug_form', 'test_buat', 'debug_template', 'fix_template_size', 'debug_tables', 'setup_template_fields', 'debug_submission', 'test_simple_form', 'test_form_detection', 'test_filename_format'))) {
            return;
        }

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
        // Debug: Log akses ke method
        log_message('debug', 'Submission::buat() called with template ID: ' . $id_template);
        log_message('debug', 'Request method: ' . $this->input->method());
        log_message('debug', 'Is POST: ' . ($this->input->post() ? 'YES' : 'NO'));
        log_message('debug', 'Has FILES: ' . (!empty($_FILES) ? 'YES' : 'NO'));
        log_message('debug', 'Form submitted: ' . (($this->input->post() || !empty($_FILES)) ? 'YES' : 'NO'));
        log_message('debug', 'Session data: ' . print_r($this->session->all_userdata(), true));
        log_message('debug', 'POST data: ' . print_r($_POST, true));
        log_message('debug', 'FILES data: ' . print_r($_FILES, true));

        if (!$id_template) {
            log_message('error', 'Template ID is missing');
            show_404();
        }

        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        if (!$template || $template['status'] !== 'aktif') {
            log_message('error', 'Template not found or inactive: ' . $id_template);
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
        log_message('debug', 'Field template count: ' . count($data['field_template']));

        // Debugging wajib_diisi values
        log_message('debug', '--- Checking wajib_diisi values ---');
        foreach ($data['field_template'] as $field) {
            log_message('debug', 'Field: ' . $field['nama_field'] . ', wajib_diisi value: [' . $field['wajib_diisi'] . ']');
        }
        log_message('debug', '-----------------------------------');

        // Check if form was submitted (either POST data or FILES data)
        $form_submitted = ($this->input->post() || !empty($_FILES));

        if ($form_submitted) {
            log_message('debug', 'Processing form submission');
            log_message('debug', 'POST Data: ' . print_r($this->input->post(), true));
            log_message('debug', 'FILES Data: ' . print_r($_FILES, true));

            // Pastikan direktori upload ada
            $upload_dir = './uploads/dokumen/';
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    log_message('error', 'Failed to create upload directory: ' . $upload_dir);
                    $this->session->set_flashdata('error', 'Gagal membuat direktori upload.');
                    redirect('user/submission/buat/' . $id_template);
                    return;
                }
                log_message('debug', 'Created upload directory: ' . $upload_dir);
            }

            // Validasi sederhana untuk file upload
            $validation_passed = true;
            $error_messages = array();

            foreach ($data['field_template'] as $field) {
                log_message('debug', 'Checking field: ' . $field['nama_field'] . ' (type: ' . $field['tipe_field'] . ', required: ' . $field['wajib_diisi'] . ')');

                // Check if field is required - handle both 'ya'/'tidak' and 1/0 values
                $is_required = ($field['wajib_diisi'] === 'ya' || $field['wajib_diisi'] === '1' || $field['wajib_diisi'] == 1);

                if ($field['tipe_field'] === 'file' && $is_required) {
                    if (empty($_FILES[$field['nama_field']]['name'])) {
                        $validation_passed = false;
                        $error_messages[] = ucfirst(str_replace('_', ' ', $field['nama_field'])) . ' harus diupload.';
                        log_message('debug', 'Required file missing: ' . $field['nama_field']);
                    } else {
                        log_message('debug', 'File found for field: ' . $field['nama_field'] . ' - ' . $_FILES[$field['nama_field']]['name']);
                    }
                } elseif ($field['tipe_field'] !== 'file' && $is_required) {
                    // Check for other required fields
                    $field_value = $this->input->post($field['nama_field']);
                    if (empty($field_value)) {
                        $validation_passed = false;
                        $error_messages[] = ucfirst(str_replace('_', ' ', $field['nama_field'])) . ' harus diisi.';
                        log_message('debug', 'Required field missing: ' . $field['nama_field']);
                    }
                }
            }

            log_message('debug', 'Validation passed: ' . ($validation_passed ? 'YES' : 'NO'));

            if ($validation_passed) {
                log_message('debug', 'Starting submission processing');
                $result = $this->_proses_submission($template, $data['field_template']);

                if ($result['success']) {
                    log_message('debug', 'Submission successful: ' . $result['nomor_submission']);
                    $this->session->set_flashdata('success', 'Submission berhasil dibuat dengan nomor: ' . $result['nomor_submission']);
                    redirect('user/dokumen/detail_submission/' . $result['id_submission']);
                } else {
                    log_message('error', 'Submission failed: ' . $result['message']);
                    $this->session->set_flashdata('error', $result['message']);
                }
            } else {
                log_message('debug', 'Validation failed: ' . implode(', ', $error_messages));
                $this->session->set_flashdata('error', implode('<br>', $error_messages));
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

        // Check if form was submitted (either POST data or FILES data)
        $form_submitted = ($this->input->post() || !empty($_FILES));

        if ($form_submitted) {
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
     * Validasi form submission (simplified)
     */
    private function _validasi_form_submission($field_template, $mode = 'buat') {
        // Validasi sederhana - hanya cek file upload yang wajib
        foreach ($field_template as $field) {
            // Check if field is required - handle both 'ya'/'tidak' and 1/0 values
            $is_required = ($field['wajib_diisi'] === 'ya' || $field['wajib_diisi'] === '1' || $field['wajib_diisi'] == 1);

            if ($field['tipe_field'] === 'file' && $is_required) {
                if (empty($_FILES[$field['nama_field']]['name'])) {
                    return false;
                }
            } elseif ($field['tipe_field'] !== 'file' && $is_required) {
                $field_value = $this->input->post($field['nama_field']);
                if (empty($field_value)) {
                    return false;
                }
            }
        }
        return true;
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
                    $upload_result = $this->_upload_file($field['nama_field'], $template);
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
                    // Ambil template untuk konfigurasi upload
                    $template_data = $this->Model_template_dokumen->ambil_template_by_id($submission['id_template']);
                    $upload_result = $this->_upload_file($field['nama_field'], $template_data);
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
     * Upload file dengan format nama custom
     */
    private function _upload_file($field_name, $template = null) {
        // Ambil setting dari template atau gunakan default
        $max_size_bytes = 10485760; // Default 10MB
        $allowed_types = 'pdf|doc|docx|xls|xlsx|ppt|pptx|jpg|jpeg|png|gif';

        if ($template) {
            if (isset($template['max_ukuran_file']) && $template['max_ukuran_file'] > 0) {
                $max_size_bytes = $template['max_ukuran_file'];
            }
            if (isset($template['tipe_file_diizinkan']) && !empty($template['tipe_file_diizinkan'])) {
                $allowed_types = str_replace(',', '|', $template['tipe_file_diizinkan']);
            }
        }

        // Convert bytes to KB untuk CodeIgniter
        $max_size_kb = round($max_size_bytes / 1024);

        log_message('debug', 'Upload config - Max size: ' . $max_size_kb . 'KB (' . $max_size_bytes . ' bytes), Allowed types: ' . $allowed_types);

        // Generate custom filename format: NamaField_NamaUser_TanggalUpload_KodeUnik.ext
        $original_name = $_FILES[$field_name]['name'];
        $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);

        // Ambil nama user dari session
        $nama_user = $this->session->userdata('nama_lengkap');
        // Bersihkan nama user dari karakter yang tidak diinginkan
        $nama_user_clean = preg_replace('/[^a-zA-Z0-9]/', '', $nama_user);

        // Format tanggal: ddmmyyyy
        $tanggal_upload = date('dmY');

        // Generate kode unik 3 karakter
        $kode_unik = strtoupper(substr(md5(uniqid()), 0, 3));

        // Format: NamaField_NamaUser_TanggalUpload_KodeUnik.ext
        $custom_filename = $field_name . '_' . $nama_user_clean . '_' . $tanggal_upload . '_' . $kode_unik . '.' . $file_extension;

        log_message('debug', 'Custom filename generated: ' . $custom_filename);

        $config['upload_path'] = './uploads/dokumen/';
        $config['allowed_types'] = $allowed_types;
        $config['max_size'] = $max_size_kb;
        $config['file_name'] = $custom_filename;
        $config['overwrite'] = FALSE; // Jangan overwrite file yang sudah ada

        // Buat direktori jika belum ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            log_message('debug', 'File uploaded successfully: ' . $upload_data['file_name']);

            return array(
                'success' => true,
                'file_name' => $upload_data['file_name'],
                'file_size' => $upload_data['file_size'],
                'original_name' => $original_name
            );
        } else {
            $error = $this->upload->display_errors('', '');
            log_message('error', 'File upload failed: ' . $error);

            return array(
                'success' => false,
                'error' => $error
            );
        }
    }

    /**
     * Test format nama file baru
     */
    public function test_filename_format() {
        echo "<h1>Test Format Nama File</h1>";
        echo "<style>body{font-family:Arial;margin:20px;} .info{color:blue;} .success{color:green;} .error{color:red;} .example{background:#f5f5f5;padding:10px;margin:10px 0;border-left:4px solid #007cba;}</style>";

        echo "<h2>Format Nama File Baru</h2>";
        echo "<p>Format: <strong>NamaField_NamaUser_TanggalUpload_KodeUnik.ext</strong></p>";

        // Simulasi data
        $field_names = array('SKP', 'EKIN', 'Ijazah', 'Transkrip_Nilai');
        $nama_user = 'User Demo';
        $nama_user_clean = preg_replace('/[^a-zA-Z0-9]/', '', $nama_user);
        $tanggal_upload = date('dmY');

        echo "<h3>Contoh Format:</h3>";

        foreach ($field_names as $field_name) {
            $kode_unik = strtoupper(substr(md5(uniqid()), 0, 3));
            $example_filename = $field_name . '_' . $nama_user_clean . '_' . $tanggal_upload . '_' . $kode_unik . '.pdf';

            echo "<div class='example'>";
            echo "<strong>Field:</strong> " . $field_name . "<br>";
            echo "<strong>User:</strong> " . $nama_user . " → " . $nama_user_clean . "<br>";
            echo "<strong>Tanggal:</strong> " . date('d/m/Y') . " → " . $tanggal_upload . "<br>";
            echo "<strong>Kode Unik:</strong> " . $kode_unik . "<br>";
            echo "<strong>Hasil:</strong> <span class='success'>" . $example_filename . "</span>";
            echo "</div>";
        }

        echo "<h3>Penjelasan Format:</h3>";
        echo "<ul>";
        echo "<li><strong>NamaField:</strong> Nama field dari template (SKP, EKIN, dll)</li>";
        echo "<li><strong>NamaUser:</strong> Nama user yang login, dibersihkan dari karakter khusus</li>";
        echo "<li><strong>TanggalUpload:</strong> Format ddmmyyyy (contoh: 06022025 untuk 6 Februari 2025)</li>";
        echo "<li><strong>KodeUnik:</strong> 3 karakter acak untuk memastikan nama file unik</li>";
        echo "<li><strong>Ekstensi:</strong> Sesuai dengan file asli yang diupload</li>";
        echo "</ul>";

        echo "<h3>Keuntungan Format Ini:</h3>";
        echo "<ul>";
        echo "<li>✓ Mudah diidentifikasi field mana yang diupload</li>";
        echo "<li>✓ Mudah diidentifikasi siapa yang mengupload</li>";
        echo "<li>✓ Mudah diidentifikasi kapan file diupload</li>";
        echo "<li>✓ Tidak ada konflik nama file karena ada kode unik</li>";
        echo "<li>✓ Nama file tetap readable dan informatif</li>";
        echo "</ul>";

        echo "<h3>Test Upload Form:</h3>";
        echo "<p>Silakan test upload file untuk melihat format nama file yang dihasilkan:</p>";
        echo "<p><a href='" . base_url('user/submission/test_form_detection/1') . "' style='background:#007cba;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Test Upload File</a></p>";

        echo "<p><a href='" . base_url('user/submission/debug_submission/1') . "'>← Back to Debug</a></p>";
    }
}
