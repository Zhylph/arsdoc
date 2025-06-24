<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Sistem Arsip Dokumen'; ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Dark Theme CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dark-theme.css') ?>">
    <link rel="icon" href="<?= base_url('assets/Logo.ico'); ?>" type="image/x-icon">

    <!-- Custom CSS -->
    <style>
        .sidebar-transition {
            transition: margin-left 0.3s ease-in-out;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .text-shadow {
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Force dark mode */
        html {
            color-scheme: dark;
        }
    </style>

    <!-- Dark Mode Script -->
    <script>
        // Force dark mode
        document.documentElement.classList.add('dark');

        // Tailwind config for dark mode
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

<!-- Navbar -->
<nav class="navbar-fixed w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-5 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <!-- Sidebar Toggle Button -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="<?php echo site_url(); ?>" class="flex ml-2 md:mr-24">
                    <img src="<?php echo base_url('assets/LogoIT.png'); ?>" alt="Logo IT" class="w-8 h-8 mr-2">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">SIMPAZ</span>
                </a>
            </div>

            <!-- User Menu -->
            <div class="flex items-center">
                <div class="flex items-center ml-3">
                    <!-- Notifications -->
                    <button type="button"
                            class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">Lihat notifikasi</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                            <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"/>
                        </svg>
                    </button>

                    <!-- User Dropdown -->
                    <div>
                        <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false"
                                data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Buka menu pengguna</span>
                            <?php if ($this->session->userdata('foto_profil')): ?>
                                <img class="w-8 h-8 rounded-full" src="<?php echo base_url('uploads/profil/' . $this->session->userdata('foto_profil')); ?>" alt="Foto profil">
                            <?php else: ?>
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        <?php echo strtoupper(substr($this->session->userdata('nama_lengkap'), 0, 1)); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </button>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                <?php echo $this->session->userdata('nama_lengkap'); ?>
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                <?php echo $this->session->userdata('email'); ?>
                            </p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 mt-1">
                                <?php echo ucfirst($this->session->userdata('role')); ?>
                            </span>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <i class="fas fa-cog mr-2"></i>Pengaturan
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('autentikasi/logout'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar Overlay for Mobile -->
<div id="sidebar-overlay" class="sidebar-overlay"></div>

<!-- Main Content Wrapper -->
<div class="main-content-wrapper p-4">
    <div class="content-area">
        <!-- Content will be loaded here -->
