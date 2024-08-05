<?php

namespace App\Service\PriceCalculatorService;

use App\Entity\Coupon\Coupon;
use App\Entity\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PriceCalculatorService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $productId
     * @param string $taxNumber
     * @param string|null $couponCode
     * @return float
     * @throws Exception
     */
    public function calculatePrice(int $productId, string $taxNumber, ?string $couponCode): float
    {
        $product = $this->entityManager->getRepository(Product::class)->find($productId);

        if (!$product) {
            throw new Exception('Product not found');
        }

        $price = $product->getPrice();

        $taxRate = $this->getTaxRateByTaxNumber($taxNumber);

        $price += $price * ($taxRate / 100);

        if ($couponCode) {
            $coupon = $this->entityManager->getRepository(Coupon::class)->findOneBy(['code' => $couponCode]);
            if ($coupon) {
                if ($coupon->getDiscountType() === 'fixed') {
                    $price -= $coupon->getDiscountValue();
                } elseif ($coupon->getDiscountType() === 'percentage') {
                    $price -= $price * ($coupon->getDiscountValue() / 100);
                }
            } else {
            throw new Exception('Coupon not found');
            }
        }
        return $price;
    }

    /**
     * @param string $taxNumber
     * @return float
     * @throws Exception
     */
    private function getTaxRateByTaxNumber(string $taxNumber): float
    {
        if (preg_match('/^DE\d{9}$/', $taxNumber)) {
            return 19;
        } elseif (preg_match('/^IT\d{11}$/', $taxNumber)) {
            return 22;
        } elseif (preg_match('/^FR[A-Z]{2}\d{9}$/', $taxNumber)) {
            return 20;
        } elseif (preg_match('/^GR\d{9}$/', $taxNumber)) {
            return 24;
        } else {
            throw new Exception('Invalid tax number');
        }
    }
}