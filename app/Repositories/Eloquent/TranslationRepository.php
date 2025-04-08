<?php

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Interfaces\TranslationRepositoryInterface;
use App\Models\Translation;

class TranslationRepository implements TranslationRepositoryInterface
{
    /**
     * @var Model
     */
    private $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Translation $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Translation
    {
        $translation = $this->model->create($data);
        if (!empty($data['tags'])) {
            $translation->tags()->sync($this->getTagIds($data['tags']));
        }
        return $translation;
    }

    public function update(Translation $translation, array $data): Translation
    {
        $translation->update($data);
        if (!empty($data['tags'])) {
            $translation->tags()->sync($this->getTagIds($data['tags']));
        }
        return $translation;
    }

    public function find(int $id): ?Translation
    {
        return $this->model->with('tags')->find($id);
    }

    public function search(array $filters)
    {
        $perPage = $filters['per_page'] ?? 50;

        return $this->model->with('tags')
            ->when(isset($filters['locale']), fn($q) => $q->where('locale', $filters['locale']))
            ->when(isset($filters['key']), fn($q) => $q->where('key', 'like', "%{$filters['key']}%"))
            ->when(isset($filters['tag']), function ($q) use ($filters) {
                $q->whereHas('tags', fn($q) => $q->where('name', $filters['tag']));
            })
            ->simplePaginate($perPage);
    }

    // public function search(array $filters)
    // {
    //     $perPage = $filters['per_page'] ?? 50;

    //     $query = $this->model->with('tags');

    //     if (!empty($filters['search'])) {
    //         $search = $filters['search'];
    //         $query->where(function ($q) use ($search) {
    //             $q->where('key', 'like', "%{$search}%")
    //             ->orWhere('value', 'like', "%{$search}%");
    //         });
    //     }

    //     if (!empty($filters['locale'])) {
    //         $query->where('locale', $filters['locale']);
    //     }

    //     if (!empty($filters['tags'])) {
    //         $query->whereHas('tags', function ($q) use ($filters) {
    //             $q->whereIn('name', (array) $filters['tags']);
    //         });
    //     }

    //     return $query->simplePaginate($perPage);
    // }


    public function export(): array
    {
        return $this->model->get()->groupBy('locale')->map(function ($items) {
            return $items->pluck('value', 'key');
        })->toArray();
    }

    protected function getTagIds(array $tags): array
    {
        return collect($tags)->map(function ($name) {
            return Tag::firstOrCreate(['name' => $name])->id;
        })->toArray();
    }
}
