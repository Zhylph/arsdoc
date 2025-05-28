<!-- Main Content -->
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
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
                <div class="flex space-x-2">
                    <a href="<?php echo site_url('staff/jenis_dokumen/edit/' . $jenis_dokumen['id_jenis']); ?>" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                        Edit Jenis Dokumen
                    </a>
                    <a href="<?php echo site_url('staff/template_dokumen/tambah?jenis=' . $jenis_dokumen['id_jenis']); ?>" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Buat Template
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Info Utama -->
                    <div class="lg:col-span-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                    <?php echo $jenis_dokumen['nama_jenis']; ?>
                                </h2>
                                <div class="flex items-center space-x-4 mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        <?php echo $jenis_dokumen['status'] === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'; ?>">
                                        <?php echo ucfirst($jenis_dokumen['status']); ?>
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        ID: <?php echo $jenis_dokumen['id_jenis']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($jenis_dokumen['deskripsi'])): ?>
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Deskripsi</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                <?php echo nl2br(htmlspecialchars($jenis_dokumen['deskripsi'])); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Info Tambahan -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat Oleh</dt>
                                <dd class="text-sm text-gray-900 dark:text-white"><?php echo $jenis_dokumen['dibuat_oleh_nama']; ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dibuat</dt>
                                <dd class="text-sm text-gray-900 dark:text-white"><?php echo date('d M Y, H:i', strtotime($jenis_dokumen['tanggal_dibuat'])); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diperbarui</dt>
                                <dd class="text-sm text-gray-900 dark:text-white"><?php echo date('d M Y, H:i', strtotime($jenis_dokumen['tanggal_diperbarui'])); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Template</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        <?php echo count($template_dokumen); ?> template
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Dokumen -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Template Dokumen
                        <span class="text-sm font-normal text-gray-500">
                            (<?php echo count($template_dokumen); ?> template)
                        </span>
                    </h3>
                    <a href="<?php echo site_url('staff/template_dokumen/tambah?jenis=' . $jenis_dokumen['id_jenis']); ?>" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:ring-4 focus:ring-blue-300 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-600 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Tambah Template
                    </a>
                </div>

                <?php if (!empty($template_dokumen)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($template_dokumen as $template): ?>
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                <?php echo $template['nama_template']; ?>
                            </h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                <?php echo $template['status'] === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'; ?>">
                                <?php echo ucfirst($template['status']); ?>
                            </span>
                        </div>
                        
                        <?php if (!empty($template['deskripsi'])): ?>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            <?php echo substr($template['deskripsi'], 0, 100) . (strlen($template['deskripsi']) > 100 ? '...' : ''); ?>
                        </p>
                        <?php endif; ?>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span><?php echo $template['jumlah_submission']; ?> submission</span>
                            <span><?php echo date('d M Y', strtotime($template['tanggal_dibuat'])); ?></span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="<?php echo site_url('staff/template_dokumen/detail/' . $template['id_template']); ?>" 
                               class="flex-1 text-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:ring-4 focus:ring-blue-300 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-600 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                                Detail
                            </a>
                            <a href="<?php echo site_url('staff/template_dokumen/edit/' . $template['id_template']); ?>" 
                               class="flex-1 text-center px-3 py-2 text-sm font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-600 dark:hover:bg-yellow-800 dark:focus:ring-yellow-800">
                                Edit
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada template</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan membuat template dokumen untuk jenis ini.</p>
                    <div class="mt-6">
                        <a href="<?php echo site_url('staff/template_dokumen/tambah?jenis=' . $jenis_dokumen['id_jenis']); ?>" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Buat Template Pertama
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
