<?php

namespace App\Http\Controllers\Api\SubCategory;

use App\Services\SubCategory\SubCategoryService;
use Illuminate\Http\Request;
use App\Foundations\Routing\BaseApiController;

class SubCategoryController extends BaseApiController
{
    protected $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    public function index($categoryUuid)
    {
        return $this->successResponse($this->subCategoryService->getSubcategoriesByCategory($categoryUuid));
    }

    public function show($categoryUuid, $subCategoryUuid)
    {
        $subCategory = $this->subCategoryService->getSubCategoryByUuid($subCategoryUuid);

        return $this->successResponse($subCategory->toArray());
    }
}
