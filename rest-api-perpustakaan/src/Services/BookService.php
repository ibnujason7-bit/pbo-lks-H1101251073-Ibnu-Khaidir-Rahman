<?php
namespace App\Services;

use App\Contracts\BookRepositoryInterface;
use Exception;

class BookService {
    private $repository;

    public function __construct(BookRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function list() {
        return $this->repository->findAll();
    }

    public function getById($id) {
        $book = $this->repository->findById($id);
        if (!$book) {
            throw new Exception("Buku dengan ID {$id} tidak ditemukan");
        }
        return $book;
    }

    public function create(array $data) {
        if (empty($data['judul'])) {
            throw new Exception("Judul wajib diisi");
        }
        if (empty($data['penulis'])) {
            throw new Exception("Penulis wajib diisi");
        }

        $id = $this->repository->create($data);
        return array_merge(['id' => $id], $data);
    }

    public function update($id, array $data) {
        $this->getById($id); // Validasi keberadaan buku

        if (empty($data['judul'])) {
            throw new Exception("Judul wajib diisi");
        }

        $this->repository->update($id, $data);
        return array_merge(['id' => $id], $data);
    }

    public function delete($id) {
        $this->getById($id); // Validasi keberadaan buku
        return $this->repository->delete($id);
    }
}