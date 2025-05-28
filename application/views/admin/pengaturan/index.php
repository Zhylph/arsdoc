<!-- Breadcrumb -->
<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?= base_url('admin/dashboard') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 6 10">
                    <path fill-rule="evenodd" d="m1 4 3.586 3.586a2 2 0 0 0 2.828 0l3.586-3.586a2 2 0 0 0-2.828-2.828L4 5.172 1.828 3a2 2 0 0 0-2.828 2.828Z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Pengaturan Sistem</span>
            </div>
        </li>
    </ol>
</nav>

<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100"><?= $page_title ?></h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola konfigurasi global sistem arsip dokumen</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <a href="<?= base_url('admin/pengaturan/backup') ?>" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Backup
        </a>
        <a href="<?= base_url('admin/pengaturan/sistem_info') ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Info Sistem
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
<div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6" role="alert">
    <div class="flex">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <?= $this->session->flashdata('success') ?>
    </div>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6" role="alert">
    <div class="flex">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <?= $this->session->flashdata('error') ?>
    </div>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('warning')): ?>
<div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 px-4 py-3 rounded-lg mb-6" role="alert">
    <div class="flex">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <?= $this->session->flashdata('warning') ?>
    </div>
</div>
<?php endif; ?>

<!-- Settings Form -->
<form action="<?= base_url('admin/pengaturan/simpan') ?>" method="POST" id="settingsForm">
    <?php if (!empty($pengaturan_grouped)): ?>
        <?php foreach ($pengaturan_grouped as $kategori => $settings): ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100"><?= ucfirst($kategori) ?></h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pengaturan <?= strtolower($kategori) ?> sistem</p>
                </div>
                <button type="button" onclick="resetKategori('<?= $kategori ?>')" class="text-sm text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset ke Default
                </button>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($settings as $setting): ?>
                    <div class="<?= in_array($setting['tipe'], ['textarea']) ? 'md:col-span-2' : '' ?>">
                        <label for="<?= $setting['key'] ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?= $setting['label'] ?>
                            <?php if ($setting['required']): ?>
                            <span class="text-red-500">*</span>
                            <?php endif; ?>
                        </label>
                        
                        <?php if ($setting['tipe'] === 'textarea'): ?>
                        <textarea id="<?= $setting['key'] ?>" name="<?= $setting['key'] ?>" rows="3" 
                                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  <?= $setting['required'] ? 'required' : '' ?>><?= $setting['value'] ?></textarea>
                        
                        <?php elseif ($setting['tipe'] === 'select'): ?>
                        <select id="<?= $setting['key'] ?>" name="<?= $setting['key'] ?>" 
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                <?= $setting['required'] ? 'required' : '' ?>>
                            <?php 
                            $options = json_decode($setting['options'], true);
                            if ($options):
                                foreach ($options as $value => $label):
                            ?>
                            <option value="<?= $value ?>" <?= $setting['value'] == $value ? 'selected' : '' ?>><?= $label ?></option>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </select>
                        
                        <?php elseif ($setting['tipe'] === 'checkbox'): ?>
                        <div class="flex items-center">
                            <input type="hidden" name="<?= $setting['key'] ?>" value="0">
                            <input type="checkbox" id="<?= $setting['key'] ?>" name="<?= $setting['key'] ?>" value="1" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded"
                                   <?= $setting['value'] == '1' ? 'checked' : '' ?>>
                            <label for="<?= $setting['key'] ?>" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                Aktifkan
                            </label>
                        </div>
                        
                        <?php else: ?>
                        <input type="<?= $setting['tipe'] ?>" id="<?= $setting['key'] ?>" name="<?= $setting['key'] ?>" 
                               value="<?= $setting['value'] ?>"
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               <?= $setting['required'] ? 'required' : '' ?>>
                        <?php endif; ?>
                        
                        <?php if (!empty($setting['deskripsi'])): ?>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400"><?= $setting['deskripsi'] ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Form Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pastikan untuk menyimpan perubahan sebelum meninggalkan halaman ini.
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="resetForm()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Reset Semua
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    <?php else: ?>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada pengaturan</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pengaturan sistem akan muncul di sini setelah diinisialisasi.</p>
    </div>
    <?php endif; ?>
</form>

<!-- JavaScript -->
<script>
function resetKategori(kategori) {
    if (confirm('Apakah Anda yakin ingin mereset pengaturan kategori "' + kategori + '" ke nilai default?')) {
        fetch('<?= base_url('admin/pengaturan/reset') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'kategori=' + kategori
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mereset pengaturan.');
        });
    }
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset semua pengaturan ke nilai default?')) {
        location.reload();
    }
}

// Auto-save draft (optional)
let saveTimeout;
document.getElementById('settingsForm').addEventListener('input', function() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(function() {
        // Auto-save logic here if needed
        console.log('Auto-saving draft...');
    }, 2000);
});

// Form validation
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let hasError = false;
    
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            hasError = true;
        } else {
            field.classList.remove('border-red-500');
        }
    });
    
    if (hasError) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi.');
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
    submitBtn.disabled = true;
    
    // Re-enable after 3 seconds (fallback)
    setTimeout(function() {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});
</script>
