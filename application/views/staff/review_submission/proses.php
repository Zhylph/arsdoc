<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Breadcrumb -->
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <?php foreach ($breadcrumb as $label => $url): ?>
            <?php if ($url): ?>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="<?= site_url($url) ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"><?= $label ?></a>
                    </div>
                </li>
            <?php else: ?>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400"><?= $label ?></span>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100"><?= $page_title ?></h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Review dan berikan keputusan untuk submission ini
        </p>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg dark:bg-green-900 dark:border-green-700 dark:text-green-200" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium"><?= $this->session->flashdata('success') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900 dark:border-red-700 dark:text-red-200" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium"><?= $this->session->flashdata('error') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Submission Info Sidebar -->
    <div class="lg:col-span-1">
        <!-- Submission Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Submission</h3>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nomor:</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100 font-mono"><?= $submission['nomor_submission'] ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Template:</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100"><?= $submission['nama_template'] ?></span>
                    </div>
                    <div class="py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block mb-1">Pengguna:</span>
                        <div class="text-sm text-gray-900 dark:text-gray-100 font-medium"><?= $submission['nama_pengguna'] ?></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400"><?= $submission['email_pengguna'] ?></div>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Submit:</span>
                        <span class="text-sm text-gray-900 dark:text-gray-100"><?= date('d/m/Y H:i', strtotime($submission['tanggal_submission'])) ?></span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            Sedang Diproses
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Submission Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Data Submission</h3>
                </div>

                <div class="max-h-96 overflow-y-auto space-y-3">
                    <?php if (!empty($data_submission)): ?>
                        <?php foreach ($data_submission as $data): ?>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <?= ucfirst(str_replace('_', ' ', $data['nama_field'])) ?>
                                </h4>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <?= ucfirst($data['tipe_field']) ?>
                                </span>
                            </div>

                            <?php if ($data['tipe_field'] === 'file'): ?>
                                <?php if (!empty($data['value'])): ?>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-xs text-gray-900 dark:text-gray-100 truncate"><?= $data['value'] ?></span>
                                    </div>
                                    <a href="<?= site_url('staff/review_submission/download_file/' . $submission['id_submission'] . '/' . $data['nama_field']) ?>"
                                       class="inline-flex items-center mt-2 px-2 py-1 bg-blue-600 border border-transparent rounded text-xs text-white hover:bg-blue-700 transition-colors"
                                       target="_blank">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download
                                    </a>
                                <?php else: ?>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 italic">Tidak ada file</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if (!empty($data['value'])): ?>
                                    <div class="bg-white dark:bg-gray-800 rounded p-2 border border-gray-200 dark:border-gray-600">
                                        <p class="text-xs text-gray-900 dark:text-gray-100 whitespace-pre-wrap"><?= htmlspecialchars($data['value']) ?></p>
                                    </div>
                                <?php else: ?>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 italic">Tidak diisi</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tidak ada data submission</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Proses -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Proses Submission</h3>
                </div>

                <?= form_open('staff/review_submission/proses/' . $submission['id_submission'], array('id' => 'formProses')) ?>

                    <!-- Status Decision -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Status Keputusan <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="radio" id="status_disetujui" name="status" value="disetujui" class="sr-only peer" <?= set_radio('status', 'disetujui') ?>>
                                <label for="status_disetujui" class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-green-500 peer-checked:bg-green-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:peer-checked:bg-green-900 dark:peer-checked:border-green-500 transition-all">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Disetujui</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Submission memenuhi persyaratan</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="relative">
                                <input type="radio" id="status_ditolak" name="status" value="ditolak" class="sr-only peer" <?= set_radio('status', 'ditolak') ?>>
                                <label for="status_ditolak" class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:peer-checked:bg-red-900 dark:peer-checked:border-red-500 transition-all">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Ditolak</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Submission tidak memenuhi persyaratan</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <?= form_error('status', '<p class="mt-1 text-sm text-red-600 dark:text-red-400">', '</p>') ?>
                    </div>

                    <!-- Catatan Staff -->
                    <div class="mb-6">
                        <label for="catatan_staff" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan/Komentar <span class="text-red-500">*</span>
                        </label>
                        <textarea name="catatan_staff" id="catatan_staff" rows="6"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="Berikan catatan atau komentar mengenai keputusan Anda..."><?= set_value('catatan_staff') ?></textarea>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Minimal 10 karakter. Catatan ini akan dikirim ke pengguna sebagai feedback.
                        </p>
                        <?= form_error('catatan_staff', '<p class="mt-1 text-sm text-red-600 dark:text-red-400">', '</p>') ?>
                    </div>

                    <!-- Template Catatan -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Template Catatan (Opsional)
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <button type="button" onclick="setTemplate('disetujui')"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-green-100 border border-green-300 rounded-lg text-sm font-medium text-green-700 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-900 dark:border-green-700 dark:text-green-200 dark:hover:bg-green-800 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Template Disetujui
                            </button>

                            <button type="button" onclick="setTemplate('revisi_minor')"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-yellow-100 border border-yellow-300 rounded-lg text-sm font-medium text-yellow-700 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:bg-yellow-900 dark:border-yellow-700 dark:text-yellow-200 dark:hover:bg-yellow-800 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Revisi Minor
                            </button>

                            <button type="button" onclick="setTemplate('ditolak')"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-red-100 border border-red-300 rounded-lg text-sm font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-900 dark:border-red-700 dark:text-red-200 dark:hover:bg-red-800 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Template Ditolak
                            </button>

                            <button type="button" onclick="setTemplate('dokumen_kurang')"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-900 dark:border-blue-700 dark:text-blue-200 dark:hover:bg-blue-800 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Dokumen Kurang
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-3">
                            <button type="submit" id="submitBtn"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Simpan Keputusan
                            </button>

                            <button type="button" onclick="kembalikanSubmission(<?= $submission['id_submission'] ?>)"
                                    class="inline-flex items-center px-6 py-3 bg-yellow-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Kembalikan ke Pending
                            </button>
                        </div>

                        <div class="flex space-x-3">
                            <a href="<?= site_url('staff/review_submission/detail/' . $submission['id_submission']) ?>"
                               class="inline-flex items-center px-6 py-3 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Detail
                            </a>
                        </div>
                    </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
