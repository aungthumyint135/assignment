<?php

namespace App\Services\User;

use Exception;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;

class UserService extends CommonService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $request
     * @return array
     */
    public function makeDtCollection($request): array
    {
        $count = $this->userRepository->totalCount();

        $users = $this->userRepository->all($this->dtParams($request));

        $filteredCnt = $this->userRepository->totalCount($this->params($request, ['search']));

        $users = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name ?? '---',
                'status' => $user->status

            ];
        })->toArray();

        return [
            'data' => $users,
            'recordsTotal' => $count,
            'draw' => $request->get('draw'),
            'recordsFiltered' => $filteredCnt,
        ];
    }

    /**
     * @param Request $request
     * @return false
     */
    public function registerUser(Request $request)
    {
        $input = $this->input($request, [
            'email', 'password', 'name',
        ]);
        $input['password'] = Hash::make($input['password']);

        try {
            DB::beginTransaction();

            $user = $this->userRepository->insert($input);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());

            return false;
        }

        return $user->toArray();
    }

    public function deActiveUser($id): int
    {
        try {
            $data['status'] = 0;
            DB::beginTransaction();
            $user = $this->userRepository->getDataById($id);

            if ($user) {
                $this->userRepository->update($data, $user->id);
            }

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return false;
        }

        return true;
    }

    public function activeUser($id): int
    {
        try {
            $data['status'] = 1;
            DB::beginTransaction();

            $user = $this->userRepository->getDataById($id);
            if ($user) {
                $this->userRepository->update($data, $user->id);
            }

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return false;
        }
        return true;
    }
}
