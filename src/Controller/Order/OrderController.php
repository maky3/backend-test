<?php

namespace App\Controller\Order;

use App\Service\PaymentProcessorService\PaymentProcessorService;
use App\Service\PriceCalculatorService\PriceCalculatorService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\OrderModuleInterface;

class OrderController extends AbstractController
{
    private PriceCalculatorService $priceCalculator;

    private PaymentProcessorService $paymentProcessor;

    private OrderModuleInterface $orderModule;

    public function __construct(OrderModuleInterface    $orderModule,
                                PriceCalculatorService  $priceCalculator,
                                PaymentProcessorService $paymentProcessor)
    {
        $this->priceCalculator = $priceCalculator;
        $this->paymentProcessor = $paymentProcessor;
        $this->orderModule = $orderModule;
    }

    /**
     * Method for calculating price
     * @Rest\Post("/calculate-price", name="calculate-price")
     * @param Request $request
     * @return JsonResponse
     */
    public function orderPriceCalculation(Request $request): JsonResponse
    {
        try {
            $response = $this->orderModule->orderPriceCalculationAction($request);
            return new JsonResponse(['price' => $response], 200);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Method for making a purchase
     * @Rest\Post("/purchase", name="purchase")
     * @param Request $request
     * @return JsonResponse
     */
    public function orderMakePurchase(Request $request): JsonResponse
    {
        try {
            $response = $this->orderModule->orderMakePurchaseAction($request);
            return new JsonResponse(['success' => $response], 200);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}