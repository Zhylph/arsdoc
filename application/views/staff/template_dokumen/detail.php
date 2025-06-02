<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Content Header -->
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <div class="mb-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <?php foreach ($breadcrumb as $label => $url): ?>
                        <?php if ($url): ?>
                            <li class="inline-flex items-center">
                                <a href="<?php echo site_url($url); ?>" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                                    <?php echo $label; ?>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="inline-flex items-center text-gray-500 dark:text-gray-400" aria-current="page">
                                <?php echo $label; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>

            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"><?php echo $page_title; ?></h1>
                <div class="flex space-x-2">
                    <a href="<?php echo site_url('staff/template_dokumen/edit/' . $template['id_template']); ?>"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:ring-4 focus:ring-blue-300 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-600 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                        Edit
                    </a>
                    <a href="<?php echo site_url('staff/template_dokumen'); ?>"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success_message')): ?>
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <?php echo $this->session->flashdata('success_message'); ?>
</div>
<?php endif; ?>

<!-- Template Information -->
<div class="p-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white"><?php echo $template['nama_template']; ?></h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php echo $template['status'] === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'; ?>">
                            <?php echo ucfirst($template['status']); ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Jenis Dokumen</h3>
                            <p class="text-sm text-gray-900 dark:text-white"><?php echo $template['nama_jenis']; ?></p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Dibuat Oleh</h3>
                            <p class="text-sm text-gray-900 dark:text-white"><?php echo $template['dibuat_oleh_nama']; ?></p>
                            <p class="text-xs text-gray-500"><?php echo date('d/m/Y H:i', strtotime($template['tanggal_dibuat'])); ?></p>
                        </div>
                    </div>

                    <?php if ($template['deskripsi']): ?>
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Deskripsi</h3>
                        <p class="text-sm text-gray-900 dark:text-white"><?php echo nl2br($template['deskripsi']); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if ($template['instruksi_upload']): ?>
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Instruksi Upload</h3>
                        <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                            <p class="text-sm text-blue-800 dark:text-blue-300"><?php echo nl2br($template['instruksi_upload']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">

            <!-- File Settings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pengaturan File</h3>

                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Maksimal Ukuran</h4>
                            <p class="text-sm text-gray-900 dark:text-white"><?php echo round($template['max_ukuran_file'] / 1024 / 1024, 1); ?> MB</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Tipe File Diizinkan</h4>
                            <div class="flex flex-wrap gap-1">
                                <?php
                                $allowed_types = explode(',', $template['tipe_file_diizinkan']);
                                foreach ($allowed_types as $type):
                                    if (trim($type)):
                                ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    <?php echo strtoupper(trim($type)); ?>
                                </span>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Statistik</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Field</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white"><?php echo count($fields); ?></span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Submission</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white"><?php echo count($submission_terbaru); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Fields -->
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Field Dinamis</h3>

                <?php if (!empty($fields)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Urutan</th>
                                <th scope="col" class="px-4 py-3">Nama Field</th>
                                <th scope="col" class="px-4 py-3">Tipe</th>
                                <th scope="col" class="px-4 py-3">Wajib</th>
                                <th scope="col" class="px-4 py-3">Placeholder</th>
                                <th scope="col" class="px-4 py-3">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fields as $field): ?>
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white"><?php echo $field['urutan']; ?></td>
                                <td class="px-4 py-3"><?php echo $field['nama_field']; ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        <?php echo ucfirst($field['tipe_field']); ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                        <?php echo $field['wajib_diisi'] === 'ya' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'; ?>">
                                        <?php echo $field['wajib_diisi'] === 'ya' ? 'Ya' : 'Tidak'; ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <?php echo $field['placeholder'] ? ((strlen($field['placeholder']) > 30) ? substr($field['placeholder'], 0, 30) . '...' : $field['placeholder']) : '-'; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if (in_array($field['tipe_field'], ['select', 'radio', 'checkbox']) && isset($field['opsi']) && $field['opsi']): ?>
                                        <div class="text-xs text-gray-500">
                                            <?php
                                            $options = explode(',', $field['opsi']);
                                            echo count($options) . ' opsi';
                                            ?>
                                        </div>
                                    <?php elseif (in_array($field['tipe_field'], ['select', 'radio', 'checkbox'])): ?>
                                        <div class="text-xs text-gray-500">Belum dikonfigurasi</div>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada field dinamis</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Template ini belum memiliki field dinamis.</p>
                    <div class="mt-6">
                        <a href="<?php echo site_url('staff/template_dokumen/edit/' . $template['id_template']); ?>"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            Tambah Field
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <?php if (!empty($submission_terbaru)): ?>
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Submission Terbaru</h3>
                    <a href="<?php echo site_url('staff/submission?template=' . $template['id_template']); ?>"
                       class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Pengguna</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">Tanggal Submit</th>
                                <th scope="col" class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submission_terbaru as $submission): ?>
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    <?php echo $submission['nama_lengkap']; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?php
                                        switch($submission['status']) {
                                            case 'pending': echo 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'; break;
                                            case 'disetujui': echo 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'; break;
                                            case 'ditolak': echo 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'; break;
                                            default: echo 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        }
                                        ?>">
                                        <?php echo ucfirst($submission['status']); ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <?php echo date('d/m/Y H:i', strtotime($submission['tanggal_submission'])); ?>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="<?php echo site_url('staff/submission/detail/' . $submission['id_submission']); ?>"
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
