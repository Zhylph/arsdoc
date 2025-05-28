<!-- Breadcrumb -->
<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?= base_url('admin/dashboard') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
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
                <a href="<?= base_url('admin/pengguna') ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Manajemen Pengguna</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 6 10">
                    <path fill-rule="evenodd" d="m1 4 3.586 3.586a2 2 0 0 0 2.828 0l3.586-3.586a2 2 0 0 0-2.828-2.828L4 5.172 1.828 3a2 2 0 0 0-2.828 2.828Z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500">Tambah Pengguna</span>
            </div>
        </li>
    </ol>
</nav>

<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900"><?= $page_title ?></h1>
        <p class="mt-1 text-sm text-gray-600">Tambahkan pengguna baru ke sistem arsip dokumen</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= base_url('admin/pengguna') ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('error')): ?>
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
    <div class="flex">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <?= $this->session->flashdata('error') ?>
    </div>
</div>
<?php endif; ?>

<!-- Form Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Informasi Pengguna</h3>
        <p class="mt-1 text-sm text-gray-600">Lengkapi form di bawah untuk menambahkan pengguna baru</p>
    </div>
    
    <form action="<?= base_url('admin/pengguna/tambah') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Lengkap -->
            <div class="md:col-span-2">
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= set_value('nama_lengkap') ?>" 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 <?= form_error('nama_lengkap') ? 'border-red-500' : '' ?>"
                       placeholder="Masukkan nama lengkap pengguna" required>
                <?php if (form_error('nama_lengkap')): ?>
                <p class="mt-1 text-sm text-red-600"><?= form_error('nama_lengkap') ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="<?= set_value('email') ?>" 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 <?= form_error('email') ? 'border-red-500' : '' ?>"
                       placeholder="contoh@email.com" required>
                <?php if (form_error('email')): ?>
                <p class="mt-1 text-sm text-red-600"><?= form_error('email') ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 <?= form_error('password') ? 'border-red-500' : '' ?>"
                           placeholder="Minimal 6 karakter" required>
                    <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <?php if (form_error('password')): ?>
                <p class="mt-1 text-sm text-red-600"><?= form_error('password') ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role" name="role" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 <?= form_error('role') ? 'border-red-500' : '' ?>">
                    <option value="">Pilih Role</option>
                    <option value="admin" <?= set_select('role', 'admin') ?>>Admin</option>
                    <option value="staff" <?= set_select('role', 'staff') ?>>Staff</option>
                    <option value="user" <?= set_select('role', 'user') ?>>User</option>
                </select>
                <?php if (form_error('role')): ?>
                <p class="mt-1 text-sm text-red-600"><?= form_error('role') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-xs text-gray-500">
                    <strong>Admin:</strong> Akses penuh sistem | 
                    <strong>Staff:</strong> Kelola template & review | 
                    <strong>User:</strong> Submit dokumen
                </p>
            </div>
            
            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" name="status" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 <?= form_error('status') ? 'border-red-500' : '' ?>">
                    <option value="">Pilih Status</option>
                    <option value="aktif" <?= set_select('status', 'aktif', true) ?>>Aktif</option>
                    <option value="nonaktif" <?= set_select('status', 'nonaktif') ?>>Nonaktif</option>
                </select>
                <?php if (form_error('status')): ?>
                <p class="mt-1 text-sm text-red-600"><?= form_error('status') ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Foto Profil -->
            <div class="md:col-span-2">
                <label for="foto_profil" class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Profil
                </label>
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img id="preview_foto" class="h-16 w-16 rounded-full object-cover border-2 border-gray-300" 
                             src="data:image/svg+xml,%3csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100' height='100' fill='%23f3f4f6'/%3e%3ctext x='50%25' y='50%25' font-size='18' text-anchor='middle' alignment-baseline='middle' fill='%236b7280'%3eUser%3c/text%3e%3c/svg%3e" 
                             alt="Preview">
                    </div>
                    <div class="flex-1">
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" onchange="previewImage(this)"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF hingga 2MB. Ukuran optimal 400x400px.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
            <a href="<?= base_url('admin/pengguna') ?>" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Pengguna
            </button>
        </div>
    </form>
</div>

<!-- JavaScript -->
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_foto').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Validasi form
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;
    const status = document.getElementById('status').value;
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Password minimal 6 karakter!');
        return false;
    }
    
    if (!role) {
        e.preventDefault();
        alert('Silakan pilih role pengguna!');
        return false;
    }
    
    if (!status) {
        e.preventDefault();
        alert('Silakan pilih status pengguna!');
        return false;
    }
});
</script>
