<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100"><?php echo $page_title; ?></h1>
                    <nav class="flex mt-2" aria-label="Breadcrumb">
                        <?php foreach ($breadcrumb as $label => $url): ?>
                            <?php if ($url): ?>
                                <a href="<?php echo site_url($url); ?>" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                    <?php echo $label; ?>
                                </a>
                                <span class="mx-2 text-gray-400">/</span>
                            <?php else: ?>
                                <span class="text-sm text-gray-900 dark:text-gray-100"><?php echo $label; ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                </div>
                <div class="flex space-x-3">
                    <a href="<?php echo site_url('user/dokumen'); ?>" 
                       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    <a href="<?php echo site_url('user/submission/buat/' . $template['id_template']); ?>" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Submit Dokumen
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Template Information -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                <?php echo $template['nama_template']; ?>
                            </h2>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <?php echo $template['nama_jenis']; ?>
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo ($template['status'] === 'aktif') ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'; ?>">
                                    <?php echo ucfirst($template['status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if ($template['deskripsi']): ?>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Deskripsi</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                <?php echo nl2br($template['deskripsi']); ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if ($template['instruksi_upload']): ?>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Instruksi Upload</h3>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <p class="text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                                    <?php echo nl2br($template['instruksi_upload']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- File Requirements -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Persyaratan File</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tipe File</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <?php echo strtoupper(str_replace(',', ', ', $template['tipe_file_diizinkan'])); ?>
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M13 13h4a2 2 0 012 2v4a2 2 0 01-2 2h-4m-6-4a2 2 0 01-2-2V9a2 2 0 012-2h2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran Maksimal</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <?php echo $template['max_ukuran_file']; ?> MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Required Fields -->
                    <?php if (!empty($field_template)): ?>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Field yang Diperlukan</h3>
                            <div class="space-y-3">
                                <?php foreach ($field_template as $field): ?>
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 mr-3">
                                                <?php
                                                $icon_class = '';
                                                switch ($field['tipe_field']) {
                                                    case 'text':
                                                        $icon_class = 'M4 6h16M4 12h16M4 18h7';
                                                        break;
                                                    case 'textarea':
                                                        $icon_class = 'M4 6h16M4 12h16M4 18h16';
                                                        break;
                                                    case 'file':
                                                        $icon_class = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                                        break;
                                                    case 'date':
                                                        $icon_class = 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z';
                                                        break;
                                                    case 'number':
                                                        $icon_class = 'M7 20l4-16m2 16l4-16M6 9h14M4 15h14';
                                                        break;
                                                    default:
                                                        $icon_class = 'M4 6h16M4 12h16M4 18h7';
                                                }
                                                ?>
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $icon_class; ?>"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    <?php echo $field['nama_field']; ?>
                                                    <?php if ($field['wajib_diisi']): ?>
                                                        <span class="text-red-500">*</span>
                                                    <?php endif; ?>
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    <?php echo ucfirst($field['tipe_field']); ?>
                                                    <?php if ($field['placeholder']): ?>
                                                        - <?php echo $field['placeholder']; ?>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php if ($field['wajib_diisi']): ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Wajib
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                                Opsional
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Template Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Template</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Dibuat oleh</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                <?php echo $template['dibuat_oleh_nama']; ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tanggal dibuat</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                <?php echo date('d/m/Y', strtotime($template['tanggal_dibuat'])); ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Jumlah field</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                <?php echo count($field_template); ?> field
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Submissions -->
            <?php if (!empty($submission_user)): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Submission Saya</h3>
                        <div class="space-y-3">
                            <?php foreach ($submission_user as $submission): ?>
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            <?php echo $submission['nomor_submission']; ?>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <?php echo date('d/m/Y H:i', strtotime($submission['tanggal_submission'])); ?>
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            <?php 
                                            switch ($submission['status']) {
                                                case 'pending':
                                                    echo 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                                    break;
                                                case 'diproses':
                                                    echo 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                                    break;
                                                case 'disetujui':
                                                    echo 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                                    break;
                                                case 'ditolak':
                                                    echo 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                                    break;
                                                default:
                                                    echo 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200';
                                            }
                                            ?>">
                                            <?php echo ucfirst($submission['status']); ?>
                                        </span>
                                        <a href="<?php echo site_url('user/dokumen/detail_submission/' . $submission['id_submission']); ?>" 
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo site_url('user/dokumen/submission'); ?>" 
                               class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Lihat semua submission →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
