<!-- Breadcrumb -->
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <svg class="w-3 h-3 mr-2.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
            </svg>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo $page_title; ?></span>
        </li>
    </ol>
</nav>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100"><?php echo $page_title; ?></h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Selamat datang di dashboard administrator. Kelola sistem arsip dokumen dengan mudah.
        </p>
    </div>
    <div class="mt-4 sm:mt-0">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Sistem Aktif
        </span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Pengguna -->
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        <?php echo number_format($statistik['total_pengguna']); ?>
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center space-x-4 text-sm">
                <span class="text-blue-600 dark:text-blue-400 font-medium">Admin: <?php echo $statistik['total_admin']; ?></span>
                <span class="text-green-600 dark:text-green-400 font-medium">Staff: <?php echo $statistik['total_staff']; ?></span>
                <span class="text-purple-600 dark:text-purple-400 font-medium">User: <?php echo $statistik['total_user']; ?></span>
            </div>
        </div>
    </div>

    <!-- Total Template -->
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Template Dokumen</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        <?php echo number_format($statistik['total_template']); ?>
                    </p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Jenis Dokumen: <span class="font-medium text-green-600 dark:text-green-400"><?php echo $statistik['total_jenis_dokumen']; ?></span>
                </span>
            </div>
        </div>
    </div>

    <!-- Total Submission -->
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Submission</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        <?php echo number_format($statistik['total_submission']); ?>
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center space-x-4 text-sm">
                <span class="text-yellow-600 dark:text-yellow-400 font-medium">Pending: <?php echo $statistik['submission_pending']; ?></span>
                <span class="text-green-600 dark:text-green-400 font-medium">Disetujui: <?php echo $statistik['submission_disetujui']; ?></span>
            </div>
        </div>
    </div>

    <!-- Storage Usage -->
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Penggunaan Storage</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        <?php echo $statistik['total_ukuran_file']; ?> <span class="text-lg">MB</span>
                    </p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Total File: <span class="font-medium text-purple-600 dark:text-purple-400"><?php echo number_format($statistik['total_file_pribadi']); ?></span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Submission Chart -->
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Status Submission</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Live Data</span>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="submissionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Aktivitas Terbaru</h3>
                <a href="<?= site_url('admin/log_aktivitas') ?>" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                    Lihat Semua
                </a>
            </div>
            <div class="flow-root">
                <ul role="list" class="space-y-4">
                    <?php foreach ($aktivitas_terbaru as $index => $aktivitas): ?>
                    <li class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="activity-avatar w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    <span class="font-medium"><?php echo $aktivitas['nama_lengkap']; ?></span>
                                    <span class="text-gray-600 dark:text-gray-400"><?php echo $aktivitas['aktivitas']; ?></span>
                                </p>
                                <time class="text-xs text-gray-500 dark:text-gray-400" datetime="<?php echo $aktivitas['tanggal_aktivitas']; ?>">
                                    <?php echo date('d M, H:i', strtotime($aktivitas['tanggal_aktivitas'])); ?>
                                </time>
                            </div>
                            <?php if (!empty($aktivitas['detail'])): ?>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo $aktivitas['detail']; ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pengguna Terbaru</h3>
            <a href="<?= site_url('admin/pengguna') ?>" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                Kelola Pengguna
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="dashboard-table min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($pengguna_terbaru as $pengguna): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        <?php echo strtoupper(substr($pengguna['nama_lengkap'], 0, 1)); ?>
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo $pengguna['nama_lengkap']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            <?php echo $pengguna['email']; ?>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo $pengguna['role'] === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' :
                                          ($pengguna['role'] === 'staff' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'); ?>">
                                <?php echo ucfirst($pengguna['role']); ?>
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            <?php echo date('d M Y', strtotime($pengguna['tanggal_dibuat'])); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Submission Status Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('submissionChart').getContext('2d');

    // Check if dark mode is enabled
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#E5E7EB' : '#374151';
    const gridColor = isDarkMode ? '#374151' : '#E5E7EB';

    const submissionChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [
                    <?php echo $statistik['submission_pending']; ?>,
                    <?php echo $statistik['submission_diproses']; ?>,
                    <?php echo $statistik['submission_disetujui']; ?>,
                    <?php echo $statistik['submission_ditolak']; ?>
                ],
                backgroundColor: [
                    '#F59E0B', // Yellow for Pending
                    '#3B82F6', // Blue for Diproses
                    '#10B981', // Green for Disetujui
                    '#EF4444'  // Red for Ditolak
                ],
                borderWidth: 3,
                borderColor: isDarkMode ? '#1F2937' : '#ffffff',
                hoverBorderWidth: 4,
                hoverBorderColor: isDarkMode ? '#374151' : '#f3f4f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: textColor,
                        font: {
                            size: 12,
                            family: 'Inter, system-ui, sans-serif'
                        },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: isDarkMode ? '#1F2937' : '#ffffff',
                    titleColor: textColor,
                    bodyColor: textColor,
                    borderColor: gridColor,
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
