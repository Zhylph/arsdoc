<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola data template dokumen
 * Menangani operasi CRUD untuk tabel template_dokumen dan field_dokumen
 */
class Model_template_dokumen extends CI_Model {

    private $tabel_template = 'template_dokumen';
    private $tabel_field = 'field_dokumen';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mendapatkan semua data template dokumen dengan pagination dan filter
     */
    public function ambil_semua_template($filter = array(), $limit = null, $offset = null) {
        $this->db->select('td.*, jd.nama_jenis, p.nama_lengkap as dibuat_oleh_nama, COUNT(sd.id_submission) as jumlah_submission, COUNT(fd.id_field) as jumlah_field');
        $this->db->from($this->tabel_template . ' td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis', 'left');
        $this->db->join('pengguna p', 'td.dibuat_oleh = p.id_pengguna', 'left');
        $this->db->join('submission_dokumen sd', 'td.id_template = sd.id_template', 'left');
        $this->db->join($this->tabel_field . ' fd', 'td.id_template = fd.id_template', 'left');

        // Apply filters
        if (!empty($filter['status'])) {
            $this->db->where('td.status', $filter['status']);
        }

        if (!empty($filter['id_jenis'])) {
            $this->db->where('td.id_jenis', $filter['id_jenis']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('td.nama_template', $filter['pencarian']);
            $this->db->or_like('td.deskripsi', $filter['pencarian']);
            $this->db->or_like('jd.nama_jenis', $filter['pencarian']);
            $this->db->group_end();
        }

        if (!empty($filter['dibuat_oleh'])) {
            $this->db->where('td.dibuat_oleh', $filter['dibuat_oleh']);
        }

        $this->db->group_by('td.id_template');
        $this->db->order_by('td.tanggal_dibuat', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Menghitung total data template dokumen dengan filter
     */
    public function hitung_semua_template($filter = array()) {
        $this->db->from($this->tabel_template . ' td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis', 'left');

        if (!empty($filter['status'])) {
            $this->db->where('td.status', $filter['status']);
        }

        if (!empty($filter['id_jenis'])) {
            $this->db->where('td.id_jenis', $filter['id_jenis']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('td.nama_template', $filter['pencarian']);
            $this->db->or_like('td.deskripsi', $filter['pencarian']);
            $this->db->or_like('jd.nama_jenis', $filter['pencarian']);
            $this->db->group_end();
        }

        if (!empty($filter['dibuat_oleh'])) {
            $this->db->where('td.dibuat_oleh', $filter['dibuat_oleh']);
        }

        return $this->db->count_all_results();
    }

    /**
     * Mendapatkan data template dokumen berdasarkan ID
     */
    public function ambil_template_by_id($id_template) {
        $this->db->select('td.*, jd.nama_jenis, p.nama_lengkap as dibuat_oleh_nama');
        $this->db->from($this->tabel_template . ' td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis', 'left');
        $this->db->join('pengguna p', 'td.dibuat_oleh = p.id_pengguna', 'left');
        $this->db->where('td.id_template', $id_template);

        $result = $this->db->get()->row_array();
        return $result ? $result : null;
    }

    /**
     * Mendapatkan field dokumen berdasarkan template
     */
    public function ambil_field_by_template($id_template) {
        $this->db->where('id_template', $id_template);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->tabel_field)->result_array();
    }

    /**
     * Menambah template dokumen baru dengan field
     */
    public function tambah_template($data_template, $data_fields = array()) {
        $this->db->trans_start();

        // Insert template
        $this->db->insert($this->tabel_template, $data_template);
        $id_template = $this->db->insert_id();

        // Insert fields jika ada
        if (!empty($data_fields)) {
            foreach ($data_fields as $field) {
                $field['id_template'] = $id_template;
                $this->db->insert($this->tabel_field, $field);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $id_template;
    }

    /**
     * Mengupdate template dokumen dengan field
     */
    public function update_template($id_template, $data_template, $data_fields = array()) {
        $this->db->trans_start();

        // Update template
        $this->db->where('id_template', $id_template);
        $this->db->update($this->tabel_template, $data_template);

        // Hapus field lama
        $this->db->where('id_template', $id_template);
        $this->db->delete($this->tabel_field);

        // Insert field baru
        if (!empty($data_fields)) {
            foreach ($data_fields as $field) {
                $field['id_template'] = $id_template;
                $this->db->insert($this->tabel_field, $field);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Menghapus template dokumen
     */
    public function hapus_template($id_template) {
        // Cek apakah ada submission yang menggunakan template ini
        $this->db->where('id_template', $id_template);
        $count_submission = $this->db->count_all_results('submission_dokumen');

        if ($count_submission > 0) {
            return false; // Tidak bisa dihapus karena masih digunakan
        }

        $this->db->trans_start();

        // Hapus field terlebih dahulu
        $this->db->where('id_template', $id_template);
        $this->db->delete($this->tabel_field);

        // Hapus template
        $this->db->where('id_template', $id_template);
        $this->db->delete($this->tabel_template);

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Mengubah status template dokumen
     */
    public function ubah_status_template($id_template, $status) {
        $data = array('status' => $status);
        $this->db->where('id_template', $id_template);
        return $this->db->update($this->tabel_template, $data);
    }

    /**
     * Cek apakah nama template sudah digunakan dalam jenis yang sama
     */
    public function cek_nama_template_tersedia($nama_template, $id_jenis, $exclude_id = null) {
        $this->db->where('nama_template', $nama_template);
        $this->db->where('id_jenis', $id_jenis);
        if ($exclude_id) {
            $this->db->where('id_template !=', $exclude_id);
        }
        $count = $this->db->count_all_results($this->tabel_template);
        return $count == 0;
    }

    /**
     * Mendapatkan template aktif untuk dropdown
     */
    public function ambil_template_aktif($id_jenis = null) {
        $this->db->select('td.id_template, td.nama_template, jd.nama_jenis');
        $this->db->from($this->tabel_template . ' td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis');
        $this->db->where('td.status', 'aktif');
        $this->db->where('jd.status', 'aktif');

        if ($id_jenis) {
            $this->db->where('td.id_jenis', $id_jenis);
        }

        $this->db->order_by('jd.nama_jenis, td.nama_template', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan statistik template dokumen
     */
    public function ambil_statistik_template() {
        $statistik = array();

        // Total template
        $statistik['total'] = $this->db->count_all_results($this->tabel_template);

        // Template aktif
        $this->db->where('status', 'aktif');
        $statistik['aktif'] = $this->db->count_all_results($this->tabel_template);

        // Template nonaktif
        $this->db->where('status', 'nonaktif');
        $statistik['nonaktif'] = $this->db->count_all_results($this->tabel_template);

        // Template dengan submission terbanyak
        $this->db->select('td.nama_template, jd.nama_jenis, COUNT(sd.id_submission) as jumlah_submission');
        $this->db->from($this->tabel_template . ' td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis');
        $this->db->join('submission_dokumen sd', 'td.id_template = sd.id_template', 'left');
        $this->db->where('td.status', 'aktif');
        $this->db->group_by('td.id_template');
        $this->db->order_by('jumlah_submission', 'DESC');
        $this->db->limit(5);
        $statistik['populer'] = $this->db->get()->result_array();

        return $statistik;
    }

    /**
     * Mendapatkan submission berdasarkan template
     */
    public function ambil_submission_by_template($id_template, $limit = null) {
        $this->db->select('sd.*, p.nama_lengkap, ps.nama_lengkap as diproses_oleh_nama');
        $this->db->from('submission_dokumen sd');
        $this->db->join('pengguna p', 'sd.id_pengguna = p.id_pengguna');
        $this->db->join('pengguna ps', 'sd.diproses_oleh = ps.id_pengguna', 'left');
        $this->db->where('sd.id_template', $id_template);
        $this->db->order_by('sd.tanggal_submission', 'DESC');

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Duplikasi template dokumen
     */
    public function duplikasi_template($id_template, $nama_baru, $id_pengguna) {
        $template = $this->ambil_template_by_id($id_template);
        if (!$template) {
            return false;
        }

        $fields = $this->ambil_field_by_template($id_template);

        // Data template baru
        $data_template = array(
            'id_jenis' => $template['id_jenis'],
            'nama_template' => $nama_baru,
            'deskripsi' => $template['deskripsi'] . ' (Salinan)',
            'instruksi_upload' => $template['instruksi_upload'],
            'max_ukuran_file' => $template['max_ukuran_file'],
            'tipe_file_diizinkan' => $template['tipe_file_diizinkan'],
            'status' => 'nonaktif', // Default nonaktif untuk template baru
            'dibuat_oleh' => $id_pengguna
        );

        return $this->tambah_template($data_template, $fields);
    }

    /**
     * Menghitung total template dengan filter
     */
    public function hitung_total_template($filter = array()) {
        $this->db->from($this->tabel_template . ' td');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis', 'left');

        if (!empty($filter['status'])) {
            $this->db->where('td.status', $filter['status']);
        }

        if (!empty($filter['id_jenis'])) {
            $this->db->where('td.id_jenis', $filter['id_jenis']);
        }

        if (!empty($filter['dibuat_oleh'])) {
            $this->db->where('td.dibuat_oleh', $filter['dibuat_oleh']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('td.nama_template', $filter['pencarian']);
            $this->db->or_like('td.deskripsi', $filter['pencarian']);
            $this->db->or_like('jd.nama_jenis', $filter['pencarian']);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Catat aktivitas terkait template dokumen
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
