<?php

namespace App\Controllers;

use App\Services\CategoryService;
use InvalidArgumentException;

class CategoryController {
    private CategoryService $service;

    public function __construct(CategoryService $service) {
        $this->service = $service;
    }

    public function index(): void {
    $categories = $this->service->getAllCategories();
    $this->jsonResponse([
        "success" => true, 
        "message" => "Daftar kategori", 
        "data" => $categories]);
    }

    public function show(int $id): void {
        $category = $this->service->getCategoryById($id);
        if (!$category) {
            $this->jsonResponse(["success" => false, "message" => "Kategori tidak ditemukan"], 404);
            return;
        }
        $this->jsonResponse(["success" => true, "data" => $category]);
    }

    public function store(): void {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        try {
            $id = $this->service->createCategory($input);
            $this->jsonResponse([
                "success" => true, 
                "data" => [
                    "id" => $id, 
                    "nama_kategori" => $input['nama_kategori'] ?? ''
                ]
            ], 201);
        // Pada fungsi store() dan update(), ubah 400 menjadi 422:
        } catch (InvalidArgumentException $e) {
            $this->jsonResponse(["success" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function update(int $id): void {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        try {
            $updated = $this->service->updateCategory($id, $input);
            if (!$updated) {
                $this->jsonResponse(["success" => false, "message" => "Kategori gagal diperbarui"], 400);
                return;
            }
            $this->jsonResponse(["success" => true, "message" => "Kategori berhasil diperbarui"]);
        // Pada fungsi store() dan update(), ubah 400 menjadi 422:
        } catch (InvalidArgumentException $e) {
            $this->jsonResponse(["success" => false, "message" => $e->getMessage()], 422);
        }
    }

    public function destroy(int $id): void {
        $deleted = $this->service->deleteCategory($id);
        if (!$deleted) {
            $this->jsonResponse(["success" => false, "message" => "Kategori tidak ditemukan"], 404);
            return;
        }
        $this->jsonResponse(["success" => true, "message" => "Kategori berhasil dihapus"]);
    }

    private function jsonResponse(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}