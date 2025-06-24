<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola file pribadi user
 * Menangani operasi CRUD untuk tabel file_pribadi dan folder_pribadi
 */
class Model_file_pribadi extends CI_Model {

    private $tabel_file = 'file_pribadi';
    private $tabel_folder = 'folder_pribadi';

    public function __construct() {
        parent::__construct();
        // Jangan auto-create tabel di constructor untuk menghindari output yang tidak diinginkan
        // $this->_buat_tabel_jika_belum_ada();
    }

    /**
     * Mendapatkan semua file dengan pagination dan filter
     */
    public function ambil_semua_file($filter = array(), $limit = null, $offset = null) {
        $this->db->select('fp.*, ff.nama_folder');
        $this->db->from($this->tabel_file . ' fp');
        $this->db->join($this->tabel_folder . ' ff', 'fp.id_folder = ff.id_folder', 'left');

        // Apply filters
        if (!empty($filter['id_pengguna'])) {
            $this->db->where('fp.id_pengguna', $filter['id_pengguna']);
        }

        if (isset($filter['id_folder'])) {
            if ($filter['id_folder'] === null) {
                $this->db->where('fp.id_folder IS NULL');
            } else {
                $this->db->where('fp.id_folder', $filter['id_folder']);
            }
        }

        if (!empty($filter['tipe_file'])) {
            $this->db->where('fp.tipe_file', $filter['tipe_file']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('fp.nama_file', $filter['pencarian']);
            $this->db->or_like('fp.deskripsi', $filter['pencarian']);
            $this->db->group_end();
        }

        $this->db->order_by('fp.tanggal_upload', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan semua file dengan data user untuk staff
     */
    public function ambil_semua_file_dengan_user($filter = array(), $limit = null, $offset = null) {
        $this->db->select('fp.*, ff.nama_folder, p.nama_lengkap');
        $this->db->from($this->tabel_file . ' fp');
        $this->db->join($this->tabel_folder . ' ff', 'fp.id_folder = ff.id_folder', 'left');
        $this->db->join('pengguna p', 'fp.id_pengguna = p.id_pengguna', 'left');

        // Apply filters
        if (!empty($filter['id_pengguna'])) {
            $this->db->where('fp.id_pengguna', $filter['id_pengguna']);
        }

        if (isset($filter['id_folder'])) {
            if ($filter['id_folder'] === null) {
                $this->db->where('fp.id_folder IS NULL');
            } else {
                $this->db->where('fp.id_folder', $filter['id_folder']);
            }
        }

        if (!empty($filter['tipe_file'])) {
            $this->db->where('fp.tipe_file', $filter['tipe_file']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('fp.nama_file', $filter['pencarian']);
            $this->db->or_like('fp.deskripsi', $filter['pencarian']);
            $this->db->or_like('p.nama_lengkap', $filter['pencarian']);
            $this->db->group_end();
        }

        $this->db->order_by('fp.tanggal_upload', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Menghitung total file dengan filter
     */
    public function hitung_total_file($filter = array()) {
        $this->db->from($this->tabel_file . ' fp');

        // Apply same filters as ambil_semua_file
        if (!empty($filter['id_pengguna'])) {
            $this->db->where('fp.id_pengguna', $filter['id_pengguna']);
        }

        if (isset($filter['id_folder'])) {
            if ($filter['id_folder'] === null) {
                $this->db->where('fp.id_folder IS NULL');
            } else {
                $this->db->where('fp.id_folder', $filter['id_folder']);
            }
        }

        if (!empty($filter['tipe_file'])) {
            $this->db->where('fp.tipe_file', $filter['tipe_file']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('fp.nama_file', $filter['pencarian']);
            $this->db->or_like('fp.deskripsi', $filter['pencarian']);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Menghitung total file dengan filter untuk staff
     */
    public function hitung_total_file_dengan_user($filter = array()) {
        $this->db->from($this->tabel_file . ' fp');
        $this->db->join('pengguna p', 'fp.id_pengguna = p.id_pengguna', 'left');

        // Apply same filters as ambil_semua_file_dengan_user
        if (!empty($filter['id_pengguna'])) {
            $this->db->where('fp.id_pengguna', $filter['id_pengguna']);
        }

        if (isset($filter['id_folder'])) {
            if ($filter['id_folder'] === null) {
                $this->db->where('fp.id_folder IS NULL');
            } else {
                $this->db->where('fp.id_folder', $filter['id_folder']);
            }
        }

        if (!empty($filter['tipe_file'])) {
            $this->db->where('fp.tipe_file', $filter['tipe_file']);
        }

        if (!empty($filter['pencarian'])) {
            $this->db->group_start();
            $this->db->like('fp.nama_file', $filter['pencarian']);
            $this->db->or_like('fp.deskripsi', $filter['pencarian']);
            $this->db->or_like('p.nama_lengkap', $filter['pencarian']);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Mendapatkan file berdasarkan ID
     */
    public function ambil_file_by_id($id_file) {
        $this->db->select('fp.*, ff.nama_folder');
        $this->db->from($this->tabel_file . ' fp');
        $this->db->join($this->tabel_folder . ' ff', 'fp.id_folder = ff.id_folder', 'left');
        $this->db->where('fp.id_file', $id_file);

        $result = $this->db->get()->row_array();
        return $result ? $result : null;
    }

    /**
     * Menambah file baru
     */
    public function tambah_file($data) {
        $data['tanggal_upload'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->tabel_file, $data);
    }

    /**
     * Update file
     */
    public function update_file($id_file, $data) {
        $this->db->where('id_file', $id_file);
        return $this->db->update($this->tabel_file, $data);
    }

    /**
     * Hapus file
     */
    public function hapus_file($id_file) {
        $this->db->where('id_file', $id_file);
        return $this->db->delete($this->tabel_file);
    }

    /**
     * Update counter download
     */
    public function update_counter_download($id_file) {
        $this->db->set('jumlah_download', 'jumlah_download + 1', FALSE);
        $this->db->where('id_file', $id_file);
        return $this->db->update($this->tabel_file);
    }

    /**
     * Mendapatkan folder berdasarkan parent
     */
    public function ambil_folder_by_parent($id_pengguna, $id_parent = null) {
        $this->db->where('id_pengguna', $id_pengguna);

        if ($id_parent === null) {
            $this->db->where('id_parent IS NULL');
        } else {
            $this->db->where('id_parent', $id_parent);
        }

        $this->db->order_by('nama_folder', 'ASC');
        return $this->db->get($this->tabel_folder)->result_array();
    }

    /**
     * Mendapatkan folder berdasarkan ID
     */
    public function ambil_folder_by_id($id_folder) {
        $this->db->where('id_folder', $id_folder);
        $result = $this->db->get($this->tabel_folder)->row_array();
        return $result ? $result : null;
    }

    /**
     * Menambah folder baru
     */
    public function tambah_folder($data) {
        try {
            // Pastikan tabel ada
            if (!$this->db->table_exists($this->tabel_folder)) {
                $this->_buat_tabel_jika_belum_ada();
            }

            $data['tanggal_dibuat'] = date('Y-m-d H:i:s');

            // Validasi data sebelum insert
            if (empty($data['id_pengguna']) || empty($data['nama_folder'])) {
                log_message('error', 'Data folder tidak lengkap: ' . json_encode($data));
                return false;
            }

            return $this->db->insert($this->tabel_folder, $data);
        } catch (Exception $e) {
            log_message('error', 'Error saat menambah folder: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update folder
     */
    public function update_folder($id_folder, $data) {
        $this->db->where('id_folder', $id_folder);
        return $this->db->update($this->tabel_folder, $data);
    }

    /**
     * Hapus folder
     */
    public function hapus_folder($id_folder) {
        $this->db->where('id_folder', $id_folder);
        return $this->db->delete($this->tabel_folder);
    }

    /**
     * Cek apakah nama folder sudah ada
     */
    public function cek_nama_folder_exists($id_pengguna, $nama_folder, $id_parent = null, $exclude_id = null) {
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->where('nama_folder', $nama_folder);

        if ($id_parent === null) {
            $this->db->where('id_parent IS NULL');
        } else {
            $this->db->where('id_parent', $id_parent);
        }

        if ($exclude_id) {
            $this->db->where('id_folder !=', $exclude_id);
        }

        return $this->db->count_all_results($this->tabel_folder) > 0;
    }

    /**
     * Menghitung total folder
     */
    public function hitung_total_folder($filter = array()) {
        if (!empty($filter['id_pengguna'])) {
            $this->db->where('id_pengguna', $filter['id_pengguna']);
        }

        if (isset($filter['id_parent'])) {
            if ($filter['id_parent'] === null) {
                $this->db->where('id_parent IS NULL');
            } else {
                $this->db->where('id_parent', $filter['id_parent']);
            }
        }

        return $this->db->count_all_results($this->tabel_folder);
    }

    /**
     * Mendapatkan breadcrumb folder
     */
    public function ambil_folder_breadcrumb($id_folder) {
        if (!$id_folder) {
            return array();
        }

        $breadcrumb = array();
        $current_folder = $this->ambil_folder_by_id($id_folder);

        while ($current_folder) {
            array_unshift($breadcrumb, $current_folder);

            if ($current_folder['id_parent']) {
                $current_folder = $this->ambil_folder_by_id($current_folder['id_parent']);
            } else {
                break;
            }
        }

        return $breadcrumb;
    }

    /**
     * Mendapatkan statistik file user
     */
    public function ambil_statistik_file($id_pengguna) {
        $statistik = array();

        // Total file
        $this->db->where('id_pengguna', $id_pengguna);
        $statistik['total_file'] = $this->db->count_all_results($this->tabel_file);

        // Total folder
        $this->db->where('id_pengguna', $id_pengguna);
        $statistik['total_folder'] = $this->db->count_all_results($this->tabel_folder);

        // Total ukuran file
        $this->db->select('SUM(ukuran_file) as total_ukuran');
        $this->db->where('id_pengguna', $id_pengguna);
        $result = $this->db->get($this->tabel_file)->row_array();
        $statistik['total_ukuran'] = $result['total_ukuran'] ? $result['total_ukuran'] : 0;

        // Total download
        $this->db->select('SUM(jumlah_download) as total_download');
        $this->db->where('id_pengguna', $id_pengguna);
        $result = $this->db->get($this->tabel_file)->row_array();
        $statistik['total_download'] = $result['total_download'] ? $result['total_download'] : 0;

        // File terbaru
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->order_by('tanggal_upload', 'DESC');
        $this->db->limit(5);
        $statistik['file_terbaru'] = $this->db->get($this->tabel_file)->result_array();

        return $statistik;
    }

    /**
     * Mendapatkan statistik tipe file
     */
    public function ambil_statistik_tipe_file($id_pengguna) {
        $this->db->select('tipe_file, COUNT(*) as jumlah, SUM(ukuran_file) as total_ukuran');
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->group_by('tipe_file');
        $this->db->order_by('jumlah', 'DESC');

        return $this->db->get($this->tabel_file)->result_array();
    }

    /**
     * Buat tabel jika belum ada
     */
    private function _buat_tabel_jika_belum_ada() {
        try {
            // Tabel folder_pribadi
            if (!$this->db->table_exists($this->tabel_folder)) {
                // Cek apakah tabel pengguna ada terlebih dahulu
                if (!$this->db->table_exists('pengguna')) {
                    log_message('error', 'Tabel pengguna tidak ditemukan. Tidak dapat membuat tabel folder_pribadi.');
                    return false;
                }

                $sql = "
                    CREATE TABLE `{$this->tabel_folder}` (
                        `id_folder` int(11) NOT NULL AUTO_INCREMENT,
                        `id_pengguna` int(11) NOT NULL,
                        `id_parent` int(11) DEFAULT NULL,
                        `nama_folder` varchar(255) NOT NULL,
                        `deskripsi` text,
                        `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id_folder`),
                        KEY `id_pengguna` (`id_pengguna`),
                        KEY `id_parent` (`id_parent`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ";

                if (!$this->db->query($sql)) {
                    log_message('error', 'Gagal membuat tabel folder_pribadi: ' . $this->db->error()['message']);
                    return false;
                }

                // Tambahkan foreign key constraints setelah tabel dibuat
                $fk_sql = array(
                    "ALTER TABLE `{$this->tabel_folder}` ADD CONSTRAINT `fk_folder_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE",
                    "ALTER TABLE `{$this->tabel_folder}` ADD CONSTRAINT `fk_folder_parent` FOREIGN KEY (`id_parent`) REFERENCES `{$this->tabel_folder}` (`id_folder`) ON DELETE CASCADE"
                );

                foreach ($fk_sql as $sql) {
                    if (!$this->db->query($sql)) {
                        log_message('error', 'Gagal menambah foreign key constraint: ' . $this->db->error()['message']);
                        // Lanjutkan tanpa foreign key jika gagal
                    }
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Exception saat membuat tabel folder_pribadi: ' . $e->getMessage());
            return false;
        }


        // Tabel file_pribadi
        try {
            if (!$this->db->table_exists($this->tabel_file)) {
                $sql = "
                    CREATE TABLE `{$this->tabel_file}` (
                        `id_file` int(11) NOT NULL AUTO_INCREMENT,
                        `id_pengguna` int(11) NOT NULL,
                        `id_folder` int(11) DEFAULT NULL,
                        `nama_file` varchar(255) NOT NULL,
                        `nama_file_sistem` varchar(255) NOT NULL,
                        `ukuran_file` int(11) NOT NULL DEFAULT 0,
                        `tipe_file` varchar(10) NOT NULL,
                        `deskripsi` text,
                        `jumlah_download` int(11) NOT NULL DEFAULT 0,
                        `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id_file`),
                        KEY `id_pengguna` (`id_pengguna`),
                        KEY `id_folder` (`id_folder`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ";

                if (!$this->db->query($sql)) {
                    log_message('error', 'Gagal membuat tabel file_pribadi: ' . $this->db->error()['message']);
                    return false;
                }

                // Tambahkan foreign key constraints setelah tabel dibuat
                $fk_sql = array(
                    "ALTER TABLE `{$this->tabel_file}` ADD CONSTRAINT `fk_file_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE",
                    "ALTER TABLE `{$this->tabel_file}` ADD CONSTRAINT `fk_file_folder` FOREIGN KEY (`id_folder`) REFERENCES `{$this->tabel_folder}` (`id_folder`) ON DELETE SET NULL"
                );

                foreach ($fk_sql as $sql) {
                    if (!$this->db->query($sql)) {
                        log_message('error', 'Gagal menambah foreign key constraint untuk file_pribadi: ' . $this->db->error()['message']);
                        // Lanjutkan tanpa foreign key jika gagal
                    }
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Exception saat membuat tabel file_pribadi: ' . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Buat tabel manual untuk debugging
     */
    public function buat_tabel_manual() {
        try {
            // Buat tabel folder_pribadi tanpa foreign key dulu
            $sql = "
                CREATE TABLE IF NOT EXISTS `{$this->tabel_folder}` (
                    `id_folder` int(11) NOT NULL AUTO_INCREMENT,
                    `id_pengguna` int(11) NOT NULL,
                    `id_parent` int(11) DEFAULT NULL,
                    `nama_folder` varchar(255) NOT NULL,
                    `deskripsi` text,
                    `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id_folder`),
                    KEY `id_pengguna` (`id_pengguna`),
                    KEY `id_parent` (`id_parent`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ";

            if (!$this->db->query($sql)) {
                log_message('error', 'Gagal membuat tabel folder_pribadi manual: ' . $this->db->error()['message']);
                return false;
            }

            return true;
        } catch (Exception $e) {
            log_message('error', 'Exception saat membuat tabel manual: ' . $e->getMessage());
            return false;
        }
    }
}
