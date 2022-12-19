<?php

namespace App\Repositories\Item;

use App\Foundations\BaseRepository\BaseRepository;
use App\Models\Item\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ItemRepository extends BaseRepository implements ItemRepositoryInterface
{

    public function connection(): Model
    {
        return new Item();
    }

    public function optionsQuery(array $options): Builder
    {
        $query = $this->connection()->query();

        if (isset($options['search'])) {
            $query = $query->where(function ($query) use ($options) {
                $query->orWhere('name', 'like', "%{$options['search']}%")
                    ->orWhere('desc', 'like', "%{$options['search']}%")
                    ->orWhereHas('subCategory', function ($query) use ($options) {
                        $query->where('name', 'like', "%{$options['search']}%");
                    });
            });
        }

        if(isset($options['sub_category_id'])) {
            $query = $query->where('sub_category_id', $options['sub_category_id']);
        }
        return $query;
    }

}
