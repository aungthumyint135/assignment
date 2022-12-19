<?php

namespace App\Repositories\Role;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use App\Foundations\BaseRepository\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function connection(): Model
    {
        return new Role();
    }

    public function optionsQuery(array $options): Builder
    {
        $query = parent::optionsQuery($options);

        if (!empty($options['guard_name'])) {
            $query = $query->where('guard_name', $options['guard_name']);
        }

        if (!empty($options['search'])) {
            $query = $query->where('name', 'like', "%{$options['search']}%");
        }

        return $query;
    }

}
