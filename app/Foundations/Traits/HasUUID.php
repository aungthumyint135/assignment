<?php

namespace App\Foundations\Traits;

use Illuminate\Support\Str;

trait HasUUID
{
    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
