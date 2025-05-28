<?php
/**
 * Script untuk setup database sistem arsip dokumen
 * Jalankan file ini sekali untuk membuat database dan tabel
 */

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sistem_arsip_dokumen';

try {
    // Koneksi ke MySQL tanpa database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Setup Database Sistem Arsip Dokumen</h2>";
    echo "<p>Memulai proses setup database...</p>";
    
    // Baca file SQL
    $sql_file = __DIR__ . '/database_setup.sql';
    if (!file_exists($sql_file)) {
        throw new Exception("File database_setup.sql tidak ditemukan!");
    }
    
    $sql_content = file_get_contents($sql_file);
    
    // Pisahkan query berdasarkan semicolon
    $queries = explode(';', $sql_content);
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (empty($query)) continue;
        
        try {
            $pdo->exec($query);
            $success_count++;
            
            // Tampilkan info untuk query penting
            if (strpos($query, 'CREATE DATABASE') !== false) {
                echo "<p style='color: green;'>✓ Database '$database' berhasil dibuat</p>";
            } elseif (strpos($query, 'CREATE TABLE') !== false) {
                preg_match('/CREATE TABLE\s+(\w+)/', $query, $matches);
                if (isset($matches[1])) {
                    echo "<p style='color: green;'>✓ Tabel '{$matches[1]}' berhasil dibuat</p>";
                }
            } elseif (strpos($query, 'INSERT INTO') !== false) {
                preg_match('/INSERT INTO\s+(\w+)/', $query, $matches);
                if (isset($matches[1])) {
                    echo "<p style='color: blue;'>✓ Data sample berhasil dimasukkan ke tabel '{$matches[1]}'</p>";
                }
            }
            
        } catch (PDOException $e) {
            $error_count++;
            echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
            echo "<p style='color: gray;'>Query: " . substr($query, 0, 100) . "...</p>";
        }
    }
    
    echo "<hr>";
    echo "<h3>Hasil Setup:</h3>";
    echo "<p><strong>Query berhasil:</strong> $success_count</p>";
    echo "<p><strong>Query error:</strong> $error_count</p>";
    
    if ($error_count == 0) {
        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4>✓ Setup Database Berhasil!</h4>";
        echo "<p>Database dan semua tabel telah berhasil dibuat. Anda dapat mulai menggunakan sistem dengan akun berikut:</p>";
        echo "<ul>";
        echo "<li><strong>Admin:</strong> admin@arsdoc.com / password</li>";
        echo "<li><strong>Staff:</strong> staff@arsdoc.com / password</li>";
        echo "<li><strong>User:</strong> user@arsdoc.com / password</li>";
        echo "</ul>";
        echo "<p><a href='" . dirname($_SERVER['PHP_SELF']) . "' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Mulai Menggunakan Sistem</a></p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4>⚠ Setup Database Tidak Sempurna</h4>";
        echo "<p>Terdapat beberapa error dalam proses setup. Silakan periksa konfigurasi database dan coba lagi.</p>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>✗ Error Setup Database</h4>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Pastikan:</p>";
    echo "<ul>";
    echo "<li>MySQL server sudah berjalan</li>";
    echo "<li>Username dan password database benar</li>";
    echo "<li>User memiliki privilege untuk membuat database</li>";
    echo "</ul>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Database - Sistem Arsip Dokumen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .info {
            background: #e7f3ff;
            border: 1px solid #b8daff;
            color: #004085;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!isset($pdo)): ?>
        <h2>Setup Database Sistem Arsip Dokumen</h2>
        <div class="info">
            <h4>Informasi Setup</h4>
            <p>Script ini akan membuat database dan tabel yang diperlukan untuk sistem arsip dokumen.</p>
            <p><strong>Pastikan:</strong></p>
            <ul>
                <li>XAMPP/MySQL server sudah berjalan</li>
                <li>Anda memiliki akses ke MySQL dengan user 'root'</li>
                <li>Port MySQL default (3306) tidak diblokir</li>
            </ul>
            <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?run=1" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Jalankan Setup Database</a></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Jalankan setup jika parameter run=1
if (isset($_GET['run']) && $_GET['run'] == '1' && !isset($pdo)) {
    echo "<script>window.location.reload();</script>";
}
?>
