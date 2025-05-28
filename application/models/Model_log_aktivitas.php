<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola log aktivitas sistem
 * Menangani operasi CRUD untuk tabel log_aktivitas
 */
class Model_log_aktivitas extends CI_Model {

    private $tabel = 'log_aktivitas';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Menambah log aktivitas baru
     */
    public function tambah_log($id_pengguna, $aktivitas, $detail = null, $ip_address = null, $user_agent = null) {
        // Ambil IP address dan user agent jika tidak disediakan
        if ($ip_address === null) {
            $ip_address = $this->input->ip_address();
        }
        
        if ($user_agent === null) {
            $user_agent = $this->input->user_agent();
        }
        
        $data = array(
            'id_pengguna' => $id_pengguna,
            'aktivitas' => $aktivitas,
            'detail' => $detail,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'tanggal_aktivitas' => date('Y-m-d H:i:s')
        );
        
        return $this->db->insert($this->tabel, $data);
    }

    /**
     * Mendapatkan semua log aktivitas dengan pagination dan filter
     */
    public function ambil_semua_log($filter = array(), $limit = null, $offset = null) {
        $this->db->select('la.*, p.nama_lengkap, p.email, p.role');
        $this->db->from($this->tabel . ' la');
        $this->db->join('pengguna p', 'la.id_pengguna = p.id_pengguna', 'left');
        
        // Apply filters
        if (!empty($filter['id_pengguna'])) {
            $this->db->where('la.id_pengguna', $filter['id_pengguna']);
        }
        
        if (!empty($filter['role'])) {
            $this->db->where('p.role', $filter['role']);
        }
        
        if (!empty($filter['aktivitas'])) {
            $this->db->like('la.aktivitas', $filter['aktivitas']);
        }
        
        if (!empty($filter['tanggal_dari'])) {
            $this->db->where('DATE(la.tanggal_aktivitas) >=', $filter['tanggal_dari']);
        }
        
        if (!empty($filter['tanggal_sampai'])) {
            $this->db->where('DATE(la.tanggal_aktivitas) <=', $filter['tanggal_sampai']);
        }
        
        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('la.aktivitas', $filter['pencarian']);
            $this->db->or_like('la.detail', $filter['pencarian']);
            $this->db->or_like('p.nama_lengkap', $filter['pencarian']);
            $this->db->or_like('p.email', $filter['pencarian']);
            $this->db->group_end();
        }
        
        $this->db->order_by('la.tanggal_aktivitas', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result_array();
    }

    /**
     * Menghitung total log aktivitas dengan filter
     */
    public function hitung_total_log($filter = array()) {
        $this->db->from($this->tabel . ' la');
        $this->db->join('pengguna p', 'la.id_pengguna = p.id_pengguna', 'left');
        
        // Apply same filters as ambil_semua_log
        if (!empty($filter['id_pengguna'])) {
            $this->db->where('la.id_pengguna', $filter['id_pengguna']);
        }
        
        if (!empty($filter['role'])) {
            $this->db->where('p.role', $filter['role']);
        }
        
        if (!empty($filter['aktivitas'])) {
            $this->db->like('la.aktivitas', $filter['aktivitas']);
        }
        
        if (!empty($filter['tanggal_dari'])) {
            $this->db->where('DATE(la.tanggal_aktivitas) >=', $filter['tanggal_dari']);
        }
        
        if (!empty($filter['tanggal_sampai'])) {
            $this->db->where('DATE(la.tanggal_aktivitas) <=', $filter['tanggal_sampai']);
        }
        
        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('la.aktivitas', $filter['pencarian']);
            $this->db->or_like('la.detail', $filter['pencarian']);
            $this->db->or_like('p.nama_lengkap', $filter['pencarian']);
            $this->db->or_like('p.email', $filter['pencarian']);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }

    /**
     * Mendapatkan log aktivitas berdasarkan ID
     */
    public function ambil_log_by_id($id_log) {
        $this->db->select('la.*, p.nama_lengkap, p.email, p.role');
        $this->db->from($this->tabel . ' la');
        $this->db->join('pengguna p', 'la.id_pengguna = p.id_pengguna', 'left');
        $this->db->where('la.id_log', $id_log);
        
        $result = $this->db->get()->row_array();
        return $result ? $result : null;
    }

