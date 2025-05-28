<?php
/**
 * Test file untuk mengecek apakah mod_rewrite aktif
 */

echo "<h2>Test Mod Rewrite</h2>";

// Cek apakah mod_rewrite aktif
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p style='color: green;'>✓ mod_rewrite AKTIF</p>";
    } else {
        echo "<p style='color: red;'>✗ mod_rewrite TIDAK AKTIF</p>";
        echo "<p>Silakan aktifkan mod_rewrite di Apache:</p>";
        echo "<ol>";
        echo "<li>Buka XAMPP Control Panel</li>";
        echo "<li>Klik 'Config' pada Apache</li>";
        echo "<li>Pilih 'PHP (php.ini)'</li>";
        echo "<li>Cari baris: <code>#LoadModule rewrite_module modules/mod_rewrite.so</code></li>";
        echo "<li>Hapus tanda # di depannya</li>";
        echo "<li>Restart Apache</li>";
        echo "</ol>";
    }
} else {
    echo "<p style='color: orange;'>⚠ Tidak dapat mendeteksi mod_rewrite (mungkin tidak menggunakan Apache)</p>";
}

// Cek file .htaccess
if (file_exists('.htaccess')) {
    echo "<p style='color: green;'>✓ File .htaccess ditemukan</p>";
} else {
    echo "<p style='color: red;'>✗ File .htaccess tidak ditemukan</p>";
}

// Cek konfigurasi CodeIgniter
$config_file = 'application/config/config.php';
if (file_exists($config_file)) {
    $config_content = file_get_contents($config_file);
    if (strpos($config_content, "\$config['index_page'] = '';") !== false) {
        echo "<p style='color: green;'>✓ Konfigurasi CodeIgniter sudah benar (index_page = '')</p>";
    } else {
        echo "<p style='color: red;'>✗ Konfigurasi CodeIgniter belum benar</p>";
    }
} else {
    echo "<p style='color: red;'>✗ File konfigurasi CodeIgniter tidak ditemukan</p>";
}

echo "<hr>";
echo "<h3>Test URL:</h3>";
echo "<p>Jika mod_rewrite aktif, URL berikut harus berfungsi:</p>";
echo "<ul>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/admin/dashboard'>Admin Dashboard</a></li>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/staff/dashboard'>Staff Dashboard</a></li>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/user/dashboard'>User Dashboard</a></li>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/login'>Login</a></li>";
echo "</ul>";

echo "<p>Jika tidak berfungsi, gunakan URL dengan index.php:</p>";
echo "<ul>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/index.php/admin/dashboard'>Admin Dashboard (dengan index.php)</a></li>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/index.php/staff/dashboard'>Staff Dashboard (dengan index.php)</a></li>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/index.php/user/dashboard'>User Dashboard (dengan index.php)</a></li>";
echo "<li><a href='" . dirname($_SERVER['PHP_SELF']) . "/index.php/login'>Login (dengan index.php)</a></li>";
echo "</ul>";

echo "<hr>";
echo "<h3>Cara Mengaktifkan mod_rewrite di XAMPP:</h3>";
echo "<ol>";
echo "<li><strong>Buka XAMPP Control Panel</strong></li>";
echo "<li><strong>Stop Apache</strong> jika sedang berjalan</li>";
echo "<li><strong>Klik 'Config' pada Apache</strong> → Pilih 'Apache (httpd.conf)'</li>";
echo "<li><strong>Cari baris:</strong> <code>#LoadModule rewrite_module modules/mod_rewrite.so</code></li>";
echo "<li><strong>Hapus tanda #</strong> sehingga menjadi: <code>LoadModule rewrite_module modules/mod_rewrite.so</code></li>";
echo "<li><strong>Cari bagian:</strong> <code>&lt;Directory \"C:/xampp/htdocs\"&gt;</code></li>";
echo "<li><strong>Ubah:</strong> <code>AllowOverride None</code> menjadi <code>AllowOverride All</code></li>";
echo "<li><strong>Save file</strong> dan <strong>restart Apache</strong></li>";
echo "</ol>";

echo "<p><a href='" . dirname($_SERVER['PHP_SELF']) . "/' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Kembali ke Sistem</a></p>";
?>
