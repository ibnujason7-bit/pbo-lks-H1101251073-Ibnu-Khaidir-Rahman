<?php
// File: src/Env.php
namespace App\Config;

class Env {
    public static function load($path) {
        if (!file_exists($path)) {
            die("File .env tidak ditemukan di: " . $path);
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $_ENV[trim($name)] = trim($value);
            }
        }
    }

    public static function get($key, $default = '') {
        return $_ENV[$key] ?? $default;
    }
}