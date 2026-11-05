<?php
namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

class AuthMiddleware implements MiddlewareInterface {
    public function handle(Request $request, callable $next) {
        // Ambil header Authorization dari getallheaders() jika ada, atau fallback ke $_SERVER
        $authHeader = '';
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
        }
        
        if (empty($authHeader)) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        }

        // Token rahasia sederhana untuk pengujian
        $expectedToken = 'Bearer secret-token-123';

        if ($authHeader !== $expectedToken) {
            Response::json([
                'success' => false,
                'message' => 'Unauthorized: Token API tidak valid atau tidak ditemukan'
            ], 401);
        }

        return $next($request);
    }
}