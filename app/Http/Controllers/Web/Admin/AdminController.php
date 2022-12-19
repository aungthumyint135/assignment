<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Role\RoleService;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use App\Services\Admin\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class AdminController extends Controller
{
    protected RoleService $roleService;
    protected AdminService $adminService;

    public function __construct(AdminService $adminService, RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->adminService = $adminService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('dashboard.admin.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $roles = $this->adminService->getRoles();

        return view('dashboard.admin.create', ['roles'=> $roles]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'remark' => 'nullable|min:2|max:500',
            'password' => 'required|confirmed|min:8',
            'name' => 'required|min:2|max:100|string',
            'role_id' => 'required|uuid|exists:roles,uuid',
            'email' => 'required|email|unique:admins,email,NULL,id,deleted_at,NULL',
        ]);

        $response = $this->adminService->createAdmin($request);

        if ($response) {
            return redirect()->route('admin.admin.index')
                ->with('success', 'Successful to create admin.');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Fail to create admin.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $uuid
     * @return Application|Factory|View
     */
    public function edit($uuid): View|Factory|Application
    {
        $roles = $this->adminService->getRoles();

        $admin = $this->adminService->getAdminByUuid($uuid);

        return view('dashboard.admin.edit', [
            'admin' => $admin, 'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $uuid
     * @return RedirectResponse
     */
    public function update(Request $request, $uuid): RedirectResponse
    {
        $admin = $this->adminService->getAdminByUuid($uuid);

        $this->validate($request, [
            'remark' => 'nullable|min:2|max:500',
            'role_id' => 'uuid|exists:roles,uuid',
            'name' => 'required|min:2|max:100|string',
            'password' => 'required_if:change_pwd,on|nullable|min:8',
            'email' => "email|unique:admins,email,$admin->id,id,deleted_at,NULL",
        ]);

        $response = $this->adminService->updateAdmin($request, $admin);

        if ($response) {
            return redirect()->back()->withInput()
                ->with('success', 'Successful to update admin.');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Fail to update admin.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $uuids
     * @return JsonResponse
     */
    public function destroy($uuids): JsonResponse
    {
        $uuids = explode(',', $uuids);

        $response = $this->adminService->deleteAdmin($uuids);

        return response()->json($response);
    }

    public function admins(Request $request): JsonResponse
    {
        return response()->json($this->adminService->makeDtCollection($request));
    }
}
