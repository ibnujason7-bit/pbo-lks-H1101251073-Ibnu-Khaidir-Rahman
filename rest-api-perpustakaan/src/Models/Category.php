<?php

namespace App\Models;

class Category {
    public ?int $id;
    public string $nama_kategori;
    public ?string $created_at;

    public function __construct(?int $id = null, string $nama_kategori = '', ?string $created_at = null) {
        $this->id = $id;
        $this->nama_kategori = $nama_kategori;
        $this->created_at = $created_at;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nama_kategori' => $this->nama_kategori,
            'created_at' => $this->created_at
        ];
    }
}