<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart\Cart;

use Saippuakauppias\TestCart\Products\Product;
use Saippuakauppias\TestCart\Rules\AbstractRule;

class CartItem
{
    protected $product;

    protected $rule = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function isTaken(): bool
    {
        return !\is_null($this->rule);
    }

    public function applyRule(AbstractRule $rule)
    {
        $this->rule = $rule;
    }

    public function getProductPrice(): float
    {
        return $this->product->getPrice();
    }

    public function getProductDiscount(): float
    {
        if ($this->isTaken()) {
            return $this->rule->getDiscount();
        }

        return 0;
    }
}
