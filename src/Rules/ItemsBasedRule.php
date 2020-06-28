<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Rules;

use Saippuakauppias\TestTaskCart\Rules\AbstractRule;

class ItemsBasedRule extends AbstractRule
{
    protected $needProducts = [];

    protected $applyOnAll;

    /**
     * Create items based Rule
     *
     * @param array $needProducts
     * @param float $discount
     * @param bool $applyOnAll
     */
    public function __construct(array $needProducts, float $discount, bool $applyOnAll = true)
    {
        $this->needProducts = $needProducts;
        $this->discount = $discount;
        $this->applyOnAll = $applyOnAll;
    }

    /**
     * Apply this rule to all cart items or only to last CartItem
     *
     * @return bool
     */
    public function needApplyOnAll(): bool
    {
        return $this->applyOnAll;
    }

    /**
     * @inheritdoc
     */
    public function isApplicable(...$products): bool
    {
        if (\sizeof($products) != \sizeof($this->needProducts)) {
            return false;
        }

        $needProductsCopy = array_merge(array(), $this->needProducts);
        foreach ($products as $product) {
            foreach ($needProductsCopy as $needProductKey => $needProductObj) {
                if ($product->getName() == $needProductObj->getName()) {
                    unset($needProductsCopy[$needProductKey]);

                    break;
                }
            }
        }

        return (\sizeof($needProductsCopy) == 0);
    }
}
