<?php

namespace App\Modules\Order\Service;

use App\Modules\Order\OrderClass\OrderCalculatePriceRequestClass;
use App\Modules\Order\OrderClass\OrderMakePurchaseRequestClass;
use App\Modules\Registr\RegisterClass\RegisterWorkflowRequestClass;
use App\Service\ParserService\ParserService;
use JMS\Serializer\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;


class OrderParserRequest extends ParserService
{
    /**
     * @param Request $request
     * @return OrderCalculatePriceRequestClass
     */
    public function parseOrderCalculatePriceRequest(Request $request): OrderCalculatePriceRequestClass
    {
        $data = $this->getDataRequest($request);
        $serializer = $this->getSerializerExtractor();

        try {
            $result = $serializer->deserialize($data, OrderCalculatePriceRequestClass::class, 'json');
        } catch (UnexpectedValueException $e) {
            throw new LogicException($e->getMessage());
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return OrderMakePurchaseRequestClass
     */
    public function parseOrderMakePurchaseRequest(Request $request): OrderMakePurchaseRequestClass
    {
        $data = $this->getDataRequest($request);
        $serializer = $this->getSerializerExtractor();

        try {
            $result = $serializer->deserialize($data, OrderMakePurchaseRequestClass::class, 'json');
        } catch (UnexpectedValueException $e) {
            throw new LogicException($e->getMessage());
        }

        return $result;
    }

}




