<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Masuk - SIMPAZ'; ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" href="<?= base_url('assets/Logo.ico'); ?>" type="image/x-icon">

    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-gradient-aurora {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 25%, #16213e 50%, #0f3460 75%, #533483 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .shape {
            position: absolute;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
            border: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            left: 20%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 70%;
            animation-delay: 4s;
        }
        
        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            left: 80%;
            animation-delay: 6s;
        }
        
        .shape:nth-child(5) {
            width: 90px;
            height: 90px;
            left: 50%;
            animation-delay: 8s;
        }
        
        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        .glass-effect {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(75, 85, 99, 0.3);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
        }
        
        .input-glow:focus {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
        
        .btn-hover {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
        }
        
        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-hover:hover::before {
            left: 100%;
        }
        
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .slide-in {
            animation: slideIn 0.6s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(79, 70, 229, 0.8);
            border-radius: 50%;
            animation: particleFloat 15s infinite linear;
            box-shadow: 0 0 6px rgba(79, 70, 229, 0.5);
        }
        
        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10px) translateX(100px);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-aurora relative overflow-hidden">
  
    
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto min-h-screen relative z-10">
        <!-- Logo dan Judul -->
        <div class="flex flex-col items-center mb-8 text-2xl font-bold text-white fade-in stagger-1">
            <div class=" border-indigo-400/30">
                <img src="<?php echo base_url('assets/LogoRS.png'); ?>" alt="Logo IT" class="w-24 h-24">
            </div>
            <br>
            <div class="text-center -mt-2">
                <div class="text-3xl font-extrabold tracking-tight text-white">SIMPAZ</div>
                <div class="text-sm font-medium text-gray-300 mt-1">Sistem Informasi Manajemen Pengarsipan Abdul Aziz</div>
            </div>
        </div>
        
        <!-- Form Registrasi -->
        <div class="w-full max-w-md slide-in stagger-2">
            <div class="glass-effect rounded-3xl shadow-2xl p-8 space-y-6">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Buat Akun Baru
                    </h1>
                </div>
                <!-- Pesan Error -->
                <?php if (!empty($error_message)): ?>
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div><?php echo $error_message; ?></div>
                </div>
                <?php endif; ?>
                
                <!-- Form -->
                <form class="space-y-4 md:space-y-6" action="<?php echo site_url('autentikasi/registrasi'); ?>" method="post">
                    <div>
                        <label for="nama_lengkap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                               placeholder="Masukkan nama lengkap Anda" 
                               value="<?php echo set_value('nama_lengkap'); ?>" 
                               required>
                    </div>
                    
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                               placeholder="nama@email.com" 
                               value="<?php echo set_value('email'); ?>" 
                               required>
                    </div>
                    
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" 
                               placeholder="••••••••" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                               required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimal 6 karakter</p>
                    </div>
                    
                    <div>
                        <label for="konfirmasi_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" 
                               placeholder="••••••••" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                               required>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" aria-describedby="terms" type="checkbox" 
                                   class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" 
                                   required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-light text-gray-500 dark:text-gray-300">
                                Saya menyetujui <a class="font-medium text-blue-600 hover:underline dark:text-blue-500" href="#">Syarat dan Ketentuan</a>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" 
                    class="btn-hover w-full text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-semibold rounded-xl text-sm px-5 py-3 text-center transition-all duration-300">
                    <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Buat Akun
                        </span>
                    </button>
                    
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Sudah punya akun? 
                        <a href="<?php echo site_url('autentikasi/login'); ?>" 
                           class="font-medium text-blue-600 hover:underline dark:text-blue-500">Masuk di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>
