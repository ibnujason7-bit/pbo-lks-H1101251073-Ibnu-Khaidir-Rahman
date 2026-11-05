<?php
namespace App\Controllers;

use App\Services\BookService;
use App\Core\Request;
use App\Core\Response;
use Exception;

class BookController {
    private $service;

    public function __construct(BookService $service) {
        $this->service = $service;
    }

    public function index() {
        $books = $this->service->list();
        $data = array_map(fn($book) => $book->toArray(), $books);

        Response::json([
            'success' => true,
            'message' => 'Daftar buku',
            'data' => $data
        ], 200);
    }

    public function show($id) {
        try {
            $book = $this->service->getById($id);
            Response::json([
                'success' => true,
                'message' => 'Detail buku',
                'data' => $book->toArray()
            ], 200);
        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request) {
        try {
            $book = $this->service->create($request->getBody());
            Response::json([
                'success' => true,
                'message' => 'Buku berhasil dibuat',
                'data' => $book
            ], 201);
        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            $book = $this->service->update($id, $request->getBody());
            Response::json([
                'success' => true,
                'message' => 'Buku berhasil diperbarui',
                'data' => $book
            ], 200);
        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy($id) {
        try {
            $this->service->delete($id);
            Response::json([
                'success' => true,
                'message' => 'Buku berhasil dihapus'
            ], 200);
        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}