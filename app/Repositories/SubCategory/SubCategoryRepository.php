<?php

namespace App\Repositories\SubCategory;

use App\Models\SubCategory\SubCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Foundations\BaseRepository\BaseRepository;

class SubCategoryRepository extends BaseRepository implements SubCategoryRepositoryInterface
{
    public function connection(): Model
    {
        return new SubCategory();
    }

    public function optionsQuery(array $options): Builder
    {
        $query = $this->connection()->query();

        if (isset($options['search'])) {
            $query = $query->where(function ($query) use ($options) {
                $query->orWhere('name', 'like', "%{$options['search']}%")
                    ->orWhere('desc', 'like', "%{$options['search']}%")
                    ->orWhereHas('category', function ($query) use ($options) {
                        $query->where('name', 'like', "%{$options['search']}%");
                    });
            });
        }

        if(isset($options['category_id'])) {
            $query = $query->where('category_id', $options['category_id']);
        }

        return $query;
    }
}
