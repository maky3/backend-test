<?php

namespace App\Modules\Order\OrderClass;

class OrderCalculatePriceRequestClass
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("integer", allowNull=true)
     */
    private ?int $product = null;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^(DE|IT|FR|GR)\d{9,14}$/")
     * @Assert\Type("string" , allowNull=true )
     */
    private ?string $taxNumber = null;

    /**
     * @Assert\Type("string" , allowNull=true )
     */
    private ?string $couponCode = null;

    /**
     * @return int|null
     */
    public function getProduct(): ?int
    {
        return $this->product;
    }

    /**
     * @param $product
     * @return OrderCalculatePriceRequestClass
     */
    public function setProduct($product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    /**
     * @param $taxNumber
     * @return OrderCalculatePriceRequestClass
     */
    public function setTaxNumber($taxNumber): self
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    /**
     * @param $couponCode
     * @return OrderCalculatePriceRequestClass|null
     */
    public function setCouponCode($couponCode): ?self
    {
        $this->couponCode = $couponCode;
        return $this;
    }
}