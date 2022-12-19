<?php

namespace App\Models\SubCategory;

use App\Foundations\Traits\HasUUID;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, HasUUID, SoftDeletes;

    protected $fillable = [
        'name', 'desc', 'category_id'
    ];

    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
