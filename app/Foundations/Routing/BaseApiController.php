<?php

namespace App\Foundations\Routing;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class BaseApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $success = 1;

    /**
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public function successResponse(array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => 1,
            'status' => $code,
            'method' => strtolower(Request::method()),
            'data' => $data
        ]);
    }


    public function msgResponse(string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message
        ])->setStatusCode($code);
    }
}
