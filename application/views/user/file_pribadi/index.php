<div class="container mx-auto px-4">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div class="mb-4 md:mb-0">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100"><?php echo $page_title; ?></h1>

            <!-- Breadcrumb -->
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="<?php echo site_url('user/dashboard'); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="<?php echo site_url('user/file_pribadi'); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">File Pribadi</a>
                        </div>
                    </li>
                    <?php if (!empty($folder_breadcrumb)): ?>
                        <?php foreach ($folder_breadcrumb as $folder): ?>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <a href="<?php echo site_url('user/file_pribadi/index/' . $folder['id_folder']); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"><?php echo $folder['nama_folder']; ?></a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                                <?php echo $current_folder ? $current_folder['nama_folder'] : 'Root'; ?>
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-2">
            <button type="button" data-modal-target="uploadModal" data-modal-toggle="uploadModal" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                <i class="fas fa-upload mr-2"></i>Upload File
            </button>
            <button type="button" data-modal-target="folderModal" data-modal-toggle="folderModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class="fas fa-folder-plus mr-2"></i>Buat Folder
            </button>
            <!-- <a href="<?php echo site_url('user/file_pribadi/debug_buat_folder'); ?>" target="_blank" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                <i class="fas fa-bug mr-2"></i>Debug
            </a>
            <button type="button" onclick="testAjax()" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">
                <i class="fas fa-flask mr-2"></i>Test AJAX
            </button>
            <button type="button" onclick="testSimpleFolder()" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800">
                <i class="fas fa-folder mr-2"></i>Test Simple
            </button>
            <button type="button" onclick="testNoLogFolder()" class="text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-pink-600 dark:hover:bg-pink-700 focus:outline-none dark:focus:ring-pink-800">
                <i class="fas fa-folder-open mr-2"></i>Test No Log
            </button>
            <button type="button" onclick="testDebugJson()" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                <i class="fas fa-code mr-2"></i>Test JSON
            </button> -->
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-file text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total File</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-gray-100"><?php echo $statistik['total_file']; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-folder text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Folder</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-gray-100"><?php echo $statistik['total_folder']; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-hdd text-2xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Ukuran</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                <?php echo number_format($statistik['total_ukuran'] / 1024, 2); ?> MB
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-download text-2xl text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Download</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-gray-100"><?php echo $statistik['total_download']; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Filter & Pencarian</h3>
        </div>
        <div class="p-6">
            <form method="GET" action="<?php echo site_url('user/file_pribadi' . ($id_folder ? '/index/' . $id_folder : '')); ?>" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <div class="flex-1">
                    <label for="pencarian" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari File</label>
                    <input type="text" id="pencarian" name="pencarian" value="<?php echo $filter['pencarian']; ?>" placeholder="Masukkan nama file atau deskripsi..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                </div>
                <div class="md:w-48">
                    <label for="tipe_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipe File</label>
                    <select id="tipe_file" name="tipe_file" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Semua Tipe</option>
                        <option value=".pdf" <?php echo ($filter['tipe_file'] == '.pdf') ? 'selected' : ''; ?>>PDF</option>
                        <option value=".doc" <?php echo ($filter['tipe_file'] == '.doc') ? 'selected' : ''; ?>>DOC</option>
                        <option value=".docx" <?php echo ($filter['tipe_file'] == '.docx') ? 'selected' : ''; ?>>DOCX</option>
                        <option value=".xls" <?php echo ($filter['tipe_file'] == '.xls') ? 'selected' : ''; ?>>XLS</option>
                        <option value=".xlsx" <?php echo ($filter['tipe_file'] == '.xlsx') ? 'selected' : ''; ?>>XLSX</option>
                        <option value=".jpg" <?php echo ($filter['tipe_file'] == '.jpg') ? 'selected' : ''; ?>>JPG</option>
                        <option value=".png" <?php echo ($filter['tipe_file'] == '.png') ? 'selected' : ''; ?>>PNG</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    <a href="<?php echo site_url('user/file_pribadi' . ($id_folder ? '/index/' . $id_folder : '')); ?>" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- File & Folder List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                File & Folder (<?php echo $total_rows; ?> item)
            </h3>
        </div>
        <div class="p-6">
            <?php if (!empty($folders) || !empty($files)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ukuran</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Download</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Folders -->
                            <?php foreach ($folders as $folder): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <i class="fas fa-folder text-yellow-500 text-xl"></i>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="<?php echo site_url('user/file_pribadi/index/' . $folder['id_folder']); ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                            <?php echo $folder['nama_folder']; ?>
                                        </a>
                                        <?php if ($folder['deskripsi']): ?>
                                            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo $folder['deskripsi']; ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?php echo date('d/m/Y H:i', strtotime($folder['tanggal_dibuat'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button type="button" onclick="renameItem('folder', <?php echo $folder['id_folder']; ?>, '<?php echo addslashes($folder['nama_folder']); ?>')" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" onclick="deleteFolder(<?php echo $folder['id_folder']; ?>)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- Files -->
                            <?php foreach ($files as $file): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <?php
                                        $icon_class = 'fa-file';
                                        $icon_color = 'text-gray-500';

                                        switch (strtolower($file['tipe_file'])) {
                                            case '.pdf':
                                                $icon_class = 'fa-file-pdf';
                                                $icon_color = 'text-red-500';
                                                break;
                                            case '.doc':
                                            case '.docx':
                                                $icon_class = 'fa-file-word';
                                                $icon_color = 'text-blue-500';
                                                break;
                                            case '.xls':
                                            case '.xlsx':
                                                $icon_class = 'fa-file-excel';
                                                $icon_color = 'text-green-500';
                                                break;
                                            case '.jpg':
                                            case '.jpeg':
                                            case '.png':
                                            case '.gif':
                                                $icon_class = 'fa-file-image';
                                                $icon_color = 'text-purple-500';
                                                break;
                                        }
                                        ?>
                                        <i class="fas <?php echo $icon_class . ' ' . $icon_color; ?> text-xl"></i>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900 dark:text-gray-100"><?php echo $file['nama_file']; ?></div>
                                        <?php if ($file['deskripsi']): ?>
                                            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo $file['deskripsi']; ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?php echo number_format($file['ukuran_file']); ?> KB</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?php echo date('d/m/Y H:i', strtotime($file['tanggal_upload'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center"><?php echo $file['jumlah_download']; ?>x</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="<?php echo site_url('user/file_pribadi/download/' . $file['id_file']); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" onclick="renameItem('file', <?php echo $file['id_file']; ?>, '<?php echo addslashes($file['nama_file']); ?>')" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" onclick="deleteFile(<?php echo $file['id_file']; ?>)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pagination): ?>
                    <div class="flex justify-center mt-6">
                        <?php echo $pagination; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-folder-open text-6xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Folder Kosong</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Belum ada file atau folder di lokasi ini.</p>
                    <button type="button" data-modal-target="uploadModal" data-modal-toggle="uploadModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <i class="fas fa-upload mr-2"></i>Upload File Pertama
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Upload File</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="uploadModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="uploadForm" class="p-4 md:p-5" enctype="multipart/form-data">
                <div class="grid gap-4 mb-4">
                    <div>
                        <label for="file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih File</label>
                        <input type="file" id="file" name="file" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Maksimal 10MB. Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, JPEG, PNG, GIF, TXT, ZIP, RAR</p>
                    </div>
                    <div>
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan deskripsi file..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" data-modal-toggle="uploadModal" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Batal
                    </button>
                    <button type="submit" class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        <i class="fas fa-upload mr-2"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Folder Modal -->
<div id="folderModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buat Folder Baru</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="folderModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="folderForm" class="p-4 md:p-5">
                <div class="grid gap-4 mb-4">
                    <div>
                        <label for="nama_folder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Folder</label>
                        <input type="text" id="nama_folder" name="nama_folder" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan nama folder..." required>
                    </div>
                    <div>
                        <label for="deskripsi_folder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi_folder" name="deskripsi" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan deskripsi folder..."></textarea>
                    </div>
                    <input type="hidden" name="id_parent" value="<?php echo $id_folder; ?>">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" data-modal-toggle="folderModal" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Batal
                    </button>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fas fa-folder-plus mr-2"></i>Buat Folder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rename Modal -->
<div id="renameModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 id="renameModalLabel" class="text-lg font-semibold text-gray-900 dark:text-white">Rename</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="renameModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="renameForm" class="p-4 md:p-5">
                <div class="grid gap-4 mb-4">
                    <div>
                        <label for="nama_baru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Baru</label>
                        <input type="text" id="nama_baru" name="nama_baru" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <input type="hidden" id="rename_type" name="type">
                    <input type="hidden" id="rename_id" name="id">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" data-modal-toggle="renameModal" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Batal
                    </button>
                    <button type="submit" class="text-white inline-flex items-center bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        <i class="fas fa-edit mr-2"></i>Rename
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
        submitBtn.disabled = true;

        fetch('<?php echo site_url("user/file_pribadi/upload" . ($id_folder ? "/" . $id_folder : "")); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat upload file.'
            });
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    
    document.getElementById('folderForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        const formData = new FormData(this);

        
        const namaFolder = formData.get('nama_folder');
        if (!namaFolder || namaFolder.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Nama folder harus diisi.'
            });
            return;
        }

        
        console.log('Data yang akan dikirim:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membuat...';
        submitBtn.disabled = true;

        fetch('<?php echo site_url("user/file_pribadi/buat_folder"); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers.get('content-type'));

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            
            return response.text().then(text => {
                console.log('Raw response:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    console.error('Response text:', text);
                    throw new Error('Invalid JSON response: ' + text.substring(0, 100));
                }
            });
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan yang tidak diketahui.'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat membuat folder. Silakan coba lagi.'
            });
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    
    document.getElementById('renameForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
        submitBtn.disabled = true;

        fetch('<?php echo site_url("user/file_pribadi/rename"); ?>', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat rename.'
            });
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
});


function renameItem(type, id, currentName) {
    document.getElementById('rename_type').value = type;
    document.getElementById('rename_id').value = id;
    document.getElementById('nama_baru').value = currentName;
    document.getElementById('renameModalLabel').textContent = 'Rename ' + (type === 'file' ? 'File' : 'Folder');

    
    const renameModal = document.getElementById('renameModal');
    renameModal.classList.remove('hidden');
    renameModal.classList.add('flex');
}


function deleteFile(id) {
    Swal.fire({
        title: 'Hapus File?',
        text: 'File yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id_file', id);

            fetch('<?php echo site_url("user/file_pribadi/hapus_file"); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus file.'
                });
            });
        }
    });
}


