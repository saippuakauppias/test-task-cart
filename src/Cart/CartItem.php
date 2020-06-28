<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Cart;

use Saippuakauppias\TestTaskCart\Products\Product;
use Saippuakauppias\TestTaskCart\Rules\AbstractRule;

class CartItem
{
    protected $product;

    protected $rule = null;

    /**
     * Create a CartItem with Product
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product instance from this CartItem
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Check current CartItem if is taken by Rule
     *
     * @return bool
     */
    public function isTaken(): bool
    {
        return !\is_null($this->rule);
    }

    /**
     * Apply rule to this CartItem
     *
     * @param AbstractRule $rule
     */
    public function applyRule(AbstractRule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Get price from Product instance
     *
     * @return float
     */
    public function getProductPrice(): float
    {
        return $this->product->getPrice();
    }

    /**
     * Get discount if any Rule applied
     *
     * @return float
     */
    public function getProductDiscount(): float
    {
        if ($this->isTaken()) {
            return $this->rule->getDiscount();
        }

        return 0;
    }
}
