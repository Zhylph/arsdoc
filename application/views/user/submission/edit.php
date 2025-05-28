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

    <!-- Submission Info -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Submission: <?php echo $submission['nomor_submission']; ?>
                    </h2>
                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <span>Status:
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <?php echo ucfirst($submission['status']); ?>
                            </span>
                        </span>
                        <span>Tanggal: <?php echo date('d/m/Y H:i', strtotime($submission['tanggal_submission'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Edit Submission</h3>

            <?php echo form_open_multipart('user/submission/edit/' . $submission['id_submission'], array('class' => 'space-y-6')); ?>

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
                            // Get current value from submission data
                            $current_value = isset($submission_values[$field['nama_field']]) ? $submission_values[$field['nama_field']] : '';

                            $field_attributes = array(
                                'id' => $field['nama_field'],
                                'name' => $field['nama_field'],
                                'class' => 'w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100',
                                'value' => set_value($field['nama_field'], $current_value)
                            );

                            if ($field['wajib_diisi'] && $field['tipe_field'] !== 'file') {
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
                                    <?php if ($current_value): ?>
                                        <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">File saat ini: <?php echo $current_value; ?></span>
                                                </div>
                                                <a href="<?php echo site_url('user/dokumen/download_file/' . $submission['id_submission'] . '/' . $field['nama_field']); ?>"
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    $field_attributes['type'] = 'file';
                                    $field_attributes['class'] = 'w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100';
                                    unset($field_attributes['value']);
                                    echo form_upload($field_attributes);
                                    ?>

                                    <?php if ($current_value): ?>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            Kosongkan jika tidak ingin mengubah file
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
                                        echo form_dropdown($field['nama_field'], $options, set_value($field['nama_field'], $current_value), $field_attributes);
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
                    <a href="<?php echo site_url('user/dokumen/detail_submission/' . $submission['id_submission']); ?>"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                        Kembali
                    </a>

                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Update Submission
                    </button>
                </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
// File upload preview and validation
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');

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
                        <span>File baru: ${fileName} (${fileSize} MB)</span>
                    </div>
                `;
            }
        });
    });
});
</script>
