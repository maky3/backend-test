<?php

namespace App\Modules;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Handler\OrderHandler;
class OrderModule implements OrderModuleInterface
{
    private OrderHandler $orderHandler;

    public function __construct(OrderHandler $orderHandler)
    {
        $this->orderHandler = $orderHandler;
    }

    /**
     * @param Request $request
     * @return float
     * @throws Exception
     */
    public function orderPriceCalculationAction( Request $request): float
    {
        return $this->orderHandler->orderPriceCalculation($request);
    }

    /**
     * @param Request $request
     * @return float
     */
    public function orderMakePurchaseAction( Request $request): float
    {
        return $this->orderHandler->orderMakePurchase($request);
    }
}