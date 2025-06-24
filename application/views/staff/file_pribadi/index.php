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
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if ($this->session->flashdata('success_message')): ?>
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 alert-auto-hide" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM13.5 6a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM10 15a1 1 0 0 1-1-1v-3a1 1 0 0 1 2 0v3a1 1 0 0 1-1 1Z"/>
            </svg>
            <div><?php echo $this->session->flashdata('success_message'); ?></div>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error_message')): ?>
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800 alert-auto-hide" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div><?php echo $this->session->flashdata('error_message'); ?></div>
        </div>
        <?php endif; ?>

        <!-- Filter and Search -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
            <div class="p-6">
                <form method="GET" action="<?php echo site_url('staff/file_pribadi'); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="pencarian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pencarian</label>
                        <input type="text" id="pencarian" name="pencarian" 
                               value="<?php echo isset($filter['pencarian']) ? $filter['pencarian'] : ''; ?>"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                               placeholder="Cari nama file, deskripsi, atau user...">
                    </div>
                    
                    <div>
                        <label for="id_pengguna" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User</label>
                        <select id="id_pengguna" name="id_pengguna" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Semua User</option>
                            <?php foreach ($daftar_user as $user): ?>
                                <option value="<?php echo $user['id_pengguna']; ?>" <?php echo (isset($filter['id_pengguna']) && $filter['id_pengguna'] == $user['id_pengguna']) ? 'selected' : ''; ?>>
                                    <?php echo $user['nama_lengkap']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label for="tipe_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe File</label>
                        <select id="tipe_file" name="tipe_file" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Semua Tipe</option>
                            <option value="pdf" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'pdf') ? 'selected' : ''; ?>>PDF</option>
                            <option value="doc" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'doc') ? 'selected' : ''; ?>>DOC</option>
                            <option value="docx" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'docx') ? 'selected' : ''; ?>>DOCX</option>
                            <option value="xls" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'xls') ? 'selected' : ''; ?>>XLS</option>
                            <option value="xlsx" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'xlsx') ? 'selected' : ''; ?>>XLSX</option>
                            <option value="jpg" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'jpg') ? 'selected' : ''; ?>>JPG</option>
                            <option value="png" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'png') ? 'selected' : ''; ?>>PNG</option>
                            <option value="txt" <?php echo (isset($filter['tipe_file']) && $filter['tipe_file'] == 'txt') ? 'selected' : ''; ?>>TXT</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                            Cari
                        </button>
                        <a href="<?php echo site_url('staff/file_pribadi'); ?>" 
                           class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Daftar File Pribadi User
                        <span class="text-sm font-normal text-gray-500">
                            (<?php echo number_format($total_rows); ?> file)
                        </span>
                    </h3>
                </div>

                <?php if (!empty($file_pribadi)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama File</th>
                                <th scope="col" class="px-6 py-3">User</th>
                                <th scope="col" class="px-6 py-3">Folder</th>
                                <th scope="col" class="px-6 py-3">Tipe</th>
                                <th scope="col" class="px-6 py-3">Ukuran</th>
                                <th scope="col" class="px-6 py-3">Download</th>
                                <th scope="col" class="px-6 py-3">Tanggal Upload</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = (($current_page - 1) * $per_page) + 1;
                            foreach ($file_pribadi as $file): 
                            ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <?php echo $no++; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        <?php echo $file['nama_file']; ?>
                                    </div>
                                    <?php if (!empty($file['deskripsi'])): ?>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo substr($file['deskripsi'], 0, 50) . (strlen($file['deskripsi']) > 50 ? '...' : ''); ?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo $file['nama_lengkap']; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo !empty($file['nama_folder']) ? $file['nama_folder'] : 'Root'; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        <?php echo strtoupper($file['tipe_file']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo format_bytes($file['ukuran_file']); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo $file['jumlah_download']; ?> kali
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo date('d M Y H:i', strtotime($file['tanggal_upload'])); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo base_url('uploads/file_pribadi/' . $file['nama_file_sistem']); ?>" 
                                           class="text-cyan-600 hover:text-cyan-900 dark:text-cyan-400 dark:hover:text-cyan-300" 
                                           title="Lihat" target="_blank" rel="noopener">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2C5.454 2 1.732 5.943.458 10c1.274 4.057 4.996 8 9.542 8s8.268-3.943 9.542-8C18.268 5.943 14.546 2 10 2zm0 14c-3.866 0-7.163-3.13-8.388-6C2.837 7.13 6.134 4 10 4s7.163 3.13 8.388 6c-1.225 2.87-4.522 6-8.388 6zm0-10a4 4 0 100 8 4 4 0 000-8z"></path>
                                            </svg>
                                        </a>
                                        <a href="<?php echo site_url('staff/file_pribadi/download/' . $file['id_file']); ?>" 
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" 
                                           title="Download">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                        <!-- <button onclick="hapusFile(<?php echo $file['id_file']; ?>, '<?php echo addslashes($file['nama_file']); ?>')" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" 
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button> -->
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if (!empty($pagination)): ?>
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-700 dark:text-gray-400">
                        Menampilkan <?php echo (($current_page - 1) * $per_page) + 1; ?> - 
                        <?php echo min($current_page * $per_page, $total_rows); ?> dari <?php echo number_format($total_rows); ?> file
                    </div>
                    <?php echo $pagination; ?>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada data</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada file pribadi yang diupload oleh user.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript untuk AJAX -->
<script>
function hapusFile(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus file "' + nama + '"?')) {
        fetch('<?php echo site_url('staff/file_pribadi/hapus'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                'id_file': id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus file.');
        });
    }
}
</script>

<?php
/**
 * Helper function untuk format bytes
 */
function format_bytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}
?>

<!-- RAPIKAN TABEL DAN CONTAINER -->
<style>
    .file-table-container {
        max-width: 1100px;
        margin: 0 auto;
        background: var(--tw-bg-opacity) linear-gradient(90deg, #232946 0%, #1a1a2e 100%);
        border-radius: 1rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 2rem 2rem 2.5rem 2rem;
    }
    .file-table th, .file-table td {
        vertical-align: middle !important;
    }
    .file-table tr {
        transition: background 0.2s;
    }
    .file-table tr:hover {
        background: #23294622;
    }
</style>

<div class="file-table-container">
    <!-- ... seluruh konten tabel ... -->
</div> 