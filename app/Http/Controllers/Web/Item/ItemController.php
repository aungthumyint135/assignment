<?php

namespace App\Http\Controllers\Web\Item;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Item\ItemService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\SubCategory\SubCategoryService;

class ItemController extends Controller
{
    protected ItemService $itemService;
    protected SubCategoryService $subCategoryService;

    public function __construct(ItemService $itemService, SubCategoryService $subCategoryService)
    {
        $this->itemService = $itemService;
        $this->subCategoryService = $subCategoryService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('dashboard.item.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $subCategories = $this->subCategoryService->getSubCategories();
        return view('dashboard.item.create')->with(['subCategories' => $subCategories]);
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
            'sub_category_id' => 'required',
            'name' => 'required|min:2|max:200',
            'desc' => 'nullable|min:5|max:500',
        ]);

        $item = $this->itemService->createItem($request);

        if($item){
            return redirect()->route('admin.item.index')
                ->with('success', 'Successful to create item.');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Failed to create item.');
    }

    /**
     * @param $uuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($uuid)
    {
        $item = $this->itemService->getItemByUuid($uuid);
        $subCategories = $this->subCategoryService->getSubCategories();

        return view('dashboard.item.edit')->with(['subCategories' => $subCategories, 'item' => $item]);
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
            'sub_category_id' => 'required',
            'name' => 'required|min:2|max:200',
            'desc' => 'nullable|min:5|max:500',
        ]);


        $item = $this->itemService->getItemByUuid($uuid);

        $response = $this->itemService->updateItem($request, $item->id);

        if($response){
            return redirect()->back()->withInput()
                ->with('success', 'Successful to update item');
        }

        return redirect()->back()->withInput()
            ->with('fail', 'Failed to update item');
    }

    /**
     * @param $uuids
     * @return JsonResponse
     */
    public function destroy($uuids): JsonResponse
    {
        $uuids = explode(',', $uuids);

        $response = $this->itemService->deleteItems($uuids);

        return response()->json(['success' => $response]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request): JsonResponse
    {
        return response()->json($this->itemService->makeDtCollection($request));
    }
}
