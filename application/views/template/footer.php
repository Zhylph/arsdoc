        <!-- End Content -->
    </div>
    <!-- End Content Wrapper -->
</div>
<!-- End Main Content Wrapper -->

    <!-- Footer -->
    <footer class="footer-fixed bg-white rounded-lg shadow m-4 dark:bg-gray-800">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                © 2024 <a href="#" class="hover:underline">Sistem Arsip Dokumen</a>. Semua hak dilindungi.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Tentang</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Kebijakan Privasi</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Lisensi</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Kontak</a>
                </li>
            </ul>
        </div>
    </footer>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

<!-- Custom Layout Script -->
<script>
// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('[data-drawer-toggle="logo-sidebar"]');
    const sidebar = document.getElementById('logo-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function openSidebar() {
        if (window.innerWidth < 640) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('show');
            overlay.classList.add('show');
        }
    }

    function closeSidebar() {
        if (window.innerWidth < 640) {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }
    }

    // Toggle sidebar when button clicked
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });
    }

    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            closeSidebar();
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 640) {
            const isClickInsideSidebar = sidebar && sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle && sidebarToggle.contains(event.target);
            const isClickOnOverlay = overlay && overlay.contains(event.target);

            if (!isClickInsideSidebar && !isClickOnToggle && !isClickOnOverlay && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 640) {
            // Desktop: show sidebar, hide overlay
            sidebar.classList.remove('show');
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('show');
        } else {
            // Mobile: hide sidebar by default
            if (!sidebar.classList.contains('show')) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('show');
            }
        }
    });

    // Initialize sidebar state
    if (window.innerWidth < 640) {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('show');
    } else {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }
});
</script>

    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('alert-auto-hide')) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            });
        }, 5000);

        // Confirm delete actions
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus item ini?') {
            return confirm(message);
        }

        // Show loading spinner on form submit
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
                    }
                });
            });
        });

        // File upload preview
        function previewFile(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        preview.innerHTML = '<img src="' + e.target.result + '" class="max-w-full h-auto rounded-lg" alt="Preview">';
                    } else {
                        preview.innerHTML = '<div class="p-4 bg-gray-100 rounded-lg"><i class="fas fa-file text-4xl text-gray-500 mb-2"></i><p class="text-sm text-gray-600">' + file.name + '</p></div>';
                    }
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        }

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Copy to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                toast.textContent = 'Berhasil disalin ke clipboard!';
                document.body.appendChild(toast);

                setTimeout(function() {
                    toast.remove();
                }, 3000);
            });
        }
    </script>

    <!-- Additional custom scripts can be added here -->
    <?php if (isset($additional_js)): ?>
        <?php echo $additional_js; ?>
    <?php endif; ?>

</body>
</html>
