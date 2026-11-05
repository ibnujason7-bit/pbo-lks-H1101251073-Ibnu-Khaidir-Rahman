<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use InvalidArgumentException;

class CategoryService {
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getAllCategories(): array {
        return $this->repository->getAll();
    }

    public function getCategoryById(int $id): ?array {
        return $this->repository->getById($id);
    }

    public function createCategory(array $data): int {
        if (empty($data['nama_kategori'])) {
            throw new InvalidArgumentException("Nama kategori wajib diisi");
        }
        return $this->repository->create($data);
    }

    public function updateCategory(int $id, array $data): bool {
        if (empty($data['nama_kategori'])) {
            throw new InvalidArgumentException("Nama kategori wajib diisi");
        }
        return $this->repository->update($id, $data);
    }

    public function deleteCategory(int $id): bool {
        return $this->repository->delete($id);
    }
}