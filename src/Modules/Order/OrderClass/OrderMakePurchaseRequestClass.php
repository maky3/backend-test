<?php

namespace App\Modules\Order\OrderClass;

class OrderMakePurchaseRequestClass
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private int $product;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^(DE|IT|FR|GR)\d{9,11}$/")
     * @Assert\Type("integer")
     */
    private string $taxNumber;

    /**
     * @Assert\Type("string", allowNull=true)
     */
    private ?string $couponCode = null;

    /**
     * @Assert\NotBlank
     * @Assert\Choice({"paypal", "credit_card", "bank_transfer"})
     */
    private string $paymentProcessor;

    /**
     * @return int
     */
    public function getProduct(): int
    {
        return $this->product;
    }

    /**
     * @param int $product
     * @return OrderMakePurchaseRequestClass
     */
    public function setProduct(int $product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     * @return OrderMakePurchaseRequestClass
     */
    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    /**
     * @param string|null $couponCode
     * @return OrderMakePurchaseRequestClass
     */
    public function setCouponCode(?string $couponCode): self
    {
        $this->couponCode = $couponCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    /**
     * @param string $paymentProcessor
     * @return OrderMakePurchaseRequestClass
     */
    public function setPaymentProcessor(string $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;
        return $this;
    }
}