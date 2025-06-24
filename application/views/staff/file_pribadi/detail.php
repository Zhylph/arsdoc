<!-- Detail File Pribadi User -->
<div class="p-4 sm:ml-64">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 mt-14 p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Detail File Pribadi</h1>
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <?php foreach ($breadcrumb as $label => $url): ?>
                        <?php if (empty($url)): ?>
                            <li aria-current="page">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo $label; ?></span>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo site_url($url); ?>" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"><?php echo $label; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
        <div class="mb-6 flex flex-col md:flex-row gap-8">
            <div class="flex-1">
                <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Nama File</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo $file['nama_file']; ?></dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">User</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo $user ? $user['nama_lengkap'] : '-'; ?></dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Folder</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo !empty($file['nama_folder']) ? $file['nama_folder'] : 'Root'; ?></dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Tipe File</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo strtoupper($file['tipe_file']); ?></dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Ukuran</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo format_bytes($file['ukuran_file']); ?></dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Jumlah Download</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo $file['jumlah_download']; ?> kali</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Tanggal Upload</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo date('d M Y H:i', strtotime($file['tanggal_upload'])); ?></dd>
                    </div>
                    <?php if (!empty($file['deskripsi'])): ?>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium text-gray-600 dark:text-gray-400">Deskripsi</dt>
                        <dd class="text-gray-900 dark:text-white text-right"><?php echo $file['deskripsi']; ?></dd>
                    </div>
                    <?php endif; ?>
                </dl>
            </div>
            <div class="flex-1 flex flex-col items-center justify-center">
                <?php if (in_array(strtolower($file['tipe_file']), ['jpg','jpeg','png','gif'])): ?>
                    <img src="<?php echo base_url('uploads/file_pribadi/' . $file['nama_file_sistem']); ?>" alt="Preview" class="rounded-lg max-h-64 shadow border dark:border-gray-700">
                <?php elseif (strtolower($file['tipe_file']) === 'pdf'): ?>
                    <iframe src="<?php echo base_url('uploads/file_pribadi/' . $file['nama_file_sistem']); ?>" class="w-full h-64 rounded-lg border dark:border-gray-700" frameborder="0"></iframe>
                <?php else: ?>
                    <div class="text-gray-400 italic">Tidak ada preview tersedia</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex justify-between mt-8">
            <a href="<?php echo site_url('staff/file_pribadi'); ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 font-medium">
                &larr; Kembali
            </a>
            <a href="<?php echo site_url('staff/file_pribadi/download/' . $file['id_file']); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                Download
            </a>
        </div>
    </div>
</div>

<?php
function format_bytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    return round($bytes, $precision) . ' ' . $units[$i];
}
?> 