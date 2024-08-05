<?php

namespace App\Modules\Handler;

use App\Service\PriceCalculatorService\PriceCalculatorService;
use App\Service\PaymentProcessorService\PaymentProcessorService;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\Order\Service\OrderParserRequest;
use Exception;

class OrderHandler
{
    private OrderParserRequest $orderParserRequest;

    private PriceCalculatorService $priceCalculatorService;
    private PaymentProcessorService $paymentProcessorService;

    public function __construct(OrderParserRequest $orderParserRequest,
                                PriceCalculatorService $priceCalculatorService,
                                PaymentProcessorService $paymentProcessorService)
    {
        $this->orderParserRequest = $orderParserRequest;
        $this->priceCalculatorService = $priceCalculatorService;
        $this->paymentProcessorService = $paymentProcessorService;

    }

    /**
     * @param Request $request
     * @return float
     * @throws Exception
     */
    public function orderPriceCalculation(Request $request): float
    {
        $parseData = $this->orderParserRequest->parseOrderCalculatePriceRequest($request);

        $errors = [];

        if (empty($parseData->getProduct()) || empty($parseData->getTaxNumber())) {
            $errors['product'] = 'Invalid request';
        }

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }

        return $this->priceCalculatorService->calculatePrice($parseData->getProduct(), $parseData->getTaxNumber(), $parseData->getCouponCode());
    }

    /**
     * @param Request $request
     * @return bool
     * @throws Exception
     */
    public function orderMakePurchase(Request $request): bool
    {
        $parseData = $this->orderParserRequest->parseOrderMakePurchaseRequest($request);

        $errors = [];

        if (empty($parseData->getProduct()) || empty($parseData->getTaxNumber())) {
            $errors['product'] = 'Invalid request';
        }

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }

        $price = $this->priceCalculatorService->calculatePrice($parseData->getProduct(), $parseData->getTaxNumber(), $parseData->getCouponCode());

        return $this->paymentProcessorService->processPayment($parseData->getPaymentProcessor(), $price);
    }
}