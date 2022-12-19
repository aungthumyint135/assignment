<?php

namespace App\Http\Controllers\Api\Item;

use App\Foundations\Routing\BaseApiController;
use App\Http\Controllers\Controller;
use App\Services\Item\ItemService;
use Illuminate\Http\Request;

class ItemController extends BaseApiController
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index($subCategoryUuid)
    {
        return $this->successResponse($this->itemService->getItemsBySubCategory($subCategoryUuid));
    }

    public function show($subCategoryUuid, $itemUuid)
    {
        $item = $this->itemService->getItemByUuid($itemUuid);

        return $this->successResponse($item->toArray());
    }
}
