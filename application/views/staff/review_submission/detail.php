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
            Detail lengkap submission dan data yang disubmit
        </p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= site_url('staff/review_submission') ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
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

<!-- Submission Info Card -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Informasi Submission
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Nomor Submission:</span>
                    <span class="text-gray-900 dark:text-gray-100 font-mono"><?= $submission['nomor_submission'] ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Template:</span>
                    <span class="text-gray-900 dark:text-gray-100"><?= $submission['nama_template'] ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Pengguna:</span>
                    <div class="text-right">
                        <div class="text-gray-900 dark:text-gray-100 font-medium"><?= $submission['nama_pengguna'] ?></div>
                        <div class="text-sm text-gray-500 dark:text-gray-400"><?= $submission['email_pengguna'] ?></div>
                    </div>
                </div>
                <div class="flex justify-between py-2">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Tanggal Submit:</span>
                    <span class="text-gray-900 dark:text-gray-100"><?= date('d/m/Y H:i', strtotime($submission['tanggal_submission'])) ?></span>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Status:</span>
                    <div>
                        <?php
                        $status_class = '';
                        $status_text = '';
                        switch ($submission['status']) {
                            case 'pending':
                                $status_class = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                $status_text = 'Menunggu Review';
                                break;
                            case 'diproses':
                                $status_class = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                $status_text = 'Sedang Diproses';
                                break;
                            case 'disetujui':
                                $status_class = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                $status_text = 'Disetujui';
                                break;
                            case 'ditolak':
                                $status_class = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                $status_text = 'Ditolak';
                                break;
                            default:
                                $status_class = 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                $status_text = ucfirst($submission['status']);
                        }
                        ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $status_class ?>">
                            <?= $status_text ?>
                        </span>
                    </div>
                </div>

                <?php if ($submission['diproses_oleh']): ?>
                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Diproses Oleh:</span>
                    <span class="text-gray-900 dark:text-gray-100"><?= $submission['nama_staff'] ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Tanggal Diproses:</span>
                    <span class="text-gray-900 dark:text-gray-100">
                        <?= $submission['tanggal_diproses'] ? date('d/m/Y H:i', strtotime($submission['tanggal_diproses'])) : '-' ?>
                    </span>
                </div>
                <?php endif; ?>

                <?php if ($submission['catatan_staff']): ?>
                <div class="py-2">
                    <span class="font-medium text-gray-600 dark:text-gray-400 block mb-2">Catatan Staff:</span>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-sm text-gray-900 dark:text-gray-100">
                        <?= nl2br(htmlspecialchars($submission['catatan_staff'])) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Data Submission Card -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                </svg>
                Data Submission
            </h3>
        </div>

        <?php if (!empty($data_submission)): ?>
            <div class="space-y-4">
                <?php foreach ($data_submission as $data): ?>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mr-3">
                                    <?= ucfirst(str_replace('_', ' ', $data['nama_field'])) ?>
                                </h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 mr-2">
                                    <?= ucfirst($data['tipe_field']) ?>
                                </span>
                                <?php
                                $is_required = ($data['wajib_diisi'] === 'ya' || $data['wajib_diisi'] === '1' || $data['wajib_diisi'] == 1);
                                ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $is_required ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' ?>">
                                    <?= $is_required ? 'Wajib' : 'Opsional' ?>
                                </span>
                            </div>

                            <div class="mt-2">
                                <?php if ($data['tipe_field'] === 'file'): ?>
                                    <?php if (!empty($data['value'])): ?>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                                <?= $data['value'] ?>
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            File tersimpan di server
                                        </p>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 italic">Tidak ada file</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if (!empty($data['value'])): ?>
                                        <div class="bg-white dark:bg-gray-800 rounded p-3 border border-gray-200 dark:border-gray-600">
                                            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap"><?= htmlspecialchars($data['value']) ?></p>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 italic">Tidak diisi</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-3 sm:mt-0 sm:ml-4">
                            <?php if ($data['tipe_field'] === 'file' && !empty($data['value'])): ?>
                                <a href="<?= site_url('staff/review_submission/download_file/' . $submission['id_submission'] . '/' . $data['nama_field']) ?>"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                   target="_blank">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Tidak ada data submission</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tidak ada data submission yang ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Action Buttons -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0 sm:space-x-3">
            <div class="flex flex-wrap gap-3">
                <?php if (in_array($submission['status'], array('pending', 'diproses'))): ?>
                    <?php if ($submission['status'] === 'pending'): ?>
                        <button type="button"
                                onclick="ambilSubmission(<?= $submission['id_submission'] ?>)"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                            Ambil untuk Diproses
                        </button>
                    <?php elseif ($submission['status'] === 'diproses' && $submission['diproses_oleh'] == $this->session->userdata('id_pengguna')): ?>
                        <a href="<?= site_url('staff/review_submission/proses/' . $submission['id_submission']) ?>"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            Proses Submission
                        </a>
                        <button type="button"
                                onclick="kembalikanSubmission(<?= $submission['id_submission'] ?>)"
                                class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                            Kembalikan ke Pending
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div>
                <a href="<?= site_url('staff/review_submission') ?>"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk AJAX -->
<script>
function ambilSubmission(idSubmission) {
    if (confirm('Apakah Anda yakin ingin mengambil submission ini untuk diproses?')) {
        // Show loading
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading...';
        button.disabled = true;

        fetch('<?= site_url('staff/review_submission/ambil_submission') ?>', {
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
                    location.reload();
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
                    location.reload();
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

// Function untuk show notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
