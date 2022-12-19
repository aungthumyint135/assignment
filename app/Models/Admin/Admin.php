<?php

namespace App\Models\Admin;

use App\Foundations\Traits\HasUUID;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasRoles, HasUUID;

    protected $fillable = [
        'role_id', 'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'deleted_at', 'deleted_by'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