// Template catatan
const templates = {
    'disetujui': 'Submission Anda telah disetujui. Semua dokumen yang diperlukan telah lengkap dan memenuhi persyaratan yang ditetapkan. Terima kasih atas kelengkapan dokumen yang Anda berikan.',
    'ditolak': 'Submission Anda ditolak karena tidak memenuhi persyaratan yang ditetapkan. Silakan periksa kembali dokumen dan persyaratan yang diperlukan, kemudian ajukan kembali submission dengan perbaikan yang diperlukan.',
    'revisi_minor': 'Submission Anda memerlukan revisi minor. Mohon untuk melakukan perbaikan kecil pada dokumen yang telah disubmit sesuai dengan catatan yang diberikan.',
    'dokumen_kurang': 'Submission Anda belum lengkap. Beberapa dokumen yang diperlukan masih belum diupload atau tidak sesuai dengan format yang diminta. Silakan lengkapi dokumen yang kurang.'
};

function setTemplate(type) {
    const textarea = document.getElementById('catatan_staff');
    textarea.value = templates[type];

    // Set radio button sesuai template
    if (type === 'disetujui') {
        document.getElementById('status_disetujui').checked = true;
    } else {
        document.getElementById('status_ditolak').checked = true;
    }

    // Add visual feedback
    textarea.focus();
    textarea.classList.add('ring-2', 'ring-blue-500');
    setTimeout(() => {
        textarea.classList.remove('ring-2', 'ring-blue-500');
    }, 1000);
}

function kembalikanSubmission(idSubmission) {
    if (confirm('Apakah Anda yakin ingin mengembalikan submission ini ke status pending?')) {
        // Show loading
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading...';
        button.disabled = true;

        fetch('<?= site_url('staff/review_submission/kembalikan_submission') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                'id_submission': idSubmission,
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.href = '<?= site_url('staff/review_submission') ?>';
                }, 1000);
            } else {
                showNotification('Error: ' + data.message, 'error');
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        })
        .catch(error => {
            showNotification('Terjadi kesalahan saat memproses permintaan.', 'error');
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }
}

// Validasi form sebelum submit
document.getElementById('formProses').addEventListener('submit', function(e) {
    const status = document.querySelector('input[name="status"]:checked');
    const catatan = document.getElementById('catatan_staff').value.trim();
    const submitBtn = document.getElementById('submitBtn');

    if (!status) {
        e.preventDefault();
        showNotification('Silakan pilih status keputusan (Disetujui atau Ditolak).', 'error');
        return false;
    }

    if (catatan.length < 10) {
        e.preventDefault();
        showNotification('Catatan minimal 10 karakter.', 'error');
        document.getElementById('catatan_staff').focus();
        return false;
    }

    if (!confirm('Apakah Anda yakin dengan keputusan ini? Keputusan tidak dapat diubah setelah disimpan.')) {
        e.preventDefault();
        return false;
    }

    // Show loading state
    const originalContent = submitBtn.innerHTML;
    submitBtn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
    submitBtn.disabled = true;
});

// Function untuk show notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white max-w-sm`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Auto-resize textarea
document.getElementById('catatan_staff').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>
