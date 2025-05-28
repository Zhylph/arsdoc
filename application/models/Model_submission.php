<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola data submission dokumen
 * Menangani operasi CRUD untuk tabel submission_dokumen dan data_submission
 */
class Model_submission extends CI_Model {

    private $tabel_submission = 'submission_dokumen';
    private $tabel_data = 'data_submission';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mendapatkan semua data submission dengan pagination dan filter
     */
    public function ambil_semua_submission($filter = array(), $limit = null, $offset = null) {
        $this->db->select('sd.*, td.nama_template, jd.nama_jenis, p.nama_lengkap as nama_pengguna, ps.nama_lengkap as nama_staff');
        $this->db->from($this->tabel_submission . ' sd');
        $this->db->join('template_dokumen td', 'sd.id_template = td.id_template', 'left');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis', 'left');
        $this->db->join('pengguna p', 'sd.id_pengguna = p.id_pengguna', 'left');
        $this->db->join('pengguna ps', 'sd.diproses_oleh = ps.id_pengguna', 'left');

        // Apply filters
        if (!empty($filter['status'])) {
            $this->db->where('sd.status', $filter['status']);
        }

        if (!empty($filter['id_template'])) {
            $this->db->where('sd.id_template', $filter['id_template']);
        }

        if (!empty($filter['id_pengguna'])) {
            $this->db->where('sd.id_pengguna', $filter['id_pengguna']);
        }

        if (!empty($filter['diproses_oleh'])) {
            $this->db->where('sd.diproses_oleh', $filter['diproses_oleh']);
        }

        if (!empty($filter['tanggal_dari'])) {
            $this->db->where('DATE(sd.tanggal_submission) >=', $filter['tanggal_dari']);
        }

        if (!empty($filter['tanggal_sampai'])) {
            $this->db->where('DATE(sd.tanggal_submission) <=', $filter['tanggal_sampai']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('sd.nomor_submission', $filter['pencarian']);
            $this->db->or_like('td.nama_template', $filter['pencarian']);
            $this->db->or_like('p.nama_lengkap', $filter['pencarian']);
            $this->db->group_end();
        }

        $this->db->order_by('sd.tanggal_submission', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Menghitung total submission dengan filter
     */
    public function hitung_total_submission($filter = array()) {
        $this->db->from($this->tabel_submission . ' sd');
        $this->db->join('template_dokumen td', 'sd.id_template = td.id_template', 'left');
        $this->db->join('pengguna p', 'sd.id_pengguna = p.id_pengguna', 'left');

        // Apply same filters as ambil_semua_submission
        if (!empty($filter['status'])) {
            $this->db->where('sd.status', $filter['status']);
        }

        if (!empty($filter['id_template'])) {
            $this->db->where('sd.id_template', $filter['id_template']);
        }

        if (!empty($filter['id_pengguna'])) {
            $this->db->where('sd.id_pengguna', $filter['id_pengguna']);
        }

        if (!empty($filter['diproses_oleh'])) {
            $this->db->where('sd.diproses_oleh', $filter['diproses_oleh']);
        }

        if (!empty($filter['tanggal_dari'])) {
            $this->db->where('DATE(sd.tanggal_submission) >=', $filter['tanggal_dari']);
        }

        if (!empty($filter['tanggal_sampai'])) {
            $this->db->where('DATE(sd.tanggal_submission) <=', $filter['tanggal_sampai']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('sd.nomor_submission', $filter['pencarian']);
            $this->db->or_like('td.nama_template', $filter['pencarian']);
            $this->db->or_like('p.nama_lengkap', $filter['pencarian']);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Menghitung submission berdasarkan status
     */
    public function hitung_submission_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results($this->tabel_submission);
    }

    /**
     * Mendapatkan data submission berdasarkan ID
     */
    public function ambil_submission_by_id($id_submission) {
        $this->db->select('sd.*, td.nama_template, td.deskripsi as deskripsi_template, td.instruksi_upload, jd.nama_jenis, p.nama_lengkap as nama_pengguna, p.email as email_pengguna, ps.nama_lengkap as nama_staff');
        $this->db->from($this->tabel_submission . ' sd');
        $this->db->join('template_dokumen td', 'sd.id_template = td.id_template', 'left');
        $this->db->join('jenis_dokumen jd', 'td.id_jenis = jd.id_jenis', 'left');
        $this->db->join('pengguna p', 'sd.id_pengguna = p.id_pengguna', 'left');
        $this->db->join('pengguna ps', 'sd.diproses_oleh = ps.id_pengguna', 'left');
        $this->db->where('sd.id_submission', $id_submission);

        $result = $this->db->get()->row_array();
        return $result ? $result : null;
    }

    /**
     * Mendapatkan data submission berdasarkan nomor submission
     */
    public function ambil_submission_by_nomor($nomor_submission) {
        $this->db->where('nomor_submission', $nomor_submission);
        $result = $this->db->get($this->tabel_submission)->row_array();
        return $result ? $result : null;
    }

    /**
     * Menambah submission baru
     */
    public function tambah_submission($data_submission, $data_field = array()) {
        $this->db->trans_start();

        // Insert submission
        $this->db->insert($this->tabel_submission, $data_submission);
        $id_submission = $this->db->insert_id();

        // Insert data field jika ada
        if (!empty($data_field) && $id_submission) {
            foreach ($data_field as $field) {
                $field['id_submission'] = $id_submission;
                $this->db->insert($this->tabel_data, $field);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $id_submission;
    }

    /**
     * Mengupdate data submission
     */
    public function update_submission($id_submission, $data_submission, $data_field = array()) {
        $this->db->trans_start();

        // Update submission
        $this->db->where('id_submission', $id_submission);
        $this->db->update($this->tabel_submission, $data_submission);

        // Update data field jika ada
        if (!empty($data_field)) {
            // Hapus data field lama
            $this->db->where('id_submission', $id_submission);
            $this->db->delete($this->tabel_data);

            // Insert data field baru
            foreach ($data_field as $field) {
                $field['id_submission'] = $id_submission;
                $this->db->insert($this->tabel_data, $field);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Menghapus submission
     */
    public function hapus_submission($id_submission) {
        $this->db->trans_start();

        // Hapus data field terlebih dahulu
        $this->db->where('id_submission', $id_submission);
        $this->db->delete($this->tabel_data);

        // Hapus submission
        $this->db->where('id_submission', $id_submission);
        $this->db->delete($this->tabel_submission);

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Mendapatkan data field submission
     */
    public function ambil_data_submission($id_submission) {
        $this->db->select('ds.*, fd.nama_field, fd.tipe_field, fd.label_field, fd.required');
        $this->db->from($this->tabel_data . ' ds');
        $this->db->join('field_dokumen fd', 'ds.id_field = fd.id_field', 'left');
        $this->db->where('ds.id_submission', $id_submission);
        $this->db->order_by('fd.urutan', 'ASC');

        return $this->db->get()->result_array();
    }

    /**
     * Generate nomor submission unik
     */
    public function generate_nomor_submission() {
        $prefix = 'SUB';
        $tahun = date('Y');
        $bulan = date('m');

        // Cari nomor terakhir bulan ini
        $this->db->select('nomor_submission');
        $this->db->like('nomor_submission', $prefix . $tahun . $bulan, 'after');
        $this->db->order_by('nomor_submission', 'DESC');
        $this->db->limit(1);

        $result = $this->db->get($this->tabel_submission)->row_array();

        if ($result) {
            // Ambil 4 digit terakhir dan tambah 1
            $last_number = (int)substr($result['nomor_submission'], -4);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }

        return $prefix . $tahun . $bulan . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Mendapatkan submission terbaru
     */
    public function ambil_submission_terbaru($limit = 5) {
        $this->db->select('sd.*, td.nama_template, p.nama_lengkap as nama_pengguna');
        $this->db->from($this->tabel_submission . ' sd');
        $this->db->join('template_dokumen td', 'sd.id_template = td.id_template', 'left');
        $this->db->join('pengguna p', 'sd.id_pengguna = p.id_pengguna', 'left');
        $this->db->order_by('sd.tanggal_submission', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan statistik submission bulanan
     */
    public function ambil_statistik_bulanan($tahun = null) {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $this->db->select("MONTH(tanggal_submission) as bulan, COUNT(*) as jumlah");
        $this->db->where('YEAR(tanggal_submission)', $tahun);
        $this->db->group_by('MONTH(tanggal_submission)');
        $this->db->order_by('bulan', 'ASC');

        $result = $this->db->get($this->tabel_submission)->result_array();

        // Format data untuk chart
        $data = array_fill(1, 12, 0); // Inisialisasi 12 bulan dengan 0

        foreach ($result as $row) {
            $data[(int)$row['bulan']] = (int)$row['jumlah'];
        }

        return array_values($data); // Return sebagai array numerik
    }

    /**
     * Mendapatkan statistik submission berdasarkan template
     */
    public function ambil_statistik_by_template($limit = 10) {
        $this->db->select('td.nama_template, COUNT(sd.id_submission) as jumlah_submission');
        $this->db->from($this->tabel_submission . ' sd');
        $this->db->join('template_dokumen td', 'sd.id_template = td.id_template', 'left');
        $this->db->group_by('sd.id_template');
        $this->db->order_by('jumlah_submission', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

    /**
     * Menghitung submission berdasarkan status
     */
    public function hitung_submission_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results($this->tabel_submission);
    }
}
