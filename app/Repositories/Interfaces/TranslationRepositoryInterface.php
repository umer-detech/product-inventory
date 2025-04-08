<?php

namespace App\Repositories\Interfaces;

use App\Models\Translation;

interface TranslationRepositoryInterface
{
    public function create(array $data): Translation;
    public function update(Translation $translation, array $data): Translation;
    public function find(int $id): ?Translation;
    public function search(array $filters);
    public function export(): array;
}
