<?php

namespace App\Http\Controllers\Api\Order;

use Illuminate\Http\Request;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Auth;
use App\Foundations\Routing\BaseApiController;

class OrderController extends BaseApiController
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psy\Exception\FatalErrorException
     */
    public function create(Request $request)
    {
        $request->validate([
//            'name' => 'required|min:2|max:100',
            'item_id' => 'required|exists:items,id,deleted_at,NULL',
        ]);

        if(Auth::check()) {

            $order = $this->orderService->createOrder($request);

            if($order) {
                return $this->msgResponse('Order Successfully Created', 201);
            }

            return $this->msgResponse('There was an error in creating order', 500);
        }
        return $this->msgResponse('Unauthorized', 401);
    }
}
