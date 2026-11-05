<?php
namespace App\Middleware;

use App\Core\Request;

class LogMiddleware implements MiddlewareInterface {
    public function handle(Request $request, callable $next) {
        $logMessage = sprintf(
            "[%s] %s %s" . PHP_EOL,
            date('Y-m-d H:i:s'),
            $request->getMethod(),
            $request->getUri()
        );

        // Simpan log ke file app.log
        file_put_contents(__DIR__ . '/../../app.log', $logMessage, FILE_APPEND);

        return $next($request);
    }
}