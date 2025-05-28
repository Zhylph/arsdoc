<!-- Main Content -->
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo $page_title; ?></h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <?php foreach ($breadcrumb as $label => $url): ?>
                        <?php if (empty($url)): ?>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"><?php echo $label; ?></span>
                                </div>
                            </li>
                        <?php else: ?>
                            <li>
                                <div class="flex items-center">
                                    <a href="<?php echo site_url($url); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"><?php echo $label; ?></a>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6">
                <form action="<?php echo site_url('staff/jenis_dokumen/edit/' . $jenis_dokumen['id_jenis']); ?>" method="post" class="space-y-6">
                    
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

                    <!-- Info Jenis Dokumen -->
                    <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    Mengedit: <?php echo $jenis_dokumen['nama_jenis']; ?>
                                </h3>
                                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                    Dibuat pada: <?php echo date('d M Y H:i', strtotime($jenis_dokumen['tanggal_dibuat'])); ?> 
                                    oleh <?php echo $jenis_dokumen['dibuat_oleh_nama']; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Jenis Dokumen -->
                    <div>
                        <label for="nama_jenis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nama Jenis Dokumen <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_jenis" name="nama_jenis" 
                               value="<?php echo set_value('nama_jenis', $jenis_dokumen['nama_jenis']); ?>"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                               placeholder="Contoh: Dokumen Kepegawaian" 
                               required>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Masukkan nama kategori dokumen yang akan dikelola.
                        </p>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" 
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                  placeholder="Jelaskan jenis dokumen ini dan kegunaannya..."><?php echo set_value('deskripsi', $jenis_dokumen['deskripsi']); ?></textarea>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Berikan penjelasan singkat tentang jenis dokumen ini (opsional).
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" <?php echo set_select('status', 'aktif', $jenis_dokumen['status'] === 'aktif'); ?>>Aktif</option>
                            <option value="nonaktif" <?php echo set_select('status', 'nonaktif', $jenis_dokumen['status'] === 'nonaktif'); ?>>Nonaktif</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Jenis dokumen dengan status "Aktif" dapat digunakan untuk membuat template dokumen.
                        </p>
                    </div>

                    <!-- Warning jika ada template -->
                    <?php 
                    $this->db->where('id_jenis', $jenis_dokumen['id_jenis']);
                    $jumlah_template = $this->db->count_all_results('template_dokumen');
                    if ($jumlah_template > 0): 
                    ?>
                    <div class="flex items-center p-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400 dark:border-yellow-800" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                        </svg>
                        <div>
                            <span class="font-medium">Perhatian:</span> Jenis dokumen ini memiliki <?php echo $jumlah_template; ?> template dokumen. 
                            Jika Anda mengubah status menjadi "Nonaktif", template dokumen yang menggunakan jenis ini tidak akan dapat digunakan untuk submission baru.
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <a href="<?php echo site_url('staff/jenis_dokumen'); ?>" 
                           class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11H16a1 1 0 110 2H2.586l3.707 3.707a1 1 0 01-1.414 1.414l-5.414-5.414a1 1 0 010-1.414l5.414-5.414a1 1 0 011.414 1.414L2.586 9H16a1 1 0 110 2H2.586l3.707 3.707z" clip-rule="evenodd"></path>
                            </svg>
                            Kembali
                        </a>
                        <a href="<?php echo site_url('staff/jenis_dokumen/detail/' . $jenis_dokumen['id_jenis']); ?>" 
                           class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                            Lihat Detail
                        </a>
                        <button type="submit" 
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Update Jenis Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Auto-focus pada field pertama -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nama_jenis').focus();
});
</script>
