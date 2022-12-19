<?php

namespace App\Services\Permission;

use Illuminate\Http\Request;
use App\Services\CommonService;
use App\Repositories\Permission\PermissionRepositoryInterface;

class PermissionService extends CommonService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissionRepository->getAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function makeDtCollection(Request $request): array
    {
        $count = $this->permissionRepository->totalCount();

        $filteredCnt = $this->permissionRepository->totalCount($this->params($request, ['search']));

        $permissions = $this->permissionRepository->getAll(array_merge($this->dtParams($request), ['only' => 'name']));

        return [
            'data' => $permissions,
            'recordsTotal' => $count,
            'draw' => request('draw'),
            'recordsFiltered' => $filteredCnt,
        ];
    }

    /**
     * @param $role
     * @return mixed
     */
    public function getPermissionByRole($role)
    {
        return $role->permissions()->pluck('name');
    }
}
