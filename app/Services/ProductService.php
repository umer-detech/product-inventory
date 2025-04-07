<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProducts()
    {
        return $this->repository->getAll();
    }

    public function getProduct($id)
    {
        return $this->repository->getById($id);
    }

    public function createProduct(array $data)
    {
        return $this->repository->createProduct($data);
    }

    public function updateProduct(int $id, array $data)
    {
        return $this->repository->updateProduct($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->repository->delete($id);
    }
}