<?php

namespace App\Repositories\Category;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Foundations\BaseRepository\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    public function connection(): Model
    {
        return new Category();
    }

    public function optionsQuery(array $options): Builder
    {
        $query = $this->connection()->query();

        if (isset($options['search'])) {
            $query = $query->where(function ($query) use ($options) {
                $query->orWhere('name', 'like', "%{$options['search']}%")
                    ->orWhere('desc', 'like', "%{$options['search']}%");
            });
        }

        return $query;
    }
}
