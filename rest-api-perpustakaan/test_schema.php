<?php

// Load file Database atau composer jika ada
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (file_exists(__DIR__ . '/src/Config/Database.php')) {
    require_once __DIR__ . '/src/Config/Database.php';
}

try {
    // Gunakan App\Config\Database jika terbaca, atau fallback ke PDO langsung
    if (class_exists('App\Config\Database')) {
        $db = \App\Config\Database::getConnection();
    } else {
        // Sesuaikan nama db, user, dan password dengan database lokal kamu jika berbeda
        $host = '127.0.0.1';
        $dbname = 'db_perpustakaan';
        $user = 'root';
        $pass = '';
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    
    // 1. Buat tabel categories jika belum ada
    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_kategori VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $db->exec($sql);
    
    echo "=== STRUKTUR TABEL CATEGORIES ===\n\n";

    // 2. Ambil struktur tabel (DESCRIBE categories)
    $stmt = $db->query("DESCRIBE categories");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    printf("%-15s | %-20s | %-5s | %-5s\n", "Field", "Type", "Null", "Key");
    echo str_repeat("-", 50) . "\n";
    foreach ($columns as $col) {
        printf("%-15s | %-20s | %-5s | %-5s\n", $col['Field'], $col['Type'], $col['Null'], $col['Key']);
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}