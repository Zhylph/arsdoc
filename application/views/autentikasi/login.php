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
                <img src="<?php echo base_url('assets/LogoIT.png'); ?>" alt="Logo IT" class="w-24 h-24">
            </div>
            <br>
            <div class="text-center -mt-2">
                <div class="text-3xl font-extrabold tracking-tight text-white">SIMPAZ</div>
                <div class="text-sm font-medium text-gray-300 mt-1">Sistem Informasi Manajemen Pengarsipan Abdul Aziz</div>
            </div>
        </div>
        
        <!-- Form Login -->
        <div class="w-full max-w-md slide-in stagger-2">
            <div class="glass-effect rounded-3xl shadow-2xl p-8 space-y-6">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Selamat Datang
                    </h1>
                    <p class="text-gray-300">
                        Masuk ke akun Anda untuk melanjutkan
                    </p>
                </div>
                  <!-- Pesan Error -->
                <?php if (!empty($error_message)): ?>
                <div class="flex items-center p-4 text-sm text-red-300 border border-red-500/30 rounded-xl bg-red-900/20 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div><?php echo $error_message; ?></div>
                </div>
                <?php endif; ?>

                <!-- Pesan Sukses -->
                <?php if ($this->session->flashdata('success_message')): ?>
                <div class="flex items-center p-4 text-sm text-green-300 border border-green-500/30 rounded-xl bg-green-900/20 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM13.5 6a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM10 15a1 1 0 0 1-1-1v-3a1 1 0 012 0v3a1 1 0 01-1 1Z"/>
                    </svg>
                    <div><?php echo $this->session->flashdata('success_message'); ?></div>
                </div>
                <?php endif; ?>
                  <!-- Form -->
                <form class="space-y-6" action="<?php echo site_url('autentikasi/login'); ?>" method="post">
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-semibold text-gray-200">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" 
                                       class="input-glow bg-gray-800/50 border border-gray-600 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-3 placeholder-gray-400 backdrop-blur-sm transition-all duration-300" 
                                       placeholder="nama@email.com" 
                                       value="<?php echo set_value('email'); ?>" 
                                       required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="password" class="block mb-2 text-sm font-semibold text-gray-200">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password" 
                                       placeholder="••••••••" 
                                       class="input-glow bg-gray-800/50 border border-gray-600 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-3 placeholder-gray-400 backdrop-blur-sm transition-all duration-300" 
                                       required>
                                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3" onclick="togglePassword()">
                                    <svg id="eye-icon" class="w-5 h-5 text-gray-400 hover:text-gray-600 cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" 
                                   class="w-4 h-4 text-indigo-600 bg-gray-700 border-gray-600 rounded focus:ring-indigo-500 focus:ring-2">
                            <label for="remember" class="ml-2 text-sm font-medium text-gray-300">Ingat saya</label>
                        </div>
                        <!-- <a href="#" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Lupa password?</a> -->
                    </div>
                    
                    <button type="submit" 
                            class="btn-hover w-full text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-semibold rounded-xl text-sm px-5 py-3 text-center transition-all duration-300">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk
                        </span>
                    </button>
                    
                    <div class="text-center">
                        <p class="text-sm text-gray-400">
                            Belum punya akun? 
                            <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Daftar di sini</a>
                        </p>
                    </div>
                </form>
                
                <!-- Demo Accounts Info -->
                <div class="mt-6 p-4 bg-gradient-to-r from-indigo-900/20 to-purple-900/20 border border-indigo-700/30 rounded-xl backdrop-blur-sm">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-indigo-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="text-sm font-semibold text-indigo-300">Butuh Bantuan?</h3>
                    </div>
                    <p class="text-xs text-gray-300">
                        Silakan hubungi IT jika mengalami kendala saat login atau membutuhkan bantuan teknis lainnya.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3.05 3.05m6.827 6.828L16.95 16.95"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>';
            }
        }
        
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;
            
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;
        });
    </script>
</body>
</html>
