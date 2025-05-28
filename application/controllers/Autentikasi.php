<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk menangani autentikasi pengguna
 * Mengelola login, logout, dan registrasi
 */
class Autentikasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_pengguna');
        $this->load->library('form_validation');
    }

    /**
     * Halaman login
     */
    public function index() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role();
            return;
        }

        $this->login();
    }

    /**
     * Proses login
     */
    public function login() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role();
            return;
        }

        $data = array(
            'title' => 'Masuk - Sistem Arsip Dokumen',
            'error_message' => ''
        );

        if ($this->input->post()) {
            $this->_proses_login();
        } else {
            $this->load->view('autentikasi/login', $data);
        }
    }

    /**
     * Proses logout
     */
    public function logout() {
        // Catat aktivitas logout
        if ($this->session->userdata('logged_in')) {
            $this->_catat_aktivitas('Logout dari sistem');
        }

        // Hapus semua session data
        $this->session->sess_destroy();
        
        // Redirect ke halaman login dengan pesan
        $this->session->set_flashdata('success_message', 'Anda telah berhasil keluar dari sistem.');
        redirect('autentikasi/login');
    }

    /**
     * Halaman registrasi (hanya untuk role user)
     */
    public function registrasi() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role();
            return;
        }

        $data = array(
            'title' => 'Daftar - Sistem Arsip Dokumen',
            'error_message' => ''
        );

        if ($this->input->post()) {
            $this->_proses_registrasi();
        } else {
            $this->load->view('autentikasi/registrasi', $data);
        }
    }

    /**
     * Proses login pengguna
     */
    private function _proses_login() {
        // Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Masuk - Sistem Arsip Dokumen',
                'error_message' => validation_errors()
            );
            $this->load->view('autentikasi/login', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $pengguna = $this->Model_pengguna->validasi_login($email, $password);

            if ($pengguna) {
                // Set session data
                $session_data = array(
                    'id_pengguna' => $pengguna['id_pengguna'],
                    'nama_lengkap' => $pengguna['nama_lengkap'],
                    'email' => $pengguna['email'],
                    'role' => $pengguna['role'],
                    'foto_profil' => $pengguna['foto_profil'],
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);

                // Catat aktivitas login
                $this->_catat_aktivitas('Login ke sistem');

                // Redirect berdasarkan role
                $this->_redirect_by_role();
            } else {
                $data = array(
                    'title' => 'Masuk - Sistem Arsip Dokumen',
                    'error_message' => 'Email atau password tidak valid, atau akun Anda tidak aktif.'
                );
                $this->load->view('autentikasi/login', $data);
            }
        }
    }

    /**
     * Proses registrasi pengguna baru
     */
    private function _proses_registrasi() {
        // Set validation rules
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[pengguna.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Daftar - Sistem Arsip Dokumen',
                'error_message' => validation_errors()
            );
            $this->load->view('autentikasi/registrasi', $data);
        } else {
            $data_pengguna = array(
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'user', // Default role untuk registrasi
                'status' => 'aktif'
            );

            if ($this->Model_pengguna->tambah_pengguna($data_pengguna)) {
                $this->session->set_flashdata('success_message', 'Registrasi berhasil! Silakan login dengan akun Anda.');
                redirect('autentikasi/login');
            } else {
                $data = array(
                    'title' => 'Daftar - Sistem Arsip Dokumen',
                    'error_message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
                );
                $this->load->view('autentikasi/registrasi', $data);
            }
        }
    }

    /**
     * Redirect berdasarkan role pengguna
     */
    private function _redirect_by_role() {
        $role = $this->session->userdata('role');
        
        switch ($role) {
            case 'admin':
                redirect('admin/dashboard');
                break;
            case 'staff':
                redirect('staff/dashboard');
                break;
            case 'user':
                redirect('user/dashboard');
                break;
            default:
                redirect('autentikasi/logout');
                break;
        }
    }

    /**
     * Catat aktivitas pengguna
     */
    private function _catat_aktivitas($aktivitas, $detail = '') {
        if ($this->session->userdata('logged_in')) {
            $data_log = array(
                'id_pengguna' => $this->session->userdata('id_pengguna'),
                'aktivitas' => $aktivitas,
                'detail' => $detail,
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent()
            );
            
            // Insert ke tabel log_aktivitas
            $this->db->insert('log_aktivitas', $data_log);
        }
    }

    /**
     * Cek apakah pengguna sudah login
     */
    public function cek_login() {
        if (!$this->session->userdata('logged_in')) {
            redirect('autentikasi/login');
        }
    }

    /**
     * Cek role pengguna
     */
    public function cek_role($role_yang_diizinkan = array()) {
        $this->cek_login();
        
        $role_pengguna = $this->session->userdata('role');
        
        if (!in_array($role_pengguna, $role_yang_diizinkan)) {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }
}
