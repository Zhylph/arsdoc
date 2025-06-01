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
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><?php echo $this->session->flashdata('success'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><?php echo $this->session->flashdata('error'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Template Info -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        <?php echo $template['nama_template']; ?>
                    </h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        <?php echo $template['nama_jenis']; ?>
                    </span>
                </div>
            </div>

            <?php if ($template['deskripsi']): ?>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <?php echo $template['deskripsi']; ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if (!empty($template['instruksi_upload'])): ?>
                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Instruksi Upload</h3>
                            <p class="mt-1 text-sm text-blue-700 dark:text-blue-300"><?php echo $template['instruksi_upload']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Submission Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Form Submission Dokumen</h3>

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('error')): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>
                    <span class="font-medium">Error:</span>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>
                    <span class="font-medium">Sukses:</span>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if (validation_errors()): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>
                    <span class="font-medium">Terjadi kesalahan validasi:</span>
                    <?php echo validation_errors(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Debug: Form action URL -->
            <?php
            $form_action = site_url('user/submission/buat/' . $template['id_template']);
            echo '<!-- Form action: ' . $form_action . ' -->';
            ?>
            <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data" class="space-y-6" id="submission-form">

                <?php if (!empty($field_template)): ?>
                    <?php foreach ($field_template as $field): ?>
                        <div class="form-group">
                            <label for="<?php echo $field['nama_field']; ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <?php echo ucfirst(str_replace('_', ' ', $field['nama_field'])); ?>
                                <?php if ($field['wajib_diisi']): ?>
                                    <span class="text-red-500">*</span>
                                <?php endif; ?>
                            </label>

                            <?php if (!empty($field['placeholder'])): ?>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2"><?php echo $field['placeholder']; ?></p>
                            <?php endif; ?>

                            <?php
                            $field_attributes = array(
                                'id' => $field['nama_field'],
                                'name' => $field['nama_field'],
                                'class' => 'w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100',
                                'value' => set_value($field['nama_field'])
                            );

                            if ($field['wajib_diisi']) {
                                $field_attributes['required'] = 'required';
                            }
                            ?>

                            <?php switch ($field['tipe_field']):
                                case 'text': ?>
                                    <?php echo form_input($field_attributes); ?>
                                    <?php break; ?>

                                <?php case 'textarea': ?>
                                    <?php
                                    $field_attributes['rows'] = '4';
                                    echo form_textarea($field_attributes);
                                    ?>
                                    <?php break; ?>

                                <?php case 'email': ?>
                                    <?php
                                    $field_attributes['type'] = 'email';
                                    echo form_input($field_attributes);
                                    ?>
                                    <?php break; ?>

                                <?php case 'number': ?>
                                    <?php
                                    $field_attributes['type'] = 'number';
                                    echo form_input($field_attributes);
                                    ?>
                                    <?php break; ?>

                                <?php case 'date': ?>
                                    <?php
                                    $field_attributes['type'] = 'date';
                                    echo form_input($field_attributes);
                                    ?>
                                    <?php break; ?>

                                <?php case 'file': ?>
                                    <?php
                                    $field_attributes['type'] = 'file';
                                    $field_attributes['class'] = 'w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100';
                                    unset($field_attributes['value']);
                                    echo form_upload($field_attributes);
                                    ?>
                                    <?php if (isset($template['tipe_file_diizinkan']) && $template['tipe_file_diizinkan']): ?>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            Tipe file yang diizinkan: <?php echo $template['tipe_file_diizinkan']; ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if (isset($template['max_ukuran_file']) && $template['max_ukuran_file']): ?>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            Ukuran maksimal: <?php echo round($template['max_ukuran_file'] / 1024 / 1024, 1); ?> MB
                                        </p>
                                    <?php endif; ?>
                                    <?php break; ?>

                                <?php case 'select': ?>
                                    <?php if (!empty($field['opsi_pilihan'])): ?>
                                        <?php
                                        $options = array('' => 'Pilih ' . ucfirst(str_replace('_', ' ', $field['nama_field'])));
                                        $opsi_array = explode(',', $field['opsi_pilihan']);
                                        foreach ($opsi_array as $opsi) {
                                            $opsi = trim($opsi);
                                            $options[$opsi] = $opsi;
                                        }
                                        echo form_dropdown($field['nama_field'], $options, set_value($field['nama_field']), $field_attributes);
                                        ?>
                                    <?php endif; ?>
                                    <?php break; ?>

                                <?php default: ?>
                                    <?php echo form_input($field_attributes); ?>
                            <?php endswitch; ?>

                            <?php echo form_error($field['nama_field'], '<p class="mt-1 text-sm text-red-600">', '</p>'); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">Template ini belum memiliki field yang dikonfigurasi.</p>
                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo site_url('user/dokumen/detail/' . $template['id_template']); ?>"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                        Kembali
                    </a>

                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Submission
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// File upload preview and validation
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    const form = document.getElementById('submission-form');

    // Debug form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission started');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            console.log('Form enctype:', this.enctype);

            // Check file uploads
            const fileInputs = this.querySelectorAll('input[type="file"]');
            fileInputs.forEach(function(input) {
                if (input.files.length > 0) {
                    console.log('File selected for ' + input.name + ':', input.files[0].name);
                } else {
                    console.log('No file selected for ' + input.name);
                }
            });

            // Don't prevent default - let form submit normally
        });
    }

    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Show file name
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB

                // Create or update file info display
                let fileInfo = this.parentNode.querySelector('.file-info');
                if (!fileInfo) {
                    fileInfo = document.createElement('div');
                    fileInfo.className = 'file-info mt-2 text-sm text-gray-600 dark:text-gray-400';
                    this.parentNode.appendChild(fileInfo);
                }

                fileInfo.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>${fileName} (${fileSize} MB)</span>
                    </div>
                `;
            }
        });
    });
});
</script>
