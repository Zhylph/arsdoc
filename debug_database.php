<?php
/**
 * Script untuk debugging masalah database
 * Jalankan file ini untuk memeriksa status database dan tabel
 */

// Konfigurasi database (sesuaikan dengan config CodeIgniter)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sistem_arsip_dokumen';

echo "<h2>Debug Database Sistem Arsip Dokumen</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
    .info { color: blue; }
    table { border-collapse: collapse; width: 100%; margin: 10px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
</style>";

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p class='success'>✓ Koneksi database berhasil</p>";
    
    // Cek apakah tabel pengguna ada
    echo "<h3>1. Cek Tabel Pengguna</h3>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'pengguna'");
    if ($stmt->rowCount() > 0) {
        echo "<p class='success'>✓ Tabel 'pengguna' ditemukan</p>";
        
        // Cek struktur tabel pengguna
        $stmt = $pdo->query("DESCRIBE pengguna");
        echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
        // Cek jumlah pengguna
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM pengguna");
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        echo "<p class='info'>Total pengguna: $total</p>";
        
    } else {
        echo "<p class='error'>✗ Tabel 'pengguna' tidak ditemukan</p>";
    }
    
    // Cek apakah tabel folder_pribadi ada
    echo "<h3>2. Cek Tabel Folder Pribadi</h3>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'folder_pribadi'");
    if ($stmt->rowCount() > 0) {
        echo "<p class='success'>✓ Tabel 'folder_pribadi' ditemukan</p>";
        
        // Cek struktur tabel folder_pribadi
        $stmt = $pdo->query("DESCRIBE folder_pribadi");
        echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
        // Cek foreign key constraints
        echo "<h4>Foreign Key Constraints:</h4>";
        $stmt = $pdo->query("
            SELECT 
                CONSTRAINT_NAME,
                COLUMN_NAME,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = '$database' 
            AND TABLE_NAME = 'folder_pribadi' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        if ($stmt->rowCount() > 0) {
            echo "<table><tr><th>Constraint</th><th>Column</th><th>Referenced Table</th><th>Referenced Column</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='warning'>⚠ Tidak ada foreign key constraints ditemukan</p>";
        }
        
        // Cek jumlah folder
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM folder_pribadi");
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        echo "<p class='info'>Total folder: $total</p>";
        
    } else {
        echo "<p class='error'>✗ Tabel 'folder_pribadi' tidak ditemukan</p>";
        echo "<p class='info'>Mencoba membuat tabel...</p>";
        
        // Coba buat tabel folder_pribadi
        $sql = "
            CREATE TABLE `folder_pribadi` (
                `id_folder` int(11) NOT NULL AUTO_INCREMENT,
                `id_pengguna` int(11) NOT NULL,
                `id_parent` int(11) DEFAULT NULL,
                `nama_folder` varchar(255) NOT NULL,
                `deskripsi` text,
                `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id_folder`),
                KEY `id_pengguna` (`id_pengguna`),
                KEY `id_parent` (`id_parent`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        
        try {
            $pdo->exec($sql);
            echo "<p class='success'>✓ Tabel 'folder_pribadi' berhasil dibuat</p>";
            
            // Tambahkan foreign key constraints
            try {
                $pdo->exec("ALTER TABLE `folder_pribadi` ADD CONSTRAINT `fk_folder_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE");
                echo "<p class='success'>✓ Foreign key constraint untuk pengguna berhasil ditambahkan</p>";
            } catch (Exception $e) {
                echo "<p class='warning'>⚠ Gagal menambah foreign key constraint untuk pengguna: " . $e->getMessage() . "</p>";
            }
            
            try {
                $pdo->exec("ALTER TABLE `folder_pribadi` ADD CONSTRAINT `fk_folder_parent` FOREIGN KEY (`id_parent`) REFERENCES `folder_pribadi` (`id_folder`) ON DELETE CASCADE");
                echo "<p class='success'>✓ Foreign key constraint untuk parent folder berhasil ditambahkan</p>";
            } catch (Exception $e) {
                echo "<p class='warning'>⚠ Gagal menambah foreign key constraint untuk parent folder: " . $e->getMessage() . "</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>✗ Gagal membuat tabel 'folder_pribadi': " . $e->getMessage() . "</p>";
        }
    }
    
    // Test insert folder
    echo "<h3>3. Test Insert Folder</h3>";
    
    // Ambil user pertama untuk test
    $stmt = $pdo->query("SELECT id_pengguna FROM pengguna LIMIT 1");
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_pengguna = $user['id_pengguna'];
        
        echo "<p class='info'>Menggunakan ID pengguna: $id_pengguna untuk test</p>";
        
        // Coba insert folder test
        try {
            $stmt = $pdo->prepare("
                INSERT INTO folder_pribadi (id_pengguna, nama_folder, deskripsi, tanggal_dibuat) 
                VALUES (?, ?, ?, NOW())
            ");
            $result = $stmt->execute([$id_pengguna, 'Test Folder Debug', 'Folder untuk testing debug']);
            
            if ($result) {
                $folder_id = $pdo->lastInsertId();
                echo "<p class='success'>✓ Test insert folder berhasil (ID: $folder_id)</p>";
                
                // Hapus folder test
                $stmt = $pdo->prepare("DELETE FROM folder_pribadi WHERE id_folder = ?");
                $stmt->execute([$folder_id]);
                echo "<p class='info'>Test folder berhasil dihapus</p>";
            } else {
                echo "<p class='error'>✗ Test insert folder gagal</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>✗ Error saat test insert: " . $e->getMessage() . "</p>";
        }
        
    } else {
        echo "<p class='warning'>⚠ Tidak ada pengguna ditemukan untuk test insert</p>";
    }
    
    // Cek log error PHP
    echo "<h3>4. Informasi PHP</h3>";
    echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
    echo "<p><strong>Error Reporting:</strong> " . error_reporting() . "</p>";
    echo "<p><strong>Display Errors:</strong> " . (ini_get('display_errors') ? 'On' : 'Off') . "</p>";
    echo "<p><strong>Log Errors:</strong> " . (ini_get('log_errors') ? 'On' : 'Off') . "</p>";
    echo "<p><strong>Error Log:</strong> " . ini_get('error_log') . "</p>";
    
    echo "<h3>5. Rekomendasi</h3>";
    echo "<ul>";
    echo "<li>Pastikan semua tabel sudah dibuat dengan benar</li>";
    echo "<li>Periksa log error CodeIgniter di <code>application/logs/</code></li>";
    echo "<li>Pastikan user sudah login dengan benar</li>";
    echo "<li>Buka Developer Tools di browser untuk melihat error JavaScript</li>";
    echo "<li>Periksa Network tab untuk melihat response dari server</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Error koneksi database: " . $e->getMessage() . "</p>";
    echo "<p class='info'>Pastikan:</p>";
    echo "<ul>";
    echo "<li>MySQL server berjalan</li>";
    echo "<li>Database '$database' sudah dibuat</li>";
    echo "<li>Username dan password database benar</li>";
    echo "<li>Host database benar</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><em>Debug selesai pada " . date('Y-m-d H:i:s') . "</em></p>";
?>
