<?php

namespace App\Http\Controllers\Web\Role;

use App\Services\Permission\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    protected RoleService $roleService;
    protected PermissionService $permissionSevice;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionSevice = $permissionService;
    }

    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        return view('dashboard.role.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $permissions = $this->permissionSevice->getPermissions();

        return view('dashboard.role.create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'permissions' => 'required|array',
            'name' => 'required|min:3|max:100|unique:roles,name',
            'permissions.*' => "required|exists:permissions,name,guard_name,admins",
        ]);

        $response = $this->roleService->createRole($request);

        if ($response) {
            return redirect()->route('admin.role.index')
                ->with('success', 'Successful to create role.');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Fail to create role.');

    }

    /**
     * @param $uuid
     * @return Application|Factory|View
     */
    public function edit($uuid)
    {
        $role = $this->roleService->getRoleByUuid($uuid);

        $permissions = $this->permissionSevice->getPermissions();

        $rolePermissions = $this->permissionSevice->getPermissionByRole($role);

        return view('dashboard.role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $uuid)
    {
        $role = $this->roleService->getRoleByUuid($uuid);

        $this->validate($request, [
            'permissions' => 'array',
            'description' => 'nullable|min:3|max:500',
            'permissions.*' => "exists:permissions,name,guard_name,admins",
            'name' => "min:3|max:100|" . Rule::unique('roles', 'name')->ignore($role->id, 'id'),
        ]);

        $role = $this->roleService->getRoleByUuid($uuid);

        $response = $this->roleService->updateRole($request, $role);

        if ($response) {
            return redirect()->back()->withInput()
                ->with('success', 'Successful to update role.');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Fail to update role.');
    }

    /**
     * @param $uuids
     * @return JsonResponse
     */
    public function destroy($uuids): JsonResponse
    {
        $uuids = explode(',', $uuids);

        $response = $this->roleService->deleteRole($uuids);

        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function roles(Request $request): JsonResponse
    {
        return response()->json($this->roleService->makeDtCollection($request));
    }
}
