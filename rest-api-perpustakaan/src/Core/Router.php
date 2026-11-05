<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, $handler) {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, $handler) {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $path);
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'pattern' => "#^" . $pattern . "$#",
            'handler' => $handler
        ];
    }

    public function dispatch(Request $request) {
        $method = $request->getMethod();
        $uri = $request->getUri();

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($route['handler'], $matches);
            }
        }

        Response::json([
            'success' => false,
            'message' => "Endpoint tidak ditemukan: {$uri}"
        ], 404);
    }
}