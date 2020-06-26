<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart;

use Saippuakauppias\TestCart\{Product, Rule};


class CartItem
{
    protected $product;

    protected $rule = null;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function getProduct(): Product {
        return $this->product;
    }

    public function isTaken(): bool {
        return !\is_null($this->rule);
    }
    public function applyRule(Rule $rule) {
        $this->rule = $rule;
    }

    public function getProductPrice(): float {
        return $this->product->getPrice();
    }

    public function getProductDiscount(): float {
        if ($this->isTaken()) {
            return $this->rule->getDiscount();
        }

        return 0;
    }
}
