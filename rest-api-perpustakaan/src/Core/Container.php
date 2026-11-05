<?php
namespace App\Core;

use Exception;

class Container {
    private array $bindings = [];

    public function bind(string $abstract, $concrete) {
        $this->bindings[$abstract] = $concrete;
    }

    public function make(string $abstract) {
        if (!isset($this->bindings[$abstract])) {
            throw new Exception("Binding tidak ditemukan untuk: {$abstract}");
        }

        $concrete = $this->bindings[$abstract];
        if (is_callable($concrete)) {
            return $concrete($this);
        }

        return $concrete;
    }
}