<?php
namespace App\Core;

class Request {
    public function getUri() {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }
        return $uri;
    }

    public function getMethod() {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function getBody() {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data ?? $_POST ?? [];
    }
}