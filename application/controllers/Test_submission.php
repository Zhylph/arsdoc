<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_submission extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    public function index() {
        echo "<h1>Test Submission Controller Working!</h1>";
        echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
        echo "<p>Base URL: " . base_url() . "</p>";
        echo "<p>Current URL: " . current_url() . "</p>";
        
        
        echo "<h2>Session Test:</h2>";
        echo "<pre>" . print_r($this->session->all_userdata(), true) . "</pre>";
        
        
        echo "<h2>Test Form:</h2>";
        if ($this->input->post()) {
            echo "<h3>POST Data Received:</h3>";
            echo "<pre>" . print_r($_POST, true) . "</pre>";
            echo "<h3>FILES Data Received:</h3>";
            echo "<pre>" . print_r($_FILES, true) . "</pre>";
        }
        
        echo '<form method="POST" enctype="multipart/form-data">';
        echo '<p>Nama: <input type="text" name="nama" required></p>';
        echo '<p>File: <input type="file" name="test_file" required></p>';
        echo '<p><button type="submit">Submit Test</button></p>';
        echo '</form>';
    }

    public function test_user_submission($id_template = 1) {
        echo "<h1>Test User Submission Form</h1>";
        echo "<p>Template ID: " . $id_template . "</p>";
        
        
        $this->load->model('Model_template_dokumen');
        
        
        $template = $this->Model_template_dokumen->ambil_template_by_id($id_template);
        
        if (!$template) {
            echo "<p style='color:red;'>Template not found!</p>";
            return;
        }
        
        echo "<h2>Template Info:</h2>";
        echo "<pre>" . print_r($template, true) . "</pre>";
        
        
        $fields = $this->Model_template_dokumen->ambil_field_by_template($id_template);
        echo "<h2>Template Fields:</h2>";
        echo "<pre>" . print_r($fields, true) . "</pre>";
        
        
        if ($this->input->post()) {
            echo "<h2>Form Submitted!</h2>";
            echo "<h3>POST Data:</h3>";
            echo "<pre>" . print_r($_POST, true) . "</pre>";
            echo "<h3>FILES Data:</h3>";
            echo "<pre>" . print_r($_FILES, true) . "</pre>";
            
            
            if (!empty($_FILES)) {
                foreach ($_FILES as $field_name => $file) {
                    if ($file['error'] === UPLOAD_ERR_OK) {
                        echo "<p style='color:green;'>File {$field_name} uploaded successfully: {$file['name']}</p>";
                    } else {
                        echo "<p style='color:red;'>File {$field_name} upload error: " . $file['error'] . "</p>";
                    }
                }
            }
        }
        
        
        echo "<h2>Test Submission Form:</h2>";
        echo '<form method="POST" enctype="multipart/form-data">';
        
        foreach ($fields as $field) {
            echo "<div style='margin-bottom: 15px;'>";
            echo "<label><strong>" . ucfirst(str_replace('_', ' ', $field['nama_field'])) . ":</strong></label><br>";
            
            if ($field['tipe_field'] === 'text') {
                echo '<input type="text" name="' . $field['nama_field'] . '" ' . ($field['wajib_diisi'] ? 'required' : '') . '>';
            } elseif ($field['tipe_field'] === 'textarea') {
                echo '<textarea name="' . $field['nama_field'] . '" ' . ($field['wajib_diisi'] ? 'required' : '') . '></textarea>';
            } elseif ($field['tipe_field'] === 'file') {
                echo '<input type="file" name="' . $field['nama_field'] . '" ' . ($field['wajib_diisi'] ? 'required' : '') . '>';
            } elseif ($field['tipe_field'] === 'select') {
                echo '<select name="' . $field['nama_field'] . '" ' . ($field['wajib_diisi'] ? 'required' : '') . '>';
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
        
        echo '<p><button type="submit" style="background:blue;color:white;padding:10px 20px;border:none;cursor:pointer;">Submit Test</button></p>';
        echo '</form>';
    }
}
?>
