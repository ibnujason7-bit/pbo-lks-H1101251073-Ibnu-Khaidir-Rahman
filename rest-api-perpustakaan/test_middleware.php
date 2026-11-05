<?php
require 'vendor/autoload.php';

use App\Core\Request;
use App\Middleware\AuthMiddleware;
use App\Middleware\LogMiddleware;

// Simulasi Request
$_SERVER['REQUEST_URI'] = '/api/books';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_AUTHORIZATION'] = 'Bearer secret-token-123';

$request = new Request();
$logMiddleware = new LogMiddleware();
$authMiddleware = new AuthMiddleware();

// Test eksekusi middleware chain
$result = $logMiddleware->handle($request, function($req) use ($authMiddleware) {
    return $authMiddleware->handle($req, function($r) {
        echo "✅ Middleware passed! Access granted to " . $r->getUri() . PHP_EOL;
    });
});