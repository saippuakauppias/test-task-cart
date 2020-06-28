<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Rules;

use Saippuakauppias\TestTaskCart\Products\Product;
use Saippuakauppias\TestTaskCart\Rules\AbstractRule;

class CountBasedRule extends AbstractRule
{
    protected $excludeProducts = [];

    protected $count;

    /**
     * Create count based Rule
     *
     * @param array $excludeProducts
     * @param float $discount
     * @param int $count
     */
    public function __construct(array $excludeProducts, float $discount, int $count)
    {
        $this->excludeProducts = $excludeProducts;
        $this->discount = $discount;
        $this->count = $count;
    }

    public function isApplicable(...$products): bool
    {
        return (\sizeof($products) >= $this->count);
    }

    public function isExcludedProduct(Product $product)
    {
        foreach ($this->excludeProducts as $excludeProduct) {
            if ($product->getName() == $excludeProduct->getName()) {
                return true;
            }
        }

        return false;
    }
}
