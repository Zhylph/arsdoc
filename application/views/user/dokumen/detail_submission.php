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

    <!-- Submission Info -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Submission: <?php echo $submission['nomor_submission']; ?>
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Template: <?php echo $submission['nama_template']; ?>
                    </p>
                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <span>Status: 
                            <?php
                            $status_class = '';
                            switch($submission['status']) {
                                case 'pending':
                                    $status_class = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                    break;
                                case 'diproses':
                                    $status_class = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                    break;
                                case 'disetujui':
                                    $status_class = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                    break;
                                case 'ditolak':
                                    $status_class = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                    break;
                            }
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $status_class; ?>">
                                <?php echo ucfirst($submission['status']); ?>
                            </span>
                        </span>
                        <span>Tanggal: <?php echo date('d/m/Y H:i', strtotime($submission['tanggal_submission'])); ?></span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <?php if ($submission['status'] === 'pending'): ?>
                        <a href="<?php echo site_url('user/submission/edit/' . $submission['id_submission']); ?>" 
                           class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <button onclick="hapusSubmission(<?php echo $submission['id_submission']; ?>)" 
                                class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($submission['catatan_staff'])): ?>
                <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Catatan Staff:</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo $submission['catatan_staff']; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Submission Data -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Data Submission</h3>
            
            <?php if (!empty($data_submission)): ?>
                <div class="space-y-6">
                    <?php foreach ($data_submission as $data): ?>
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0 last:pb-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                                        <?php echo ucfirst(str_replace('_', ' ', $data['nama_field'])); ?>
                                        <?php if ($data['wajib_diisi']): ?>
                                            <span class="text-red-500">*</span>
                                        <?php endif; ?>
                                    </h4>
                                    
                                    <?php if ($data['tipe_field'] === 'file'): ?>
                                        <?php if (!empty($data['value'])): ?>
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $data['value']; ?></span>
                                                </div>
                                                <a href="<?php echo site_url('user/dokumen/download_file/' . $submission['id_submission'] . '/' . $data['nama_field']); ?>" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Download
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada file</p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <?php if (!empty($data['value'])): ?>
                                                <?php if ($data['tipe_field'] === 'textarea'): ?>
                                                    <div class="whitespace-pre-wrap"><?php echo $data['value']; ?></div>
                                                <?php else: ?>
                                                    <?php echo $data['value']; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="italic">Tidak diisi</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada data submission.</p>
                </div>
            <?php endif; ?>
            
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                <a href="<?php echo site_url('user/dokumen/submission'); ?>" 
                   class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                    Kembali ke Daftar Submission
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mt-2">Hapus Submission</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Apakah Anda yakin ingin menghapus submission ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmDelete" 
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Hapus
                </button>
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let submissionToDelete = null;

function hapusSubmission(idSubmission) {
    submissionToDelete = idSubmission;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    submissionToDelete = null;
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (submissionToDelete) {
        // Send AJAX request to delete submission
        fetch('<?php echo site_url('user/dokumen/hapus_submission'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'id_submission=' + submissionToDelete
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Submission berhasil dihapus.');
                window.location.href = '<?php echo site_url('user/dokumen/submission'); ?>';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus submission.');
        })
        .finally(() => {
            closeDeleteModal();
        });
    }
});

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
