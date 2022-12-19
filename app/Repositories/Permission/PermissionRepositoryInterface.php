<?php

namespace App\Repositories\Permission;

interface PermissionRepositoryInterface
{
    public function getAll(array $options = []);

    public function totalCount(array $options = []);
}
