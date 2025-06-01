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

            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"><?php echo $page_title; ?></h1>
        </div>
    </div>
</div>

<!-- Form -->
<div class="p-4">
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg">
        <form method="POST" action="<?php echo site_url('staff/template_dokumen/tambah'); ?>" class="p-6">

            <!-- Template Information -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Template</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_jenis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Jenis Dokumen <span class="text-red-500">*</span>
                        </label>
                        <select id="id_jenis" name="id_jenis" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Pilih Jenis Dokumen</option>
                            <?php foreach ($jenis_dokumen as $jenis): ?>
                                <option value="<?php echo $jenis['id_jenis']; ?>" <?php echo set_select('id_jenis', $jenis['id_jenis'], $selected_jenis == $jenis['id_jenis']); ?>>
                                    <?php echo $jenis['nama_jenis']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('id_jenis', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">', '</p>'); ?>
                    </div>

                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="aktif" <?php echo set_select('status', 'aktif', TRUE); ?>>Aktif</option>
                            <option value="nonaktif" <?php echo set_select('status', 'nonaktif'); ?>>Nonaktif</option>
                        </select>
                        <?php echo form_error('status', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">', '</p>'); ?>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="nama_template" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nama Template <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_template" name="nama_template" value="<?php echo set_value('nama_template'); ?>" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Masukkan nama template">
                    <?php echo form_error('nama_template', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">', '</p>'); ?>
                </div>

                <div class="mt-6">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="Deskripsi template (opsional)"><?php echo set_value('deskripsi'); ?></textarea>
                    <?php echo form_error('deskripsi', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">', '</p>'); ?>
                </div>

                <div class="mt-6">
                    <label for="instruksi_upload" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instruksi Upload</label>
                    <textarea id="instruksi_upload" name="instruksi_upload" rows="4"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="Instruksi untuk pengguna saat mengupload dokumen"><?php echo set_value('instruksi_upload'); ?></textarea>
                    <?php echo form_error('instruksi_upload', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">', '</p>'); ?>
                </div>
            </div>

            <!-- File Settings -->
            <div class="mb-8 border-t border-gray-200 dark:border-gray-600 pt-8">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pengaturan File</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="max_ukuran_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Maksimal Ukuran File (MB) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="max_ukuran_file" name="max_ukuran_file" value="<?php echo set_value('max_ukuran_file', '5'); ?>"
                               min="1" max="10" step="0.1" required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php echo form_error('max_ukuran_file', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">', '</p>'); ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe File yang Diizinkan</label>
                        <div class="grid grid-cols-2 gap-2">
                            <?php
                            $file_types = array('pdf' => 'PDF', 'doc' => 'DOC', 'docx' => 'DOCX', 'jpg' => 'JPG', 'jpeg' => 'JPEG', 'png' => 'PNG');
                            foreach ($file_types as $ext => $label):
                            ?>
                            <div class="flex items-center">
                                <input id="file_<?php echo $ext; ?>" type="checkbox" name="tipe_file_diizinkan[]" value="<?php echo $ext; ?>"
                                       <?php echo set_checkbox('tipe_file_diizinkan[]', $ext, in_array($ext, array('pdf', 'doc', 'docx'))); ?>
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="file_<?php echo $ext; ?>" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $label; ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Fields -->
            <div class="mb-8 border-t border-gray-200 dark:border-gray-600 pt-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Field Dinamis</h3>
                    <button type="button" id="add-field"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:ring-4 focus:ring-blue-300 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-600 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Tambah Field
                    </button>
                </div>

                <div id="fields-container">
                    <!-- Dynamic fields will be added here -->
                </div>

                <div id="no-fields" class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2">Belum ada field dinamis. Klik "Tambah Field" untuk menambahkan field.</p>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                <a href="<?php echo site_url('staff/template_dokumen'); ?>"
                   class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Simpan Template
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let fieldCounter = 0;

document.getElementById('add-field').addEventListener('click', function() {
    addField();
});

function addField(data = {}) {
    fieldCounter++;
    const container = document.getElementById('fields-container');
    const noFields = document.getElementById('no-fields');

    const fieldHtml = `
        <div class="field-item border border-gray-200 dark:border-gray-600 rounded-lg p-4 mb-4" data-field="${fieldCounter}">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-md font-medium text-gray-900 dark:text-white">Field #${fieldCounter}</h4>
                <button type="button" onclick="removeField(${fieldCounter})"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Field</label>
                    <input type="text" name="fields[${fieldCounter}][nama_field]" value="${data.nama_field || ''}" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Nama field">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe Field</label>
                    <select name="fields[${fieldCounter}][tipe_field]" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="text" ${data.tipe_field === 'text' ? 'selected' : ''}>Text</option>
                        <option value="textarea" ${data.tipe_field === 'textarea' ? 'selected' : ''}>Textarea</option>
                        <option value="number" ${data.tipe_field === 'number' ? 'selected' : ''}>Number</option>
                        <option value="date" ${data.tipe_field === 'date' ? 'selected' : ''}>Date</option>
                        <option value="file" ${data.tipe_field === 'file' ? 'selected' : ''}>File</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wajib Diisi</label>
                    <select name="fields[${fieldCounter}][wajib_diisi]"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="ya" ${data.wajib_diisi === 'ya' ? 'selected' : ''}>Ya</option>
                        <option value="tidak" ${data.wajib_diisi === 'tidak' ? 'selected' : ''}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Placeholder/Keterangan</label>
                <input type="text" name="fields[${fieldCounter}][placeholder]" value="${data.placeholder || ''}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Placeholder atau keterangan field">
            </div>

            <!-- Options field temporarily disabled - not supported in current database schema -->
            <!--
            <div class="field-options-${fieldCounter} mt-4" style="display: ${['select', 'radio', 'checkbox'].includes(data.tipe_field) ? 'block' : 'none'};">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Opsi (pisahkan dengan koma)</label>
                <textarea name="fields[${fieldCounter}][opsi]" rows="2"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                          placeholder="Opsi 1, Opsi 2, Opsi 3">${data.opsi || ''}</textarea>
            </div>
            -->

            <input type="hidden" name="fields[${fieldCounter}][urutan]" value="${fieldCounter}">
        </div>
    `;

    container.insertAdjacentHTML('beforeend', fieldHtml);
    noFields.style.display = 'none';
}

function removeField(fieldId) {
    const fieldElement = document.querySelector(`[data-field="${fieldId}"]`);
    if (fieldElement) {
        fieldElement.remove();

        // Show no fields message if no fields left
        const container = document.getElementById('fields-container');
        const noFields = document.getElementById('no-fields');
        if (container.children.length === 0) {
            noFields.style.display = 'block';
        }
    }
}

// toggleFieldOptions function removed - options not supported in current database schema
</script>
