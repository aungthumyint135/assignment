<?php

namespace App\Models\Order;

use App\Foundations\Traits\HasUUID;
use App\Models\Item\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, HasUUID, SoftDeletes;

    protected $fillable = [
        'name', 'user_id', 'item_id'
    ];

    protected $with = ['item'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
