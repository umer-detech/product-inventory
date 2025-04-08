<?php

namespace App\Services;

use App\Models\Translation;
use App\Repositories\Interfaces\TranslationRepositoryInterface;

class TranslationService
{
    public function __construct(private TranslationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $data): Translation
    {
        return $this->repository->create($data);
    }

    public function update(Translation $translation, array $data): Translation
    {
        return $this->repository->update($translation, $data);
    }

    public function get(int $id): ?Translation
    {
        return $this->repository->find($id);
    }

    public function search(array $filters)
    {
        return $this->repository->search($filters);
    }

    public function export(): array
    {
        return $this->repository->export();
    }
}