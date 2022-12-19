<?php

namespace App\Services\Category;

use Exception;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use Psy\Exception\FatalErrorException;
use App\Repositories\Category\CategoryRepositoryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CategoryService extends CommonService
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categoryRepository->all()->toArray();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function makeDtCollection(Request $request): array
    {
        $count = $this->categoryRepository->totalCount();

        $filteredCnt = $this->categoryRepository->totalCount($this->params($request, ['search']));

        $categories = $this->categoryRepository->all(
            array_merge($this->dtParams($request))
        );

        $data = collect($categories)->map(function ($category) {
            return [
                'uuid' => $category->uuid,
                'name' => $category->name ?? '---',
                'desc' => $category->desc ?? '---'
            ];
        });

        return [
            'data' => $data,
            'recordsTotal' => $count,
            'draw' => request('draw'),
            'recordsFiltered' => $filteredCnt,
        ];
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws FatalErrorException
     */
    public function createCategory(Request $request)
    {
        $input = array_filter($request->only(
            $this->categoryRepository->connection()->getFillable()
        ));

        try {

            DB::beginTransaction();

            $category = $this->categoryRepository->insert($input);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            throw new FatalErrorException($exception->getMessage());
        }

        return $category;
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function getCategoryByUuid($uuid)
    {
        $category = $this->categoryRepository->getDataByUuid($uuid);

        if (! $category) {
            throw new NotFoundResourceException();
        }

        return $category;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws FatalErrorException
     */
    public function updateCategory(Request $request, $id)
    {
        $input = $request->only(['name', 'desc']);

        try {
            DB::beginTransaction();

            $this->categoryRepository->update($input, $id);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            throw new FatalErrorException($exception->getMessage());
        }

        return $this->getCategoryById($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryById($id)
    {
        $category = $this->categoryRepository->getDataById($id);

        if (! $category) {
            throw new NotFoundResourceException();
        }

        return $category;
    }

    /**
     * @param $uuids
     * @return int
     */
    public function deleteCategory($uuids): int
    {
        try {

            DB::beginTransaction();

            foreach ($uuids as $uuid) {
                $category = $this->categoryRepository->getDataByUuid($uuid);
                if ($category) {
                    $this->categoryRepository->destroy($category->id);
                }
            }

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return 500;
        }

        return 1;
    }
}
