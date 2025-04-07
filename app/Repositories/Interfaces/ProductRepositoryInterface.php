<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function createProduct(array $data);
    public function updateProduct(int $id, array $data);
    public function delete(int $id);
}
