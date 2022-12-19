<?php

namespace App\Models\Item;

use App\Foundations\Traits\HasUUID;
use App\Models\SubCategory\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory, HasUUID, SoftDeletes;

    protected $fillable = [
        'name', 'desc', 'sub_category_id'
    ];

    protected $with = ['subCategory'];

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
}
