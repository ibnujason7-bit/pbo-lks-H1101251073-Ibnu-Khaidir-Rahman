<?php
namespace App\Database;

use PDO;
use PDOException;
use App\Config\Env; // Tambahkan ini agar Env bisa dibaca

class Connection {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = Env::get('DB_HOST');
        $db   = Env::get('DB_DATABASE');
        $user = Env::get('DB_USERNAME');
        $pass = Env::get('DB_PASSWORD');

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Koneksi Database Gagal: " . $e->getMessage());
        }
    }

    // INI ADALAH FUNGSI get() YANG SEBELUMNYA HILANG
    public static function get() {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance->pdo;
    }
}