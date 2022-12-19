<?php

namespace App\Models\Category;

use App\Foundations\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, HasUUID, SoftDeletes;

    protected $fillable = [
        'name', 'desc'
    ];
}
