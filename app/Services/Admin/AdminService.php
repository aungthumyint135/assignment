<?php

namespace App\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Admin\AdminRepositoryInterface;

class AdminService extends CommonService
{
    protected RoleRepositoryInterface $roleRepository;
    protected AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function makeDtCollection(Request $request): array
    {
        $count = $this->adminRepository->totalCount();

        $filteredCnt = $this->adminRepository->totalCount($this->params($request, ['search']));

        $admins = $this->adminRepository->all(
            array_merge($this->dtParams($request), ['with' => 'role'])
        );

        $admins = collect($admins)->map(function ($admin) {
            return [
                'uuid' => $admin->uuid,
                'name' => $admin->name ?? '---',
                'email' => $admin->email ?? '---',
                'role' => $admin->role->name ?? '---',
            ];
        });

        return [
            'data' => $admins,
            'recordsTotal' => $count,
            'draw' => request('draw'),
            'recordsFiltered' => $filteredCnt,
        ];
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function createAdmin(Request $request)
    {
        $role = $this->getRoleByUuid($request->get('role_id'));

        $input = $this->getInput($request, $role->id);

        try {

            DB::beginTransaction();

            $admin = $this->adminRepository->insert($input);

            $admin->assignRole($role);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @param $admin
     * @return bool
     */
    public function updateAdmin(Request $request, $admin)
    {
        $role = $this->getRoleByUuid($request->get('role_id'));

        $input = $this->getInput($request, $role->id);

        try {

            DB::beginTransaction();

            $this->adminRepository->update($input, $admin->id);

            $admin->assignRole($role);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return false;
        }

        return true;
    }

    /**
     * @param $request
     * @param $roleId
     * @return array
     */
    public function getInput($request, $roleId): array
    {
        $input = array_filter($request->only([
            'name', 'email', 'password', 'role_id',
        ]));

        $input['role_id'] = $roleId;

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }

        return $input;
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function getRoleByUuid($uuid)
    {
        $role = $this->roleRepository->getDataByUuid($uuid);

        if (! $role) {
            abort(404);
        }

        return $role;
    }

    public function getAdminByUuid($uuid)
    {
        $admin = $this->adminRepository->getDataByUuid($uuid);

        if (!$admin) {
            abort(404);
        }

        return $admin;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roleRepository->all();
    }

    /**
     * @param $uuids
     * @return int[]
     */
    public function deleteAdmin($uuids): array
    {
        try {

            DB::beginTransaction();

            foreach ($uuids as $uuid) {
                $admin = $this->adminRepository->getDataByUuid($uuid);
                if ($admin) {
                    $this->adminRepository->destroy($admin->id);
                }
            }

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return ['success' => 500];
        }
        return ['success' => 1];
    }
}
