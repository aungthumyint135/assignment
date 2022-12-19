<?php

namespace App\Services\Role;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Admin\AdminRepositoryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class RoleService extends CommonService
{
    protected $roleRepository;
    protected $adminRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        AdminRepositoryInterface $adminRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getRoles($request): mixed
    {
        $params = $this->params($request);

        $params = array_merge($params, [
            'guard_name' => $this->currentGuard()
        ]);

        return $this->roleRepository->all($params);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function getRoleByUuid($uuid)
    {
        $role = $this->roleRepository->getDataByUuid($uuid);

        if (!$role) {
            abort(404);
        }

        return $role;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getRoleById($id)
    {
        $role = $this->roleRepository->getDataById($id);

        if (!$role) {
            throw new NotFoundResourceException();
        }

        return $role;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function createRole(Request $request): bool
    {
        $input = array_filter($request->only(['name']));

        try {

            DB::beginTransaction();

            $input['uuid'] = Str::uuid()->toString();
            $input['guard_name'] = $this->currentGuard();

            $role = $this->roleRepository->insert($input);

            $permissions = $request->get('permissions') ?
                $request->get('permissions') : [];

            $role->givePermissionTo($permissions);

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
     * @param $role
     * @return bool
     */
    public function updateRole(Request $request, $role)
    {
        $input = $request->only(['name']);

        try {

            DB::beginTransaction();

            $this->roleRepository->update($input, $role->id);

            $permissions = $request->get('permissions') ?
                $request->get('permissions') : [];

            $role->syncPermissions($permissions);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());

            return false;
        }

        return true;
    }

    /**
     * @param $uuids
     * @return int[]
     */
    public function deleteRole($uuids)
    {
        try {

            $roleNames = [];

            DB::beginTransaction();

            foreach ($uuids as $uuid) {

                $role = $this->getRoleByUuid($uuid);

                if ($role) {

                    $admins = $this->adminRepository->all([
                        'role_id' => $id = $role->id
                    ]);

                    if ($admins->isEmpty()) {
                        $this->roleRepository->destroy($id);
                    } else {
                        $roleNames[] = $role->name;
                    }

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

    /**
     * @param Request $request
     * @return array
     */
    public function makeDtCollection(Request $request): array
    {
        $count = $this->roleRepository->totalCount();

        $filteredCnt = $this->roleRepository->totalCount($this->params($request, ['search']));

        $roles = $this->roleRepository->all(
            array_merge($this->dtParams($request), ['only' => ['name', 'uuid']])
        );

        return [
            'data' => $roles,
            'recordsTotal' => $count,
            'draw' => request('draw'),
            'recordsFiltered' => $filteredCnt,
        ];
    }
}
