<?php

namespace App\Services\SubCategory;

use Exception;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use Psy\Exception\FatalErrorException;
use App\Services\Category\CategoryService;
use App\Repositories\SubCategory\SubCategoryRepositoryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class SubCategoryService extends CommonService
{
    protected $categoryService;
    protected $subCategoryRepository;

    public function __construct(SubCategoryRepositoryInterface $subCategoryRepository, CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->subCategoryRepository = $subCategoryRepository;
    }

    /**
     * @return mixed
     */
    public function getSubCategories()
    {
        return $this->subCategoryRepository->all()->toArray();
    }

    /**
     * @param $categoryUuid
     * @return mixed
     */
    public function getSubcategoriesByCategory($categoryUuid): mixed
    {
        $category = $this->categoryService->getCategoryByUuid($categoryUuid);

        $params['category_id'] = $category->id;

        return $this->subCategoryRepository->all($params)->toArray();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function makeDtCollection(Request $request): array
    {
        $count = $this->subCategoryRepository->totalCount();

        $filteredCnt = $this->subCategoryRepository->totalCount($this->params($request, ['search']));

        $categories = $this->subCategoryRepository->all(
            array_merge($this->dtParams($request))
        );

        $data = collect($categories)->map(function ($subCategory) {
            return [
                'uuid' => $subCategory->uuid,
                'name' => $subCategory->name ?? '---',
                'desc' => $subCategory->desc ?? '---',
                'category' => $subCategory->category->name ?? '---'
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
    public function createSubCategory(Request $request): mixed
    {
        $input = array_filter($request->only(
            $this->subCategoryRepository->connection()->getFillable()
        ));

        try {

            DB::beginTransaction();

            $category = $this->subCategoryRepository->insert($input);

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
    public function getSubCategoryByUuid($uuid): mixed
    {
        $category = $this->subCategoryRepository->getDataByUuid($uuid);

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
    public function updateSubCategory(Request $request, $id): mixed
    {
        $input = $request->only(['name', 'desc']);

        try {
            DB::beginTransaction();

            $this->subCategoryRepository->update($input, $id);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            throw new FatalErrorException($exception->getMessage());
        }

        return $this->getSubCategoryById($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSubCategoryById($id): mixed
    {
        $category = $this->subCategoryRepository->getDataById($id);

        if (! $category) {
            throw new NotFoundResourceException();
        }
        return $category;
    }

    /**
     * @param $uuids
     * @return int
     */
    public function deleteSubCategory($uuids): int
    {
        try {

            DB::beginTransaction();

            foreach ($uuids as $uuid) {
                $category = $this->subCategoryRepository->getDataByUuid($uuid);
                if ($category) {
                    $this->subCategoryRepository->destroy($category->id);
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
