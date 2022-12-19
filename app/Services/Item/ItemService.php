<?php

namespace App\Services\Item;

use Exception;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use Psy\Exception\FatalErrorException;
use App\Services\SubCategory\SubCategoryService;
use App\Repositories\Item\ItemRepositoryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ItemService extends CommonService
{
    protected SubCategoryService $subCategoryService;
    protected ItemRepositoryInterface $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository, SubCategoryService $subCategoryService)
    {
        $this->itemRepository = $itemRepository;
        $this->subCategoryService = $subCategoryService;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->itemRepository->all()->toArray();
    }

    /**
     * @param $subCategoryUuid
     * @return mixed
     */
    public function getItemsBySubCategory($subCategoryUuid)
    {
        $subCategory = $this->subCategoryService->getSubCategoryByUuid($subCategoryUuid);

        $params['sub_category_id'] = $subCategory->id;

        return $this->itemRepository->all($params)->toArray();

    }

    /**
     * @param Request $request
     * @return array
     */
    public function makeDtCollection(Request $request): array
    {
        $count = $this->itemRepository->totalCount();

        $filteredCnt = $this->itemRepository->totalCount($this->params($request, ['search']));

        $items = $this->itemRepository->all(
            array_merge($this->dtParams($request))
        );

        $data = collect($items)->map(function ($item) {
            return [
                'uuid' => $item->uuid,
                'name' => $item->name ?? '---',
                'desc' => $item->desc ?? '---',
                'subCategory' => $item->subCategory->name ?? '---'
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
    public function createItem(Request $request)
    {
        $input = array_filter($request->only(
            $this->itemRepository->connection()->getFillable()
        ));

        try {

            DB::beginTransaction();

            $item = $this->itemRepository->insert($input);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            throw new FatalErrorException($exception->getMessage());
        }

        return $item;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws FatalErrorException
     */
    public function updateItem(Request $request, $id)
    {
        $input = $request->only(['name', 'desc']);

        try {
            DB::beginTransaction();

            $this->itemRepository->update($input, $id);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            throw new FatalErrorException($exception->getMessage());
        }

        return $this->getItemById($id);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function getItemByUuid($uuid)
    {
        $item = $this->itemRepository->getDataByUuid($uuid);

        if (! $item) {
            throw new NotFoundResourceException();
        }

        return $item;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItemById($id)
    {
        $item = $this->itemRepository->getDataById($id);

        if (! $item) {
            throw new NotFoundResourceException();
        }

        return $item;
    }


    /**
     * @param $uuids
     * @return int
     */
    public function deleteItems($uuids): int
    {
        try {

            DB::beginTransaction();

            foreach ($uuids as $uuid) {
                $item = $this->itemRepository->getDataByUuid($uuid);
                if ($item) {
                    $this->itemRepository->destroy($item->id);
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
