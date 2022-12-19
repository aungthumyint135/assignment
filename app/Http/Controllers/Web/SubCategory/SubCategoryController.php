<?php

namespace App\Http\Controllers\Web\SubCategory;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Services\SubCategory\SubCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $categoryService;
    protected $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService, CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->subCategoryService = $subCategoryService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('dashboard.sub-category.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = $this->categoryService->getCategories();
        return view('dashboard.sub-category.create')->with(['categories' => $categories]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Psy\Exception\FatalErrorException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required|min:2|max:200',
            'desc' => 'nullable|min:5|max:500',
        ]);

        $subCategory = $this->subCategoryService->createSubCategory($request);

        if($subCategory){
            return redirect()->route('admin.sub.category.index')
                ->with('success', 'Successful to create subcategory.');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Failed to create subcategory.');
    }

    /**
     * @param $uuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($uuid)
    {
        $subCategory = $this->subCategoryService->getSubCategoryByUuid($uuid);
        $categories = $this->categoryService->getCategories();

        return view('dashboard.sub-category.edit')->with(['subCategory' => $subCategory, 'categories' => $categories]);
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Psy\Exception\FatalErrorException
     */
    public function update(Request $request, $uuid): RedirectResponse
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required|min:2|max:200',
            'desc' => 'nullable|min:5|max:500',
        ]);

        $subCategory = $this->subCategoryService->getSubCategoryByUuid($uuid);

        $response = $this->subCategoryService->updateSubCategory($request, $subCategory->id);

        if($response){
            return redirect()->back()->withInput()
                ->with('success', 'Successful to update subcategory');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Failed to update subcategory');
    }

    /**
     * @param $uuids
     * @return JsonResponse
     */
    public function destroy($uuids): JsonResponse
    {
        $uuids = explode(',', $uuids);

        $response = $this->subCategoryService->deleteSubCategory($uuids);

        return response()->json(['success' => $response]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subCategories(Request $request): JsonResponse
    {
        return response()->json($this->subCategoryService->makeDtCollection($request));
    }
}
