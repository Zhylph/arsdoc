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
                <span class="ml-1 text-sm font-medium text-gray-500">Detail Pengguna</span>
            </div>
        </li>
    </ol>
</nav>

<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900"><?= $page_title ?></h1>
        <p class="mt-1 text-sm text-gray-600">Informasi lengkap dan statistik pengguna</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <a href="<?= base_url('admin/pengguna/edit/' . $pengguna['id_pengguna']) ?>" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
        <a href="<?= base_url('admin/pengguna') ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- User Profile Card -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="px-6 py-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-24 w-24">
                <?php if (!empty($pengguna['foto_profil'])): ?>
                <img class="h-24 w-24 rounded-full object-cover border-4 border-gray-300" src="<?= base_url('uploads/profil/' . $pengguna['foto_profil']) ?>" alt="<?= $pengguna['nama_lengkap'] ?>">
                <?php else: ?>
                <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-300">
                    <span class="text-2xl font-medium text-gray-700"><?= strtoupper(substr($pengguna['nama_lengkap'], 0, 2)) ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="ml-6 flex-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900"><?= $pengguna['nama_lengkap'] ?></h2>
                        <p class="text-lg text-gray-600"><?= $pengguna['email'] ?></p>
                        <div class="flex items-center mt-2 space-x-3">
                            <?php
                            $role_colors = [
                                'admin' => 'bg-red-100 text-red-800',
                                'staff' => 'bg-blue-100 text-blue-800',
                                'user' => 'bg-green-100 text-green-800'
                            ];
                            $status_colors = [
                                'aktif' => 'bg-green-100 text-green-800',
                                'nonaktif' => 'bg-red-100 text-red-800'
                            ];
                            ?>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?= $role_colors[$pengguna['role']] ?>">
                                <?= ucfirst($pengguna['role']) ?>
                            </span>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?= $status_colors[$pengguna['status']] ?>">
                                <?= ucfirst($pengguna['status']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Terdaftar</p>
                        <p class="text-lg font-semibold text-gray-900"><?= date('d/m/Y', strtotime($pengguna['tanggal_dibuat'])) ?></p>
                        <p class="text-xs text-gray-400"><?= date('H:i', strtotime($pengguna['tanggal_dibuat'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Submission</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($statistik['total_submission']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Diproses</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($statistik['total_diproses']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">File Pribadi</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($statistik['total_file_pribadi']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Aktivitas</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($statistik['total_aktivitas']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Detail Information -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Account Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Informasi Akun</h3>
        </div>
        <div class="px-6 py-4">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">ID Pengguna</dt>
                    <dd class="mt-1 text-sm text-gray-900">#<?= $pengguna['id_pengguna'] ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= $pengguna['nama_lengkap'] ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= $pengguna['email'] ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $role_colors[$pengguna['role']] ?>">
                            <?= ucfirst($pengguna['role']) ?>
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $status_colors[$pengguna['status']] ?>">
                            <?= ucfirst($pengguna['status']) ?>
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Terdaftar</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= date('d F Y, H:i', strtotime($pengguna['tanggal_dibuat'])) ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= date('d F Y, H:i', strtotime($pengguna['tanggal_diperbarui'])) ?></dd>
                </div>
                <?php if ($statistik['login_terakhir']): ?>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Login Terakhir</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= date('d F Y, H:i', strtotime($statistik['login_terakhir'])) ?></dd>
                </div>
                <?php endif; ?>
            </dl>
        </div>
    </div>
    
    <!-- Activity Summary -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Ringkasan Aktivitas</h3>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Submission Dokumen</p>
                            <p class="text-xs text-gray-500">Total dokumen yang disubmit</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-blue-600"><?= $statistik['total_submission'] ?></span>
                </div>
                
                <?php if ($pengguna['role'] == 'staff'): ?>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Dokumen Diproses</p>
                            <p class="text-xs text-gray-500">Total dokumen yang direview</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-green-600"><?= $statistik['total_diproses'] ?></span>
                </div>
                <?php endif; ?>
                
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">File Pribadi</p>
                            <p class="text-xs text-gray-500">File yang diupload</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-purple-600"><?= $statistik['total_file_pribadi'] ?></span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Log Aktivitas</p>
                            <p class="text-xs text-gray-500">Total aktivitas tercatat</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-yellow-600"><?= $statistik['total_aktivitas'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Aktivitas Terbaru</h3>
        <p class="mt-1 text-sm text-gray-600">10 aktivitas terakhir dari pengguna ini</p>
    </div>
    
    <?php if (empty($aktivitas_terbaru)): ?>
    <div class="px-6 py-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas</h3>
        <p class="mt-1 text-sm text-gray-500">Pengguna ini belum melakukan aktivitas apapun.</p>
    </div>
    <?php else: ?>
    <div class="divide-y divide-gray-200">
        <?php foreach ($aktivitas_terbaru as $aktivitas): ?>
        <div class="px-6 py-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900"><?= $aktivitas['aktivitas'] ?></p>
                    <?php if (!empty($aktivitas['detail'])): ?>
                    <p class="text-sm text-gray-600 mt-1"><?= $aktivitas['detail'] ?></p>
                    <?php endif; ?>
                    <p class="text-xs text-gray-400 mt-2"><?= date('d/m/Y H:i:s', strtotime($aktivitas['tanggal_aktivitas'])) ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