function deleteFolder(id) {
    Swal.fire({
        title: 'Hapus Folder?',
        text: 'Folder yang dihapus tidak dapat dikembalikan! Pastikan folder kosong.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id_folder', id);

            fetch('<?php echo site_url("user/file_pribadi/hapus_folder"); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus folder.'
                });
            });
        }
    });
}


function testAjax() {
    console.log('Testing AJAX...');

    const formData = new FormData();
    formData.append('nama_folder', 'Test AJAX Folder');
    formData.append('id_parent', '<?php echo $id_folder; ?>');
    formData.append('deskripsi', 'Test AJAX description');

    fetch('<?php echo site_url("user/file_pribadi/test_ajax"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        Swal.fire({
            icon: data.success ? 'success' : 'error',
            title: data.success ? 'Test Berhasil!' : 'Test Gagal!',
            text: data.message,
            html: data.success ? '<pre>' + JSON.stringify(data.data, null, 2) + '</pre>' : data.message
        });
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat test AJAX: ' + error.message
        });
    });
}


function testSimpleFolder() {
    console.log('Testing Simple Folder Creation...');

    const formData = new FormData();
    formData.append('nama_folder', 'Test Simple ' + Date.now());
    formData.append('id_parent', '<?php echo $id_folder; ?>');
    formData.append('deskripsi', 'Test simple folder creation');

    fetch('<?php echo site_url("user/file_pribadi/buat_folder_simple"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));

        
        return response.text().then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e);
                console.error('Response text:', text);
                throw new Error('Invalid JSON response: ' + text.substring(0, 100));
            }
        });
    })
    .then(data => {
        console.log('Response data:', data);
        Swal.fire({
            icon: data.success ? 'success' : 'error',
            title: data.success ? 'Test Simple Berhasil!' : 'Test Simple Gagal!',
            text: data.message
        }).then(() => {
            if (data.success) {
                location.reload();
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat test simple folder: ' + error.message
        });
    });
}


