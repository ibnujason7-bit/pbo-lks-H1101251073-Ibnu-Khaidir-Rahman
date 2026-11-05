<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Env;
use App\Database\Connection;
use App\Repositories\MySQLBookRepository;
use App\Services\BookService;
use App\Controllers\BookController;
use App\Core\Container;
use App\Core\Router;
use App\Core\Request;

// Load Env & Connection
Env::load(__DIR__ . '/../.env');

// Setup Container (Dependency Injection)
$container = new Container();

$container->bind(PDO::class, function() {
    return Connection::get();
});

$container->bind(BookService::class, function($c) {
    $pdo = $c->make(PDO::class);
    $repo = new MySQLBookRepository($pdo);
    return new BookService($repo);
});

$container->bind(BookController::class, function($c) {
    return new BookController($c->make(BookService::class));
});

// Setup Router
$router = new Router();
$request = new Request();

$router->get('/api/books', function() use ($container) {
    $controller = $container->make(BookController::class);
    $controller->index();
});

$router->get('/api/books/{id}', function($id) use ($container) {
    $controller = $container->make(BookController::class);
    $controller->show($id);
});

$router->post('/api/books', function() use ($container, $request) {
    $controller = $container->make(BookController::class);
    $controller->store($request);
});

$router->put('/api/books/{id}', function($id) use ($container, $request) {
    $controller = $container->make(BookController::class);
    $controller->update($request, $id);
});

$router->delete('/api/books/{id}', function($id) use ($container) {
    $controller = $container->make(BookController::class);
    $controller->destroy($id);
});

// Dispatch Request
$router->dispatch($request);