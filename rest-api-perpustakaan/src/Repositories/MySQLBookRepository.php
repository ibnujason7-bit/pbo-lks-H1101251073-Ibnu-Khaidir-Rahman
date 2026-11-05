<?php
namespace App\Repositories;

use PDO;
use App\Contracts\BookRepositoryInterface;
use App\Models\Book;

class MySQLBookRepository implements BookRepositoryInterface {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM books");
        $rows = $stmt->fetchAll();
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book(
                $row['id'],
                $row['title'] ?? $row['judul'] ?? '',
                $row['author'] ?? $row['penulis'] ?? '',
                $row['published_year'] ?? $row['tahun'] ?? 0,
                $row['stok'] ?? 0
            );
        }
        return $books;
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;

        return new Book(
            $row['id'],
            $row['title'] ?? $row['judul'] ?? '',
            $row['author'] ?? $row['penulis'] ?? '',
            $row['published_year'] ?? $row['tahun'] ?? 0,
            $row['stok'] ?? 0
        );
    }

    public function create(array $data) {
        $stmt = $this->pdo->prepare("INSERT INTO books (title, author, published_year) VALUES (?, ?, ?)");
        $stmt->execute([$data['judul'], $data['penulis'], $data['tahun']]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, array $data) {
        $stmt = $this->pdo->prepare("UPDATE books SET title = ?, author = ?, published_year = ? WHERE id = ?");
        return $stmt->execute([$data['judul'], $data['penulis'], $data['tahun'], $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }
}