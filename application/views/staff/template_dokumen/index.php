<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Content Header -->
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <div class="mb-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <?php foreach ($breadcrumb as $label => $url): ?>
                        <?php if ($url): ?>
                            <li class="inline-flex items-center">
                                <a href="<?php echo site_url($url); ?>" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                                    <?php echo $label; ?>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="inline-flex items-center text-gray-500 dark:text-gray-400" aria-current="page">
                                <?php echo $label; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>

            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"><?php echo $page_title; ?></h1>
        </div>

        <!-- Action Buttons -->
        <div class="sm:flex">
            <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <div class="lg:pr-3">
                    <label for="search" class="sr-only">Cari</label>
                    <div class="relative mt-1 lg:w-64 xl:w-96">
                        <input type="text" id="search" name="search" value="<?php echo $this->input->get('search'); ?>"
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Cari template dokumen...">
                    </div>
                </div>
            </div>
            <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                <a href="<?php echo site_url('staff/template_dokumen/tambah'); ?>"
                   class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Tambah Template
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="p-4 bg-white dark:bg-gray-800">
    <form method="GET" action="<?php echo site_url('staff/template_dokumen'); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="jenis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Dokumen</label>
            <select id="jenis" name="jenis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Semua Jenis</option>
                <?php foreach ($jenis_dokumen as $jenis): ?>
                    <option value="<?php echo $jenis['id_jenis']; ?>" <?php echo $this->input->get('jenis') == $jenis['id_jenis'] ? 'selected' : ''; ?>>
                        <?php echo $jenis['nama_jenis']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="aktif" <?php echo $this->input->get('status') == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="nonaktif" <?php echo $this->input->get('status') == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
        </div>

        <div>
            <label for="dibuat_oleh" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dibuat Oleh</label>
            <select id="dibuat_oleh" name="dibuat_oleh" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Semua Staff</option>
                <option value="<?php echo $this->session->userdata('id_pengguna'); ?>" <?php echo $this->input->get('dibuat_oleh') == $this->session->userdata('id_pengguna') ? 'selected' : ''; ?>>Template Saya</option>
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="w-full px-3 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Filter
            </button>
        </div>
    </form>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success_message')): ?>
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <?php echo $this->session->flashdata('success_message'); ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error_message')): ?>
<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <?php echo $this->session->flashdata('error_message'); ?>
</div>
<?php endif; ?>

<!-- Template List -->
<div class="p-4">
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <?php if (!empty($template_dokumen)): ?>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Template</th>
                        <th scope="col" class="px-4 py-3">Jenis Dokumen</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3">Field</th>
                        <th scope="col" class="px-4 py-3">Submission</th>
                        <th scope="col" class="px-4 py-3">Dibuat</th>
                        <th scope="col" class="px-4 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($template_dokumen as $template): ?>
                    <tr class="border-b dark:border-gray-700">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div>
                                <div class="text-base font-semibold"><?php echo $template['nama_template']; ?></div>
                                <?php if ($template['deskripsi']): ?>
                                <div class="font-normal text-gray-500 text-sm"><?php echo (strlen($template['deskripsi']) > 50) ? substr($template['deskripsi'], 0, 50) . '...' : $template['deskripsi']; ?></div>
                                <?php endif; ?>
                            </div>
                        </th>
                        <td class="px-4 py-3"><?php echo $template['nama_jenis']; ?></td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php echo $template['status'] === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'; ?>">
                                <?php echo ucfirst($template['status']); ?>
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-500"><?php echo $template['jumlah_field']; ?> field</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-500"><?php echo $template['jumlah_submission']; ?> submission</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-900 dark:text-white"><?php echo $template['dibuat_oleh_nama']; ?></div>
                            <div class="text-sm text-gray-500"><?php echo date('d/m/Y H:i', strtotime($template['tanggal_dibuat'])); ?></div>
                        </td>
                        <td class="px-4 py-3 flex items-center justify-end">
                            <button id="dropdown-button-<?php echo $template['id_template']; ?>" data-dropdown-toggle="dropdown-<?php echo $template['id_template']; ?>"
                                    class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </button>
                            <div id="dropdown-<?php echo $template['id_template']; ?>" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                    <li>
                                        <a href="<?php echo site_url('staff/template_dokumen/detail/' . $template['id_template']); ?>"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detail</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('staff/template_dokumen/edit/' . $template['id_template']); ?>"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada template dokumen</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan membuat template dokumen pertama.</p>
                <div class="mt-6">
                    <a href="<?php echo site_url('staff/template_dokumen/tambah'); ?>"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Tambah Template
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pagination -->
    <?php if (!empty($pagination)): ?>
    <div class="mt-4">
        <?php echo $pagination; ?>
    </div>
    <?php endif; ?>
</div>

<script>
// Search functionality
document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const url = new URL(window.location);
        url.searchParams.set('search', this.value);
        window.location.href = url.toString();
    }
});
</script>
