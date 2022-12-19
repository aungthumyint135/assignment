<?php

namespace App\Services\Order;

use Exception;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Psy\Exception\FatalErrorException;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderService extends CommonService
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws FatalErrorException
     */
    public function createOrder(Request $request)
    {
        try {

            DB::beginTransaction();

            $input = array_filter($request->only(
                $this->orderRepository->connection()->getFillable()
            ));

            $data['user_id'] = Auth::id();
            $data['name'] = $request->name;
            if (is_array($request->item_id)) {
                foreach ($request->item_id as $itemId) {
                    $data['item_id'] = (int)$itemId;
                    $this->orderRepository->insert($data);
                }
            }
            $this->orderRepository->insert($data);
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            errorLogger($exception->getMessage(), $exception->getFile(), $exception->getLine());
            throw new FatalErrorException($exception->getMessage());
        }
        return true;
    }

}