    /**
     * Mendapatkan aktivitas terbaru
     */
    public function ambil_aktivitas_terbaru($limit = 10) {
        $this->db->select('la.*, p.nama_lengkap, p.role');
        $this->db->from($this->tabel . ' la');
        $this->db->join('pengguna p', 'la.id_pengguna = p.id_pengguna', 'left');
        $this->db->order_by('la.tanggal_aktivitas', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan aktivitas berdasarkan pengguna
     */
    public function ambil_aktivitas_by_pengguna($id_pengguna, $limit = 10) {
        $this->db->select('la.*');
        $this->db->from($this->tabel . ' la');
        $this->db->where('la.id_pengguna', $id_pengguna);
        $this->db->order_by('la.tanggal_aktivitas', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan statistik aktivitas harian
     */
    public function ambil_statistik_harian($hari = 7) {
        $tanggal_mulai = date('Y-m-d', strtotime('-' . ($hari - 1) . ' days'));
        
        $this->db->select("DATE(tanggal_aktivitas) as tanggal, COUNT(*) as jumlah");
        $this->db->where('DATE(tanggal_aktivitas) >=', $tanggal_mulai);
        $this->db->group_by('DATE(tanggal_aktivitas)');
        $this->db->order_by('tanggal', 'ASC');
        
        $result = $this->db->get($this->tabel)->result_array();
        
        // Format data untuk chart
        $data = array();
        for ($i = $hari - 1; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime('-' . $i . ' days'));
            $data[$tanggal] = 0;
        }
        
        foreach ($result as $row) {
            $data[$row['tanggal']] = (int)$row['jumlah'];
        }
        
        return $data;
    }

    /**
     * Mendapatkan aktivitas paling sering dilakukan
     */
    public function ambil_aktivitas_populer($limit = 10) {
        $this->db->select('aktivitas, COUNT(*) as jumlah');
        $this->db->group_by('aktivitas');
        $this->db->order_by('jumlah', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get($this->tabel)->result_array();
    }

    /**
     * Menghapus log lama (untuk maintenance)
     */
    public function hapus_log_lama($hari = 90) {
        $tanggal_batas = date('Y-m-d', strtotime('-' . $hari . ' days'));
        
        $this->db->where('DATE(tanggal_aktivitas) <', $tanggal_batas);
        return $this->db->delete($this->tabel);
    }

    /**
     * Mendapatkan total ukuran tabel log
     */
    public function ambil_ukuran_tabel() {
        $query = $this->db->query("
            SELECT 
                ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'ukuran_mb'
            FROM information_schema.tables 
            WHERE table_schema = DATABASE() 
            AND table_name = '" . $this->tabel . "'
        ");
        
        $result = $query->row_array();
        return $result ? $result['ukuran_mb'] : 0;
    }

    /**
     * Export log aktivitas ke CSV
     */
    public function export_log($filter = array()) {
        $logs = $this->ambil_semua_log($filter);
        
        // Set header untuk download CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="log_aktivitas_' . date('Y-m-d') . '.csv"');
        header('Cache-Control: max-age=0');
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, array(
            'ID Log',
            'Nama Pengguna',
            'Email',
            'Role',
            'Aktivitas',
            'Detail',
            'IP Address',
            'User Agent',
            'Tanggal Aktivitas'
        ));
        
        // Data CSV
        foreach ($logs as $log) {
            fputcsv($output, array(
                $log['id_log'],
                $log['nama_lengkap'],
                $log['email'],
                $log['role'],
                $log['aktivitas'],
                $log['detail'],
                $log['ip_address'],
                $log['user_agent'],
                $log['tanggal_aktivitas']
            ));
        }
        
        fclose($output);
    }

    /**
     * Mendapatkan ringkasan aktivitas untuk dashboard
     */
    public function ambil_ringkasan_aktivitas() {
        $ringkasan = array();
        
        // Total aktivitas hari ini
        $this->db->where('DATE(tanggal_aktivitas)', date('Y-m-d'));
        $ringkasan['hari_ini'] = $this->db->count_all_results($this->tabel);
        
        // Total aktivitas minggu ini
        $this->db->where('WEEK(tanggal_aktivitas)', date('W'));
        $this->db->where('YEAR(tanggal_aktivitas)', date('Y'));
        $ringkasan['minggu_ini'] = $this->db->count_all_results($this->tabel);
        
        // Total aktivitas bulan ini
        $this->db->where('MONTH(tanggal_aktivitas)', date('m'));
        $this->db->where('YEAR(tanggal_aktivitas)', date('Y'));
        $ringkasan['bulan_ini'] = $this->db->count_all_results($this->tabel);
        
        // Total semua aktivitas
        $ringkasan['total'] = $this->db->count_all($this->tabel);
        
        return $ringkasan;
    }
}
