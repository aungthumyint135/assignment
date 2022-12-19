<?php

namespace App\Http\Controllers\Web\Permission;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Permission\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
//        $this->middleware('permission:PermissionListing');

        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('dashboard.permission.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function permissions(Request $request): JsonResponse
    {
        return response()->json($this->permissionService->makeDtCollection($request));
    }
}
