<?php

namespace App\Modules;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface OrderModuleInterface
{

    /**
     * @param Request $request
     * @return float
     */
    public function orderPriceCalculationAction(Request $request): float;

    /**
     * @param Request $request
     * @return float
     */
    public function orderMakePurchaseAction(Request $request): float;
}