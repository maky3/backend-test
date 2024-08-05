<?php

namespace App\Entity\Coupon;

use App\Entity\Product\Product;
use App\Repository\Coupon\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Table(name: '`coupon`')]

class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: "coupons")]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    private Product $product;

    #[ORM\Column(type: "string", length: 14)]
    private string $code;

    #[ORM\Column(type: "string", length: 14)]
    private string $taxNumber;

    #[ORM\Column(type: "string")]
    private string $discountType;

    #[ORM\Column(type: "float")]
    private float $discountValue;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Coupon
     */
    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountType(): string
    {
        return $this->discountType;
    }

    /**
     * @param string $discountType
     * @return Coupon
     */
    public function setDiscountType(string $discountType): self
    {
        $this->discountType = $discountType;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDiscountValue(): ?float
    {
        return $this->discountValue;
    }

    /**
     * @param float $discountValue
     * @return Coupon
     */
    public function setDiscountValue(float $discountValue): self
    {
        $this->discountValue = $discountValue;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return Coupon
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }
}
