<?php

namespace App\Tests\Handler\Order\OrderPriceCalculation;

use App\Modules\Order\Service\OrderParserRequest;
use App\Modules\Order\OrderClass\OrderCalculatePriceRequestClass;
use App\Service\PriceCalculatorService\PriceCalculatorService;
use App\Service\PaymentProcessorService\PaymentProcessorService;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\Handler\OrderHandler;

class OrderPriceCalculationTest extends TestCase
{
    private $orderParserRequestMock;
    private $priceCalculatorServiceMock;
    private $paymentProcessorServiceMock;
    private $orderHandler;

    protected function setUp(): void
    {
        $this->orderParserRequestMock = $this->createMock(OrderParserRequest::class);
        $this->priceCalculatorServiceMock = $this->createMock(PriceCalculatorService::class);
        $this->paymentProcessorServiceMock = $this->createMock(PaymentProcessorService::class);
        $this->orderHandler = new OrderHandler($this->orderParserRequestMock, $this->priceCalculatorServiceMock, $this->paymentProcessorServiceMock);
    }

    /**
     * @throws Exception
     */
    public function testOrderPriceCalculationSuccess()
    {
        $requestData = [
            'product' => 1,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'D15'
        ];

        $request = new Request([], $requestData);

        $parseData = new OrderCalculatePriceRequestClass();
        $parseData->setProduct(1);
        $parseData->setTaxNumber('DE123456789');
        $parseData->setCouponCode('D15');

        $this->orderParserRequestMock->expects($this->once())
            ->method('parseOrderCalculatePriceRequest')
            ->with($request)
            ->willReturn($parseData);

        $expectedPrice = 100.0;
        $this->priceCalculatorServiceMock->expects($this->once())
            ->method('calculatePrice')
            ->with(1, 'DE123456789', 'D15')
            ->willReturn($expectedPrice);

        $result = $this->orderHandler->orderPriceCalculation($request);

        $this->assertEquals($expectedPrice, $result);
    }

    public function testOrderPriceCalculationInvalidRequest()
    {
        $requestData = [
            'product' => null,
            'taxNumber' => '',
            'couponCode' => 'D15'
        ];

        $request = new Request([], $requestData);

        $parseData = new OrderCalculatePriceRequestClass();
        $parseData->setProduct(0);
        $parseData->setTaxNumber('');
        $parseData->setCouponCode('D15');

        $this->orderParserRequestMock->expects($this->once())
            ->method('parseOrderCalculatePriceRequest')
            ->with($request)
            ->willReturn($parseData);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('{"product":"Invalid request"}');

        $this->orderHandler->orderPriceCalculation($request);
    }
}