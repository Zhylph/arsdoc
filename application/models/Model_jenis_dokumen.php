<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola data jenis dokumen
 * Menangani operasi CRUD untuk tabel jenis_dokumen
 */
class Model_jenis_dokumen extends CI_Model {

    private $tabel = 'jenis_dokumen';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mendapatkan semua data jenis dokumen dengan pagination dan filter
     * @param array $filter - filter untuk pencarian
     * @param int $limit - jumlah data per halaman
     * @param int $offset - offset untuk pagination
     * @return array
     */
    public function ambil_semua_jenis_dokumen($filter = array(), $limit = null, $offset = null) {
        $this->db->select('jd.*, p.nama_lengkap as dibuat_oleh_nama, COUNT(td.id_template) as jumlah_template');
        $this->db->from($this->tabel . ' jd');
        $this->db->join('pengguna p', 'jd.dibuat_oleh = p.id_pengguna', 'left');
        $this->db->join('template_dokumen td', 'jd.id_jenis = td.id_jenis', 'left');

        // Apply filters
        if (!empty($filter['status'])) {
            $this->db->where('jd.status', $filter['status']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('jd.nama_jenis', $filter['pencarian']);
            $this->db->or_like('jd.deskripsi', $filter['pencarian']);
            $this->db->group_end();
        }

        if (!empty($filter['dibuat_oleh'])) {
            $this->db->where('jd.dibuat_oleh', $filter['dibuat_oleh']);
        }

        $this->db->group_by('jd.id_jenis');
        $this->db->order_by('jd.tanggal_dibuat', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Menghitung total data jenis dokumen dengan filter
     * @param array $filter
     * @return int
     */
    public function hitung_semua_jenis_dokumen($filter = array()) {
        $this->db->from($this->tabel . ' jd');

        if (!empty($filter['status'])) {
            $this->db->where('jd.status', $filter['status']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('jd.nama_jenis', $filter['pencarian']);
            $this->db->or_like('jd.deskripsi', $filter['pencarian']);
            $this->db->group_end();
        }

        if (!empty($filter['dibuat_oleh'])) {
            $this->db->where('jd.dibuat_oleh', $filter['dibuat_oleh']);
        }

        return $this->db->count_all_results();
    }

    /**
     * Mendapatkan data jenis dokumen berdasarkan ID
     * @param int $id_jenis
     * @return array|null
     */
    public function ambil_jenis_dokumen_by_id($id_jenis) {
        $this->db->select('jd.*, p.nama_lengkap as dibuat_oleh_nama');
        $this->db->from($this->tabel . ' jd');
        $this->db->join('pengguna p', 'jd.dibuat_oleh = p.id_pengguna', 'left');
        $this->db->where('jd.id_jenis', $id_jenis);

        $result = $this->db->get()->row_array();
        return $result ? $result : null;
    }

    /**
     * Menambah jenis dokumen baru
     * @param array $data
     * @return bool
     */
    public function tambah_jenis_dokumen($data) {
        return $this->db->insert($this->tabel, $data);
    }

    /**
     * Mengupdate data jenis dokumen
     * @param int $id_jenis
     * @param array $data
     * @return bool
     */
    public function update_jenis_dokumen($id_jenis, $data) {
        $this->db->where('id_jenis', $id_jenis);
        return $this->db->update($this->tabel, $data);
    }

    /**
     * Menghapus jenis dokumen
     * @param int $id_jenis
     * @return bool
     */
    public function hapus_jenis_dokumen($id_jenis) {
        // Cek apakah ada template yang menggunakan jenis dokumen ini
        $this->db->where('id_jenis', $id_jenis);
        $count_template = $this->db->count_all_results('template_dokumen');

        if ($count_template > 0) {
            return false; // Tidak bisa dihapus karena masih digunakan
        }

        $this->db->where('id_jenis', $id_jenis);
        return $this->db->delete($this->tabel);
    }

    /**
     * Mengubah status jenis dokumen
     * @param int $id_jenis
     * @param string $status
     * @return bool
     */
    public function ubah_status_jenis_dokumen($id_jenis, $status) {
        $data = array('status' => $status);
        $this->db->where('id_jenis', $id_jenis);
        return $this->db->update($this->tabel, $data);
    }

    /**
     * Cek apakah nama jenis dokumen sudah digunakan
     * @param string $nama_jenis
     * @param int $exclude_id - ID yang dikecualikan (untuk update)
     * @return bool
     */
    public function cek_nama_jenis_tersedia($nama_jenis, $exclude_id = null) {
        $this->db->where('nama_jenis', $nama_jenis);
        if ($exclude_id) {
            $this->db->where('id_jenis !=', $exclude_id);
        }
        $count = $this->db->count_all_results($this->tabel);
        return $count == 0;
    }

    /**
     * Mendapatkan jenis dokumen aktif untuk dropdown
     * @return array
     */
    public function ambil_jenis_dokumen_aktif() {
        $this->db->select('id_jenis, nama_jenis');
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_jenis', 'ASC');
        return $this->db->get($this->tabel)->result_array();
    }

    /**
     * Mendapatkan statistik jenis dokumen
     * @return array
     */
    public function ambil_statistik_jenis_dokumen() {
        $statistik = array();

        // Total jenis dokumen
        $statistik['total'] = $this->db->count_all_results($this->tabel);

        // Jenis dokumen aktif
        $this->db->where('status', 'aktif');
        $statistik['aktif'] = $this->db->count_all_results($this->tabel);

        // Jenis dokumen nonaktif
        $this->db->where('status', 'nonaktif');
        $statistik['nonaktif'] = $this->db->count_all_results($this->tabel);

        // Jenis dokumen dengan template terbanyak
        $this->db->select('jd.nama_jenis, COUNT(td.id_template) as jumlah_template');
        $this->db->from($this->tabel . ' jd');
        $this->db->join('template_dokumen td', 'jd.id_jenis = td.id_jenis', 'left');
        $this->db->where('jd.status', 'aktif');
        $this->db->group_by('jd.id_jenis');
        $this->db->order_by('jumlah_template', 'DESC');
        $this->db->limit(5);
        $statistik['populer'] = $this->db->get()->result_array();

        return $statistik;
    }

    /**
     * Mendapatkan template dokumen berdasarkan jenis
     * @param int $id_jenis
     * @return array
     */
    public function ambil_template_by_jenis($id_jenis) {
        $this->db->select('td.*, COUNT(sd.id_submission) as jumlah_submission');
        $this->db->from('template_dokumen td');
        $this->db->join('submission_dokumen sd', 'td.id_template = sd.id_template', 'left');
        $this->db->where('td.id_jenis', $id_jenis);
        $this->db->group_by('td.id_template');
        $this->db->order_by('td.tanggal_dibuat', 'DESC');

        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan jenis dokumen aktif untuk dropdown (alias)
     */
    public function ambil_jenis_aktif() {
        return $this->ambil_jenis_dokumen_aktif();
    }

    /**
     * Catat aktivitas terkait jenis dokumen
     * @param string $aktivitas
     * @param string $detail
     * @param int $id_pengguna
     */
    public function catat_aktivitas($aktivitas, $detail, $id_pengguna) {
        $data_log = array(
            'id_pengguna' => $id_pengguna,
            'aktivitas' => $aktivitas,
            'detail' => $detail,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        );

        $this->db->insert('log_aktivitas', $data_log);
    }
}
