<?php

namespace App\Service\ParserService;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ParserService
{
    /**
     * @param Request $request
     * @return mixed
     */
    protected function BasicParseJson(Request $request): mixed
    {
        $data = $this->getDataRequest($request);

        return json_decode($data);
    }


    /**
     * @return Serializer
     */
    protected function getSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ArrayDenormalizer(), new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    /**
     * @return Serializer
     */
    protected function getSerializerExtractor(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
        $normalizers = [
            new ObjectNormalizer(null, null, null, $extractor),
            new ArrayDenormalizer(),
        ];

        return new Serializer($normalizers, $encoders);
    }

    /**
     * @param Request $request
     * @return false|resource|string|null
     */
    protected function getDataRequest(Request $request)
    {
        $data = $request->getContent();
        if ($data == ''){
            throw new \LogicException('Тело запроса пустое!');
        }

        return $data;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getRequestParameters(Request $request)
    {
        return $request->query->all();
    }
}