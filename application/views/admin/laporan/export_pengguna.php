<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="laporan_pengguna_' . date('Y-m-d') . '.xls"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pengguna</title>
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
        <h2>LAPORAN DATA PENGGUNA</h2>
        <p>Sistem Arsip Dokumen</p>
        <p>Tanggal Export: <?= date('d F Y H:i:s') ?></p>
        <?php if (!empty($filter['role'])): ?>
        <p>Filter Role: <?= ucfirst($filter['role']) ?></p>
        <?php endif; ?>
        <?php if (!empty($filter['status'])): ?>
        <p>Filter Status: <?= ucfirst($filter['status']) ?></p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
                <th>Tanggal Update</th>
                <th>Login Terakhir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pengguna)): ?>
                <?php $no = 1; ?>
                <?php foreach ($pengguna as $user): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $user['nama_lengkap'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= ucfirst($user['role']) ?></td>
                    <td><?= ucfirst($user['status']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($user['tanggal_dibuat'])) ?></td>
                    <td><?= $user['tanggal_diupdate'] ? date('d/m/Y H:i', strtotime($user['tanggal_diupdate'])) : '-' ?></td>
                    <td><?= $user['login_terakhir'] ? date('d/m/Y H:i', strtotime($user['login_terakhir'])) : 'Belum pernah login' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data pengguna</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <h3>RINGKASAN</h3>
        <?php
        $total = count($pengguna);
        $admin_count = 0;
        $staff_count = 0;
        $user_count = 0;
        $aktif_count = 0;
        $nonaktif_count = 0;
        
        foreach ($pengguna as $user) {
            if ($user['role'] == 'admin') $admin_count++;
            if ($user['role'] == 'staff') $staff_count++;
            if ($user['role'] == 'user') $user_count++;
            if ($user['status'] == 'aktif') $aktif_count++;
            if ($user['status'] == 'nonaktif') $nonaktif_count++;
        }
        ?>
        <p><strong>Total Pengguna:</strong> <?= $total ?></p>
        <p><strong>Admin:</strong> <?= $admin_count ?> | <strong>Staff:</strong> <?= $staff_count ?> | <strong>User:</strong> <?= $user_count ?></p>
        <p><strong>Aktif:</strong> <?= $aktif_count ?> | <strong>Non-aktif:</strong> <?= $nonaktif_count ?></p>
        <p><strong>Digenerate pada:</strong> <?= date('d F Y H:i:s') ?></p>
        <p><strong>Oleh:</strong> <?= $this->session->userdata('nama_lengkap') ?> (<?= $this->session->userdata('email') ?>)</p>
    </div>
</body>
</html>
