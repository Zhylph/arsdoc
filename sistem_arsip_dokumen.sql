/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100130 (10.1.30-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : sistem_arsip_dokumen

 Target Server Type    : MySQL
 Target Server Version : 100130 (10.1.30-MariaDB)
 File Encoding         : 65001

 Date: 02/06/2025 04:22:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for data_submission
-- ----------------------------
DROP TABLE IF EXISTS `data_submission`;
CREATE TABLE `data_submission`  (
  `id_data` int NOT NULL AUTO_INCREMENT,
  `id_submission` int NOT NULL,
  `id_field` int NOT NULL,
  `nilai_field` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `nama_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `path_file` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran_file` int NULL DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_data`) USING BTREE,
  INDEX `id_submission`(`id_submission` ASC) USING BTREE,
  INDEX `id_field`(`id_field` ASC) USING BTREE,
  CONSTRAINT `data_submission_ibfk_1` FOREIGN KEY (`id_submission`) REFERENCES `submission_dokumen` (`id_submission`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `data_submission_ibfk_2` FOREIGN KEY (`id_field`) REFERENCES `field_dokumen` (`id_field`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of data_submission
-- ----------------------------

-- ----------------------------
-- Table structure for field_dokumen
-- ----------------------------
DROP TABLE IF EXISTS `field_dokumen`;
CREATE TABLE `field_dokumen`  (
  `id_field` int NOT NULL AUTO_INCREMENT,
  `id_template` int NOT NULL,
  `nama_field` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipe_field` enum('text','textarea','file','date','number','select','radio','checkbox') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `wajib_diisi` enum('ya','tidak','1','0') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'tidak',
  `urutan` int NULL DEFAULT 0,
  `placeholder` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `opsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `validasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_field`) USING BTREE,
  INDEX `id_template`(`id_template` ASC) USING BTREE,
  CONSTRAINT `field_dokumen_ibfk_1` FOREIGN KEY (`id_template`) REFERENCES `template_dokumen` (`id_template`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of field_dokumen
-- ----------------------------
INSERT INTO `field_dokumen` VALUES (4, 2, 'SKP', 'file', 'ya', 1, '', NULL, NULL, '2025-05-29 06:41:09');
INSERT INTO `field_dokumen` VALUES (5, 2, 'EKIN', 'file', 'ya', 2, '', NULL, NULL, '2025-05-29 06:41:09');
INSERT INTO `field_dokumen` VALUES (6, 1, 'SKP', 'file', 'tidak', 1, '', NULL, NULL, '2025-05-29 06:50:52');
INSERT INTO `field_dokumen` VALUES (7, 1, 'EKIN', 'file', 'tidak', 2, '', NULL, NULL, '2025-05-29 06:50:52');

-- ----------------------------
-- Table structure for file_pribadi
-- ----------------------------
DROP TABLE IF EXISTS `file_pribadi`;
CREATE TABLE `file_pribadi`  (
  `id_file` int NOT NULL AUTO_INCREMENT,
  `id_pengguna` int NOT NULL,
  `id_folder` int NULL DEFAULT NULL,
  `nama_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_file_sistem` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ukuran_file` int NOT NULL DEFAULT 0,
  `tipe_file` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `jumlah_download` int NOT NULL DEFAULT 0,
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_file`) USING BTREE,
  INDEX `idx_file_pribadi_pengguna`(`id_pengguna` ASC) USING BTREE,
  INDEX `idx_file_pribadi_folder`(`id_folder` ASC) USING BTREE,
  INDEX `idx_file_pribadi_tanggal`(`tanggal_upload` ASC) USING BTREE,
  CONSTRAINT `file_pribadi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `file_pribadi_ibfk_2` FOREIGN KEY (`id_folder`) REFERENCES `folder_pribadi` (`id_folder`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of file_pribadi
-- ----------------------------
INSERT INTO `file_pribadi` VALUES (1, 3, NULL, 'Februari.pdf', 'eed7e471822de3ac72beb218860df60d.pdf', 203, '.pdf', '', 10, '2025-05-28 15:56:57');
INSERT INTO `file_pribadi` VALUES (3, 3, NULL, 'SKP_Triwulan_I_R__Rajif_Handoko.pdf', 'a090ab4dbdd1f8baea7e5ab0bb31ccbe.pdf', 842, '.pdf', '', 14, '2025-05-28 23:50:39');

-- ----------------------------
-- Table structure for folder_pribadi
-- ----------------------------
DROP TABLE IF EXISTS `folder_pribadi`;
CREATE TABLE `folder_pribadi`  (
  `id_folder` int NOT NULL AUTO_INCREMENT,
  `id_pengguna` int NOT NULL,
  `id_parent` int NULL DEFAULT NULL,
  `nama_folder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_folder`) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  INDEX `id_parent`(`id_parent` ASC) USING BTREE,
  CONSTRAINT `folder_pribadi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `folder_pribadi_ibfk_2` FOREIGN KEY (`id_parent`) REFERENCES `folder_pribadi` (`id_folder`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of folder_pribadi
-- ----------------------------
INSERT INTO `folder_pribadi` VALUES (12, 3, NULL, 'z', '', '2025-05-28 23:54:42');
INSERT INTO `folder_pribadi` VALUES (13, 3, 12, 'z', '', '2025-05-28 23:55:03');

-- ----------------------------
-- Table structure for jenis_dokumen
-- ----------------------------
DROP TABLE IF EXISTS `jenis_dokumen`;
CREATE TABLE `jenis_dokumen`  (
  `id_jenis` int NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `status` enum('aktif','nonaktif') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'aktif',
  `dibuat_oleh` int NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_diperbarui` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_jenis`) USING BTREE,
  INDEX `dibuat_oleh`(`dibuat_oleh` ASC) USING BTREE,
  CONSTRAINT `jenis_dokumen_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jenis_dokumen
-- ----------------------------
INSERT INTO `jenis_dokumen` VALUES (1, 'Dokumen Kepegawaian', 'Dokumen yang berkaitan dengan kepegawaian seperti kenaikan pangkat, mutasi, dll', 'aktif', 2, '2025-05-28 15:28:32', '2025-05-28 15:28:32');
INSERT INTO `jenis_dokumen` VALUES (2, 'Dokumen Akademik', 'Dokumen yang berkaitan dengan akademik seperti ijazah, transkrip, sertifikat', 'aktif', 2, '2025-05-28 15:28:32', '2025-05-28 15:28:32');
INSERT INTO `jenis_dokumen` VALUES (3, 'Dokumen Keuangan', 'Dokumen yang berkaitan dengan keuangan seperti slip gaji, SPT, dll', 'aktif', 2, '2025-05-28 15:28:32', '2025-05-28 15:28:32');

-- ----------------------------
-- Table structure for log_aktivitas
-- ----------------------------
DROP TABLE IF EXISTS `log_aktivitas`;
CREATE TABLE `log_aktivitas`  (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_pengguna` int NOT NULL,
  `aktivitas` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `ip_address` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `tanggal_aktivitas` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 130 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of log_aktivitas
-- ----------------------------
INSERT INTO `log_aktivitas` VALUES (1, 1, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:29:46');
INSERT INTO `log_aktivitas` VALUES (2, 1, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:34:35');
INSERT INTO `log_aktivitas` VALUES (3, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:34:48');
INSERT INTO `log_aktivitas` VALUES (4, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:38:29');
INSERT INTO `log_aktivitas` VALUES (5, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:38:35');
INSERT INTO `log_aktivitas` VALUES (6, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:51:16');
INSERT INTO `log_aktivitas` VALUES (7, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:51:18');
INSERT INTO `log_aktivitas` VALUES (8, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:57:35');
INSERT INTO `log_aktivitas` VALUES (9, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:57:39');
INSERT INTO `log_aktivitas` VALUES (10, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:29:09');
INSERT INTO `log_aktivitas` VALUES (11, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:29:23');
INSERT INTO `log_aktivitas` VALUES (12, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:29:35');
INSERT INTO `log_aktivitas` VALUES (13, 1, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:29:42');
INSERT INTO `log_aktivitas` VALUES (14, 1, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:48:21');
INSERT INTO `log_aktivitas` VALUES (15, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:48:22');
INSERT INTO `log_aktivitas` VALUES (16, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:48:31');
INSERT INTO `log_aktivitas` VALUES (17, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:48:34');
INSERT INTO `log_aktivitas` VALUES (18, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:48:43');
INSERT INTO `log_aktivitas` VALUES (19, 1, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:48:46');
INSERT INTO `log_aktivitas` VALUES (20, 1, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:32:50');
INSERT INTO `log_aktivitas` VALUES (21, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:32:53');
INSERT INTO `log_aktivitas` VALUES (22, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:33:01');
INSERT INTO `log_aktivitas` VALUES (23, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:33:03');
INSERT INTO `log_aktivitas` VALUES (24, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:45:10');
INSERT INTO `log_aktivitas` VALUES (25, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:45:14');
INSERT INTO `log_aktivitas` VALUES (26, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:45:49');
INSERT INTO `log_aktivitas` VALUES (27, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 18:45:52');
INSERT INTO `log_aktivitas` VALUES (28, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 19:24:47');
INSERT INTO `log_aktivitas` VALUES (29, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 21:56:49');
INSERT INTO `log_aktivitas` VALUES (30, 3, 'Upload file pribadi', 'Upload file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 15:56:57');
INSERT INTO `log_aktivitas` VALUES (31, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:00:57');
INSERT INTO `log_aktivitas` VALUES (32, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:01:02');
INSERT INTO `log_aktivitas` VALUES (33, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:22:38');
INSERT INTO `log_aktivitas` VALUES (34, 3, 'Membuat folder pribadi', 'Membuat folder: Tes', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:22:44');
INSERT INTO `log_aktivitas` VALUES (35, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:35:46');
INSERT INTO `log_aktivitas` VALUES (36, 3, 'Upload file pribadi', 'Upload file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:35:54');
INSERT INTO `log_aktivitas` VALUES (37, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:36:11');
INSERT INTO `log_aktivitas` VALUES (38, 3, 'Membuat folder pribadi', 'Membuat folder: ZZ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:36:18');
INSERT INTO `log_aktivitas` VALUES (39, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:37:10');
INSERT INTO `log_aktivitas` VALUES (40, 3, 'Membuat folder pribadi', 'Membuat folder: Heyooo', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:37:22');
INSERT INTO `log_aktivitas` VALUES (41, 3, 'Membuat folder pribadi', 'Membuat folder: SKP', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:37:33');
INSERT INTO `log_aktivitas` VALUES (42, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:46:33');
INSERT INTO `log_aktivitas` VALUES (43, 3, 'Membuat folder pribadi', 'Membuat folder: we', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:46:38');
INSERT INTO `log_aktivitas` VALUES (44, 3, 'Membuat folder pribadi', 'Membuat folder: Wes', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 16:46:57');
INSERT INTO `log_aktivitas` VALUES (45, 1, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 22:47:13');
INSERT INTO `log_aktivitas` VALUES (46, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 05:49:55');
INSERT INTO `log_aktivitas` VALUES (47, 3, 'Menghapus folder pribadi', 'Menghapus folder: Heyooo', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:00');
INSERT INTO `log_aktivitas` VALUES (48, 3, 'Menghapus folder pribadi', 'Menghapus folder: SKP', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:03');
INSERT INTO `log_aktivitas` VALUES (49, 3, 'Menghapus file pribadi', 'Menghapus file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:15');
INSERT INTO `log_aktivitas` VALUES (50, 3, 'Menghapus folder pribadi', 'Menghapus folder: Test Simple 1748443602892', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:21');
INSERT INTO `log_aktivitas` VALUES (51, 3, 'Menghapus folder pribadi', 'Menghapus folder: Test Simple 1748443608342', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:24');
INSERT INTO `log_aktivitas` VALUES (52, 3, 'Menghapus folder pribadi', 'Menghapus folder: we', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:27');
INSERT INTO `log_aktivitas` VALUES (53, 3, 'Menghapus folder pribadi', 'Menghapus folder: Wes', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:30');
INSERT INTO `log_aktivitas` VALUES (54, 3, 'Menghapus folder pribadi', 'Menghapus folder: ZZ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:32');
INSERT INTO `log_aktivitas` VALUES (55, 3, 'Upload file pribadi', 'Upload file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:39');
INSERT INTO `log_aktivitas` VALUES (56, 3, 'Membuat folder pribadi', 'Membuat folder: zzzzzzzzzzzzzzzz', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:50:46');
INSERT INTO `log_aktivitas` VALUES (57, 3, 'Membuat folder pribadi', 'Membuat folder: z', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:54:42');
INSERT INTO `log_aktivitas` VALUES (58, 3, 'Membuat folder pribadi', 'Membuat folder: z', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 23:55:03');
INSERT INTO `log_aktivitas` VALUES (59, 3, 'Membuat folder pribadi', 'Membuat folder: Heyooo', '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1 Edg/136.0.0.0', '2025-05-29 00:03:13');
INSERT INTO `log_aktivitas` VALUES (60, 3, 'Membuat folder pribadi', 'Membuat folder: SKP', '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1 Edg/136.0.0.0', '2025-05-29 00:04:29');
INSERT INTO `log_aktivitas` VALUES (61, 3, 'Menghapus folder pribadi', 'Menghapus folder: Heyooo', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:05:10');
INSERT INTO `log_aktivitas` VALUES (62, 3, 'Menghapus folder pribadi', 'Menghapus folder: SKP', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:05:12');
INSERT INTO `log_aktivitas` VALUES (63, 3, 'Menghapus folder pribadi', 'Menghapus folder: Tes', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:05:14');
INSERT INTO `log_aktivitas` VALUES (64, 3, 'Menghapus folder pribadi', 'Menghapus folder: Test No Log 1748469756261', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:05:16');
INSERT INTO `log_aktivitas` VALUES (65, 3, 'Menghapus folder pribadi', 'Menghapus folder: Test No Log 1748469758117', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:05:18');
INSERT INTO `log_aktivitas` VALUES (66, 3, 'Menghapus folder pribadi', 'Menghapus folder: Test Simple 1748469760329', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:05:19');
INSERT INTO `log_aktivitas` VALUES (67, 3, 'Menghapus folder pribadi', 'Menghapus folder: zzzzzzzzzzzzzzzz', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:05:27');
INSERT INTO `log_aktivitas` VALUES (68, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:51');
INSERT INTO `log_aktivitas` VALUES (69, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:51');
INSERT INTO `log_aktivitas` VALUES (70, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:51');
INSERT INTO `log_aktivitas` VALUES (71, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:51');
INSERT INTO `log_aktivitas` VALUES (72, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:51');
INSERT INTO `log_aktivitas` VALUES (73, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:55');
INSERT INTO `log_aktivitas` VALUES (74, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:55');
INSERT INTO `log_aktivitas` VALUES (75, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:55');
INSERT INTO `log_aktivitas` VALUES (76, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:55');
INSERT INTO `log_aktivitas` VALUES (77, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:55');
INSERT INTO `log_aktivitas` VALUES (78, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:55');
INSERT INTO `log_aktivitas` VALUES (79, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:07:55');
INSERT INTO `log_aktivitas` VALUES (80, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:27');
INSERT INTO `log_aktivitas` VALUES (81, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:27');
INSERT INTO `log_aktivitas` VALUES (82, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:28');
INSERT INTO `log_aktivitas` VALUES (83, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:28');
INSERT INTO `log_aktivitas` VALUES (84, 3, 'Download file pribadi', 'Download file: Februari.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:28');
INSERT INTO `log_aktivitas` VALUES (85, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:31');
INSERT INTO `log_aktivitas` VALUES (86, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:31');
INSERT INTO `log_aktivitas` VALUES (87, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:31');
INSERT INTO `log_aktivitas` VALUES (88, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:31');
INSERT INTO `log_aktivitas` VALUES (89, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:31');
INSERT INTO `log_aktivitas` VALUES (90, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:31');
INSERT INTO `log_aktivitas` VALUES (91, 3, 'Download file pribadi', 'Download file: SKP_Triwulan_I_R__Rajif_Handoko.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:08:32');
INSERT INTO `log_aktivitas` VALUES (92, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:09:03');
INSERT INTO `log_aktivitas` VALUES (93, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:09:05');
INSERT INTO `log_aktivitas` VALUES (94, 2, 'Mengupdate template dokumen', 'Template: Pengajuan Kenaikan Pangkat', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:24:48');
INSERT INTO `log_aktivitas` VALUES (95, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:25:22');
INSERT INTO `log_aktivitas` VALUES (96, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:25:25');
INSERT INTO `log_aktivitas` VALUES (97, 3, 'Membuat submission baru', 'Membuat submission SUB2025050001 untuk template Pengajuan Kenaikan Pangkat', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:25:36');
INSERT INTO `log_aktivitas` VALUES (98, 3, 'Menghapus submission', 'Menghapus submission SUB2025050001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 00:25:44');
INSERT INTO `log_aktivitas` VALUES (99, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:34:07');
INSERT INTO `log_aktivitas` VALUES (100, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:34:10');
INSERT INTO `log_aktivitas` VALUES (101, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:35:14');
INSERT INTO `log_aktivitas` VALUES (102, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:35:17');
INSERT INTO `log_aktivitas` VALUES (103, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:38:48');
INSERT INTO `log_aktivitas` VALUES (104, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:38:50');
INSERT INTO `log_aktivitas` VALUES (105, 2, 'Mengupdate template dokumen', 'Template: Pengajuan Kenaikan Pangkat', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:39:16');
INSERT INTO `log_aktivitas` VALUES (106, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:39:22');
INSERT INTO `log_aktivitas` VALUES (107, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:39:25');
INSERT INTO `log_aktivitas` VALUES (108, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:39:59');
INSERT INTO `log_aktivitas` VALUES (109, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:40:01');
INSERT INTO `log_aktivitas` VALUES (110, 2, 'Mengupdate template dokumen', 'Template: Legalisir Ijazah', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:41:09');
INSERT INTO `log_aktivitas` VALUES (111, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:41:14');
INSERT INTO `log_aktivitas` VALUES (112, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:41:17');
INSERT INTO `log_aktivitas` VALUES (113, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:50:35');
INSERT INTO `log_aktivitas` VALUES (114, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:50:38');
INSERT INTO `log_aktivitas` VALUES (115, 2, 'Mengupdate template dokumen', 'Template: Pengajuan Kenaikan Pangkat', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:50:52');
INSERT INTO `log_aktivitas` VALUES (116, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:50:56');
INSERT INTO `log_aktivitas` VALUES (117, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-29 06:50:59');
INSERT INTO `log_aktivitas` VALUES (118, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 02:58:09');
INSERT INTO `log_aktivitas` VALUES (119, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 02:58:22');
INSERT INTO `log_aktivitas` VALUES (120, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:02:18');
INSERT INTO `log_aktivitas` VALUES (121, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:02:31');
INSERT INTO `log_aktivitas` VALUES (122, 1, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:02:34');
INSERT INTO `log_aktivitas` VALUES (123, 1, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:02:45');
INSERT INTO `log_aktivitas` VALUES (124, 2, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:02:49');
INSERT INTO `log_aktivitas` VALUES (125, 2, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:05:18');
INSERT INTO `log_aktivitas` VALUES (126, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:05:22');
INSERT INTO `log_aktivitas` VALUES (127, 3, 'Logout dari sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:17:45');
INSERT INTO `log_aktivitas` VALUES (128, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:17:47');
INSERT INTO `log_aktivitas` VALUES (129, 3, 'Login ke sistem', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-06-02 03:47:05');

-- ----------------------------
-- Table structure for pengaturan_sistem
-- ----------------------------
DROP TABLE IF EXISTS `pengaturan_sistem`;
CREATE TABLE `pengaturan_sistem`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `default_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tipe` enum('text','number','email','url','textarea','select','checkbox','file') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'text',
  `options` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'JSON untuk select options',
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `urutan` int NOT NULL DEFAULT 0,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_diperbarui` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`key` ASC) USING BTREE,
  INDEX `kategori`(`kategori` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pengaturan_sistem
-- ----------------------------
INSERT INTO `pengaturan_sistem` VALUES (1, 'site_name', 'Sistem Arsip Dokumen', 'Sistem Arsip Dokumen', 'umum', 'Nama Situs', 'Nama aplikasi yang akan ditampilkan di header dan title', 'text', NULL, 1, 1, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (2, 'site_description', 'Sistem Pengarsipan Dokumen Digital', 'Sistem Pengarsipan Dokumen Digital', 'umum', 'Deskripsi Situs', 'Deskripsi singkat tentang aplikasi', 'textarea', NULL, 0, 2, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (3, 'admin_email', 'admin@arsdoc.com', 'admin@arsdoc.com', 'umum', 'Email Administrator', 'Email administrator untuk notifikasi sistem', 'email', NULL, 1, 3, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (4, 'timezone', 'Asia/Jakarta', 'Asia/Jakarta', 'umum', 'Zona Waktu', 'Zona waktu yang digunakan sistem', 'select', '{\"Asia/Jakarta\":\"WIB (Jakarta)\",\"Asia/Makassar\":\"WITA (Makassar)\",\"Asia/Jayapura\":\"WIT (Jayapura)\"}', 1, 4, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (5, 'max_upload_size', '10', '10', 'upload', 'Ukuran Maksimal Upload (MB)', 'Ukuran maksimal file yang dapat diupload dalam MB', 'number', NULL, 1, 1, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (6, 'allowed_file_types', 'pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif', 'pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif', 'upload', 'Tipe File yang Diizinkan', 'Ekstensi file yang diizinkan untuk upload (pisahkan dengan koma)', 'text', NULL, 1, 2, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (7, 'auto_delete_temp_files', '1', '1', 'upload', 'Hapus File Temporary Otomatis', 'Hapus file temporary yang lebih dari 24 jam secara otomatis', 'checkbox', NULL, 0, 3, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (8, 'session_timeout', '3600', '3600', 'keamanan', 'Timeout Session (detik)', 'Waktu timeout session dalam detik (3600 = 1 jam)', 'number', NULL, 1, 1, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (9, 'max_login_attempts', '5', '5', 'keamanan', 'Maksimal Percobaan Login', 'Jumlah maksimal percobaan login yang gagal sebelum akun dikunci', 'number', NULL, 1, 2, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (10, 'lockout_duration', '900', '900', 'keamanan', 'Durasi Lockout (detik)', 'Durasi penguncian akun dalam detik (900 = 15 menit)', 'number', NULL, 1, 3, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (11, 'force_https', '0', '0', 'keamanan', 'Paksa HTTPS', 'Paksa penggunaan HTTPS untuk semua halaman', 'checkbox', NULL, 0, 4, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (12, 'email_protocol', 'smtp', 'smtp', 'email', 'Protokol Email', 'Protokol yang digunakan untuk mengirim email', 'select', '{\"mail\":\"PHP Mail\",\"smtp\":\"SMTP\",\"sendmail\":\"Sendmail\"}', 1, 1, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (13, 'email_smtp_host', 'smtp.gmail.com', 'smtp.gmail.com', 'email', 'SMTP Host', 'Host server SMTP', 'text', NULL, 0, 2, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (14, 'email_smtp_port', '587', '587', 'email', 'SMTP Port', 'Port server SMTP', 'number', NULL, 0, 3, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (15, 'email_smtp_user', '', '', 'email', 'SMTP Username', 'Username untuk autentikasi SMTP', 'text', NULL, 0, 4, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (16, 'email_smtp_pass', '', '', 'email', 'SMTP Password', 'Password untuk autentikasi SMTP', 'text', NULL, 0, 5, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (17, 'pagination_limit', '10', '10', 'tampilan', 'Jumlah Data per Halaman', 'Jumlah data yang ditampilkan per halaman pada tabel', 'number', NULL, 1, 1, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (18, 'date_format', 'd/m/Y', 'd/m/Y', 'tampilan', 'Format Tanggal', 'Format tampilan tanggal di seluruh sistem', 'select', '{\"d/m/Y\":\"DD/MM/YYYY\",\"Y-m-d\":\"YYYY-MM-DD\",\"d-m-Y\":\"DD-MM-YYYY\",\"m/d/Y\":\"MM/DD/YYYY\"}', 1, 2, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (19, 'show_breadcrumb', '1', '1', 'tampilan', 'Tampilkan Breadcrumb', 'Tampilkan navigasi breadcrumb di setiap halaman', 'checkbox', NULL, 0, 3, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (20, 'auto_backup', '0', '0', 'backup', 'Backup Otomatis', 'Aktifkan backup database otomatis', 'checkbox', NULL, 0, 1, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (21, 'backup_frequency', 'weekly', 'weekly', 'backup', 'Frekuensi Backup', 'Frekuensi backup otomatis', 'select', '{\"daily\":\"Harian\",\"weekly\":\"Mingguan\",\"monthly\":\"Bulanan\"}', 0, 2, '2025-05-28 16:29:46', '2025-05-28 16:29:46');
INSERT INTO `pengaturan_sistem` VALUES (22, 'backup_retention_days', '30', '30', 'backup', 'Retensi Backup (hari)', 'Jumlah hari backup disimpan sebelum dihapus otomatis', 'number', NULL, 0, 3, '2025-05-28 16:29:46', '2025-05-28 16:29:46');

-- ----------------------------
-- Table structure for pengguna
-- ----------------------------
DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna`  (
  `id_pengguna` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role` enum('admin','staff','user') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user',
  `status` enum('aktif','nonaktif') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'aktif',
  `foto_profil` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_diperbarui` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengguna`) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pengguna
-- ----------------------------
INSERT INTO `pengguna` VALUES (1, 'Administrator', 'admin@arsdoc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'aktif', NULL, '2025-05-28 15:28:32', '2025-05-28 15:28:32');
INSERT INTO `pengguna` VALUES (2, 'Staff Arsip', 'staff@arsdoc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 'aktif', NULL, '2025-05-28 15:28:32', '2025-05-28 15:28:32');
INSERT INTO `pengguna` VALUES (3, 'User Demo', 'user@arsdoc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'aktif', NULL, '2025-05-28 15:28:32', '2025-05-28 15:28:32');

-- ----------------------------
-- Table structure for submission_dokumen
-- ----------------------------
DROP TABLE IF EXISTS `submission_dokumen`;
CREATE TABLE `submission_dokumen`  (
  `id_submission` int NOT NULL AUTO_INCREMENT,
  `id_template` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `nomor_submission` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('pending','diproses','disetujui','ditolak') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'pending',
  `catatan_staff` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `diproses_oleh` int NULL DEFAULT NULL,
  `tanggal_submission` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_diproses` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_submission`) USING BTREE,
  UNIQUE INDEX `nomor_submission`(`nomor_submission` ASC) USING BTREE,
  INDEX `id_template`(`id_template` ASC) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  INDEX `diproses_oleh`(`diproses_oleh` ASC) USING BTREE,
  CONSTRAINT `submission_dokumen_ibfk_1` FOREIGN KEY (`id_template`) REFERENCES `template_dokumen` (`id_template`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `submission_dokumen_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `submission_dokumen_ibfk_3` FOREIGN KEY (`diproses_oleh`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of submission_dokumen
-- ----------------------------

-- ----------------------------
-- Table structure for template_dokumen
-- ----------------------------
DROP TABLE IF EXISTS `template_dokumen`;
CREATE TABLE `template_dokumen`  (
  `id_template` int NOT NULL AUTO_INCREMENT,
  `id_jenis` int NOT NULL,
  `nama_template` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `instruksi_upload` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `max_ukuran_file` int NULL DEFAULT 10485760,
  `tipe_file_diizinkan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'pdf,doc,docx,jpg,jpeg,png',
  `status` enum('aktif','nonaktif') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'aktif',
  `dibuat_oleh` int NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_diperbarui` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_template`) USING BTREE,
  INDEX `id_jenis`(`id_jenis` ASC) USING BTREE,
  INDEX `dibuat_oleh`(`dibuat_oleh` ASC) USING BTREE,
  CONSTRAINT `template_dokumen_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_dokumen` (`id_jenis`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `template_dokumen_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of template_dokumen
-- ----------------------------
INSERT INTO `template_dokumen` VALUES (1, 1, 'Pengajuan Kenaikan Pangkat', 'Template untuk pengajuan kenaikan pangkat pegawai', 'Silakan upload dokumen pendukung yang diperlukan untuk pengajuan kenaikan pangkat', 10485760, 'pdf,doc,docx,jpg,jpeg,png', 'aktif', 2, '2025-05-28 15:28:32', '2025-06-02 03:23:55');
INSERT INTO `template_dokumen` VALUES (2, 2, 'Legalisir Ijazah', 'Template untuk permohonan legalisir ijazah', 'Upload scan ijazah asli yang akan dilegalisir', 10485760, 'pdf,doc,docx,jpg,jpeg,png', 'aktif', 2, '2025-05-28 15:28:32', '2025-06-02 03:23:55');
INSERT INTO `template_dokumen` VALUES (3, 3, 'Pengajuan Reimbursement', 'Template untuk pengajuan penggantian biaya', 'Upload bukti pembayaran dan dokumen pendukung lainnya', 10485760, 'pdf,doc,docx,jpg,jpeg,png', 'aktif', 2, '2025-05-28 15:28:32', '2025-05-28 15:28:32');

SET FOREIGN_KEY_CHECKS = 1;
