<?php
namespace App\Models;

class Book {
    private $id;
    private $judul;
    private $penulis;
    private $tahun;
    private $stok;

    public function __construct($id, $judul, $penulis, $tahun, $stok = 0) {
        $this->id = $id;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahun = $tahun;
        $this->stok = $stok;
    }

    public function getId() { return $this->id; }
    public function getJudul() { return $this->judul; }
    public function getPenulis() { return $this->penulis; }
    public function getTahun() { return $this->tahun; }
    public function getStok() { return $this->stok; }

    public function toArray() {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'tahun' => $this->tahun,
            'stok' => $this->stok
        ];
    }
}