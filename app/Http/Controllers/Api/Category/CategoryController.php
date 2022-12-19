<?php

namespace App\Http\Controllers\Api\Category;

use App\Foundations\Routing\BaseApiController;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->successResponse($this->categoryService->getCategories());
    }

    public function show($uuid)
    {
        $category = $this->categoryService->getCategoryByUuid($uuid);

        return $this->successResponse($category->toArray());
    }
}
