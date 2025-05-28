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
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success_message')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><?php echo $this->session->flashdata('success_message'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error_message')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><?php echo $this->session->flashdata('error_message'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6">
            <form method="GET" action="<?php echo site_url('user/dokumen'); ?>" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <div class="flex-1">
                    <label for="pencarian" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cari Template Dokumen
                    </label>
                    <input type="text" 
                           id="pencarian" 
                           name="pencarian" 
                           value="<?php echo $filter['pencarian']; ?>"
                           placeholder="Masukkan nama template atau deskripsi..."
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                </div>
                
                <div class="w-full md:w-48">
                    <label for="id_jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jenis Dokumen
                    </label>
                    <select id="id_jenis" 
                            name="id_jenis"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Semua Jenis</option>
                        <?php foreach ($jenis_dokumen as $jenis): ?>
                            <option value="<?php echo $jenis['id_jenis']; ?>" <?php echo ($filter['id_jenis'] == $jenis['id_jenis']) ? 'selected' : ''; ?>>
                                <?php echo $jenis['nama_jenis']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                    <a href="<?php echo site_url('user/dokumen'); ?>" 
                       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    <div class="flex items-center justify-between mb-6">
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Menampilkan <?php echo count($templates); ?> dari <?php echo $total_rows; ?> template dokumen
        </div>
        <div class="flex items-center space-x-2">
            <a href="<?php echo site_url('user/dokumen/submission'); ?>" 
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Submission Saya
            </a>
        </div>
    </div>

    <!-- Templates Grid -->
    <?php if (!empty($templates)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($templates as $template): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    <?php echo $template['nama_template']; ?>
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <?php echo $template['nama_jenis']; ?>
                                </span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo ($template['status'] === 'aktif') ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'; ?>">
                                <?php echo ucfirst($template['status']); ?>
                            </span>
                        </div>
                        
                        <?php if ($template['deskripsi']): ?>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                <?php echo $template['deskripsi']; ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span><?php echo $template['jumlah_field']; ?> field</span>
                            <span><?php echo $template['jumlah_submission']; ?> submission</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="<?php echo site_url('user/dokumen/detail/' . $template['id_template']); ?>" 
                               class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg text-center transition-colors duration-200">
                                Lihat Detail
                            </a>
                            <a href="<?php echo site_url('user/submission/buat/' . $template['id_template']); ?>" 
                               class="flex-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg text-center transition-colors duration-200">
                                Submit Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pagination): ?>
            <div class="mt-8 flex justify-center">
                <?php echo $pagination; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Tidak ada template dokumen</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                <?php if (!empty($filter['pencarian']) || !empty($filter['id_jenis'])): ?>
                    Tidak ditemukan template dokumen yang sesuai dengan kriteria pencarian.
                <?php else: ?>
                    Belum ada template dokumen yang tersedia saat ini.
                <?php endif; ?>
            </p>
            <?php if (!empty($filter['pencarian']) || !empty($filter['id_jenis'])): ?>
                <div class="mt-6">
                    <a href="<?php echo site_url('user/dokumen'); ?>" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Lihat Semua Template
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