function testNoLogFolder() {
    console.log('Testing No Log Folder Creation...');

    const formData = new FormData();
    formData.append('nama_folder', 'Test No Log ' + Date.now());
    formData.append('id_parent', '<?php echo $id_folder; ?>');
    formData.append('deskripsi', 'Test no log folder creation');

    fetch('<?php echo site_url("user/file_pribadi/buat_folder_no_log"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));

        
        return response.text().then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e);
                console.error('Response text:', text);
                throw new Error('Invalid JSON response: ' + text.substring(0, 100));
            }
        });
    })
    .then(data => {
        console.log('Response data:', data);
        Swal.fire({
            icon: data.success ? 'success' : 'error',
            title: data.success ? 'Test No Log Berhasil!' : 'Test No Log Gagal!',
            text: data.message
        }).then(() => {
            if (data.success) {
                location.reload();
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat test no log folder: ' + error.message
        });
    });
}


function testDebugJson() {
    console.log('Testing Debug JSON Response...');

    fetch('<?php echo site_url("user/file_pribadi/debug_json_response"); ?>', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));

        return response.text().then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e);
                console.error('Response text:', text);
                throw new Error('Invalid JSON response: ' + text.substring(0, 100));
            }
        });
    })
    .then(data => {
        console.log('Response data:', data);
        Swal.fire({
            icon: data.success ? 'success' : 'error',
            title: data.success ? 'Debug JSON Berhasil!' : 'Debug JSON Gagal!',
            text: data.message,
            html: data.success ? '<pre>' + JSON.stringify(data, null, 2) + '</pre>' : data.message
        });
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat test debug JSON: ' + error.message
        });
    });
}
</script>