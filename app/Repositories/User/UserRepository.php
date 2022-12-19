<?php

namespace App\Repositories\User;

use App\Foundations\BaseRepository\BaseRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function connection(): Model
    {
        return new User();
    }

    protected function optionsQuery(array $options)
    {
        $query = parent::optionsQuery($options);

        if (!empty($options['search'])) {
            $query = $query->where(function ($query) use ($options) {
                $query->orWhere('name', 'LIKE', "%{$options['search']}%")
                    ->orWhere('email', 'LIKE', "%{$options['search']}%");
            });
        }

        return $query;
    }
}
