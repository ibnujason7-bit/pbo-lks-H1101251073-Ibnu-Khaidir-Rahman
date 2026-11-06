<?php

namespace App\Middleware;

class CorsMiddleware {
    public static function handle(): void {
        // Izinkan semua origin (frontend) untuk mengakses API ini
        header("Access-Control-Allow-Origin: *");
        // Izinkan metode HTTP yang diperlukan
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        // Izinkan header tertentu
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        // Tangani request Preflight (OPTIONS) dari browser
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }
}