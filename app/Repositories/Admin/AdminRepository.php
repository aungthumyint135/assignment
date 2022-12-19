<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Foundations\BaseRepository\BaseRepository;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{

    public function connection(): Model
    {
        return new Admin();
    }

    public function optionsQuery(array $options): Builder
    {
        $query = parent::optionsQuery($options)->where('is_super', 0);

        if (!empty($options['role_id'])) {
            $query = $query->where('role_id', $options['role_id']);
        }

        if (isset($options['search'])) {
            $query = $query->where(function ($query) use ($options) {
                $query->orWhere('name', 'like', "%{$options['search']}%")
                    ->orWhere('email', 'like', "%{$options['search']}%")
                    ->orWhereHas('role', function ($query) use ($options) {
                        $query->where('name', 'like', "%{$options['search']}%");
                    });
            });
        }


        return $query;
    }
}
