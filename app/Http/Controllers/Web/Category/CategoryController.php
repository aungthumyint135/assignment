<?php

namespace App\Http\Controllers\Web\Category;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Category\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('dashboard.category.index');
    }

    public function create()
    {
        return view('dashboard.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:200',
            'desc' => 'nullable|min:5|max:500',
        ]);

        $category = $this->categoryService->createCategory($request);

        if($category){
            return redirect()->route('admin.category.index')
                ->with('success', 'Successful to create category.');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Failed to create category.');
    }

    public function edit($uuid)
    {
        $category = $this->categoryService->getCategoryByUuid($uuid);

        return view('dashboard.category.edit')->with(['category' => $category]);
    }

    public function update(Request $request, $uuid): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:200',
            'desc' => 'nullable|min:5|max:500',
        ]);

        $category = $this->categoryService->getCategoryByUuid($uuid);

        $response = $this->categoryService->updateCategory($request, $category->id);

        if($response){
            return redirect()->back()->withInput()
                ->with('success', 'Successful to update category');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Failed to update category');
    }

    public function destroy($uuids): JsonResponse
    {
        $uuids = explode(',', $uuids);

        $response = $this->categoryService->deleteCategory($uuids);

        return response()->json(['success' => $response]);
    }

    public function categories(Request $request): JsonResponse
    {
        return response()->json($this->categoryService->makeDtCollection($request));
    }
}
