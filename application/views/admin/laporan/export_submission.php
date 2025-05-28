<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="laporan_submission_' . date('Y-m-d') . '.xls"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Submission Dokumen</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN SUBMISSION DOKUMEN</h2>
        <p>Sistem Arsip Dokumen</p>
        <p>Tanggal Export: <?= date('d F Y H:i:s') ?></p>
        <?php if (!empty($filter['tanggal_dari']) || !empty($filter['tanggal_sampai'])): ?>
        <p>
            Periode: 
            <?= !empty($filter['tanggal_dari']) ? date('d F Y', strtotime($filter['tanggal_dari'])) : 'Awal' ?>
            s/d 
            <?= !empty($filter['tanggal_sampai']) ? date('d F Y', strtotime($filter['tanggal_sampai'])) : 'Sekarang' ?>
        </p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Submission</th>
                <th>Template</th>
                <th>Jenis Dokumen</th>
                <th>Pengguna</th>
                <th>Email Pengguna</th>
                <th>Status</th>
                <th>Tanggal Submission</th>
                <th>Diproses Oleh</th>
                <th>Tanggal Diproses</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($submission)): ?>
                <?php $no = 1; ?>
                <?php foreach ($submission as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $item['nomor_submission'] ?></td>
                    <td><?= $item['nama_template'] ?></td>
                    <td><?= $item['nama_jenis'] ?></td>
                    <td><?= $item['nama_pengguna'] ?></td>
                    <td><?= $item['email'] ?? '-' ?></td>
                    <td><?= ucfirst($item['status']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($item['tanggal_submission'])) ?></td>
                    <td><?= $item['nama_staff'] ?? '-' ?></td>
                    <td><?= $item['tanggal_diproses'] ? date('d/m/Y H:i', strtotime($item['tanggal_diproses'])) : '-' ?></td>
                    <td><?= $item['catatan'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" style="text-align: center;">Tidak ada data submission</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Total Data:</strong> <?= count($submission) ?> submission</p>
        <p><strong>Digenerate pada:</strong> <?= date('d F Y H:i:s') ?></p>
        <p><strong>Oleh:</strong> <?= $this->session->userdata('nama_lengkap') ?> (<?= $this->session->userdata('email') ?>)</p>
    </div>
</body>
</html>
