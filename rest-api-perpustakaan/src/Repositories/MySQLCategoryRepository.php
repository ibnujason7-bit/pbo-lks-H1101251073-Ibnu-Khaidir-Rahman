<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use PDO;

class MySQLCategoryRepository implements CategoryRepositoryInterface {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("INSERT INTO categories (nama_kategori) VALUES (?)");
        $stmt->execute([$data['nama_kategori']]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE categories SET nama_kategori = ? WHERE id = ?");
        return $stmt->execute([$data['nama_kategori'], $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}