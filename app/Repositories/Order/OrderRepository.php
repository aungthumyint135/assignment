<?php

namespace App\Repositories\Order;

use App\Foundations\BaseRepository\BaseRepository;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function connection(): Model
    {
        return new Order();
    }
}
