<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola data pengguna
 * Menangani operasi CRUD untuk tabel pengguna
 */
class Model_pengguna extends CI_Model {

    private $tabel = 'pengguna';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mendapatkan semua data pengguna
     * @param array $filter - filter untuk pencarian
     * @return array
     */
    public function ambil_semua_pengguna($filter = array()) {
        $this->db->select('id_pengguna, nama_lengkap, email, role, status, foto_profil, tanggal_dibuat');

        if (!empty($filter['role'])) {
            $this->db->where('role', $filter['role']);
        }

        if (!empty($filter['status'])) {
            $this->db->where('status', $filter['status']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('nama_lengkap', $filter['pencarian']);
            $this->db->or_like('email', $filter['pencarian']);
            $this->db->group_end();
        }

        $this->db->order_by('tanggal_dibuat', 'DESC');
        return $this->db->get($this->tabel)->result_array();
    }

    /**
     * Mendapatkan data pengguna berdasarkan ID
     * @param int $id_pengguna
     * @return array|null
     */
    public function ambil_pengguna_by_id($id_pengguna) {
        $this->db->select('id_pengguna, nama_lengkap, email, role, status, foto_profil, tanggal_dibuat, tanggal_diperbarui');
        $this->db->where('id_pengguna', $id_pengguna);
        $result = $this->db->get($this->tabel)->row_array();
        return $result ? $result : null;
    }

    /**
     * Mendapatkan data pengguna berdasarkan email
     * @param string $email
     * @return array|null
     */
    public function ambil_pengguna_by_email($email) {
        $this->db->where('email', $email);
        $result = $this->db->get($this->tabel)->row_array();
        return $result ? $result : null;
    }

    /**
     * Validasi login pengguna
     * @param string $email
     * @param string $password
     * @return array|false
     */
    public function validasi_login($email, $password) {
        $pengguna = $this->ambil_pengguna_by_email($email);

        if ($pengguna && $pengguna['status'] === 'aktif') {
            if (password_verify($password, $pengguna['password'])) {
                // Hapus password dari data yang dikembalikan
                unset($pengguna['password']);
                return $pengguna;
            }
        }

        return false;
    }

    /**
     * Menambah pengguna baru
     * @param array $data
     * @return bool
     */
    public function tambah_pengguna($data) {
        // Hash password sebelum disimpan
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->db->insert($this->tabel, $data);
    }

    /**
     * Mengupdate data pengguna
     * @param int $id_pengguna
     * @param array $data
     * @return bool
     */
    public function update_pengguna($id_pengguna, $data) {
        // Hash password jika ada perubahan password
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Hapus password dari data jika kosong
            unset($data['password']);
        }

        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->update($this->tabel, $data);
    }

    /**
     * Menghapus pengguna
     * @param int $id_pengguna
     * @return bool
     */
    public function hapus_pengguna($id_pengguna) {
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->delete($this->tabel);
    }

    /**
     * Mengubah status pengguna
     * @param int $id_pengguna
     * @param string $status
     * @return bool
     */
    public function ubah_status_pengguna($id_pengguna, $status) {
        $data = array('status' => $status);
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->update($this->tabel, $data);
    }

    /**
     * Cek apakah email sudah digunakan
     * @param string $email
     * @param int $exclude_id - ID yang dikecualikan (untuk update)
     * @return bool
     */
    public function cek_email_tersedia($email, $exclude_id = null) {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id_pengguna !=', $exclude_id);
        }
        $count = $this->db->count_all_results($this->tabel);
        return $count == 0;
    }

    /**
     * Mendapatkan jumlah pengguna berdasarkan role
     * @return array
     */
    public function hitung_pengguna_by_role($role = null) {
        if ($role) {
            $this->db->where('role', $role);
            return $this->db->count_all_results($this->tabel);
        }

        $this->db->select('role, COUNT(*) as jumlah');
        $this->db->where('status', 'aktif');
        $this->db->group_by('role');
        $result = $this->db->get($this->tabel)->result_array();

        $data = array(
            'admin' => 0,
            'staff' => 0,
            'user' => 0
        );

        foreach ($result as $row) {
            $data[$row['role']] = $row['jumlah'];
        }

        return $data;
    }

    /**
     * Menghitung total pengguna dengan filter
     */
    public function hitung_total_pengguna($filter = array()) {
        if (!empty($filter['role'])) {
            $this->db->where('role', $filter['role']);
        }

        if (!empty($filter['status'])) {
            $this->db->where('status', $filter['status']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('nama_lengkap', $filter['pencarian']);
            $this->db->or_like('email', $filter['pencarian']);
            $this->db->group_end();
        }

        return $this->db->count_all_results($this->tabel);
    }

    /**
     * Menghitung pengguna berdasarkan status
     */
    public function hitung_pengguna_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results($this->tabel);
    }

    /**
     * Mendapatkan statistik pengguna untuk detail
     */
    public function ambil_statistik_pengguna($id_pengguna) {
        $statistik = array();

        // Jika user, hitung submission
        $this->db->where('id_pengguna', $id_pengguna);
        $statistik['total_submission'] = $this->db->count_all_results('submission_dokumen');

        // Jika staff, hitung yang diproses
        $this->db->where('diproses_oleh', $id_pengguna);
        $statistik['total_diproses'] = $this->db->count_all_results('submission_dokumen');

        // Hitung file pribadi
        $this->db->where('id_pengguna', $id_pengguna);
        $statistik['total_file_pribadi'] = $this->db->count_all_results('file_pribadi');

        // Hitung log aktivitas
        $this->db->where('id_pengguna', $id_pengguna);
        $statistik['total_aktivitas'] = $this->db->count_all_results('log_aktivitas');

        // Tanggal login terakhir (dari log aktivitas)
        $this->db->select('tanggal_aktivitas');
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->where('aktivitas', 'Login');
        $this->db->order_by('tanggal_aktivitas', 'DESC');
        $this->db->limit(1);
        $login_terakhir = $this->db->get('log_aktivitas')->row_array();
        $statistik['login_terakhir'] = $login_terakhir ? $login_terakhir['tanggal_aktivitas'] : null;

        return $statistik;
    }

    /**
     * Update foto profil pengguna
     * @param int $id_pengguna
     * @param string $nama_file
     * @return bool
     */
    public function update_foto_profil($id_pengguna, $nama_file) {
        $data = array('foto_profil' => $nama_file);
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->update($this->tabel, $data);
    }

    /**
     * Mendapatkan pengguna staff untuk dropdown
     * @return array
     */
    public function ambil_staff_aktif() {
        $this->db->select('id_pengguna, nama_lengkap');
        $this->db->where('role', 'staff');
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_lengkap', 'ASC');
        return $this->db->get($this->tabel)->result_array();
    }

    /**
     * Update password pengguna
     * @param int $id_pengguna
     * @param string $password_baru
     * @return bool
     */
    public function update_password($id_pengguna, $password_baru) {
        $data = array('password' => password_hash($password_baru, PASSWORD_DEFAULT));
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->update($this->tabel, $data);
    }
}
