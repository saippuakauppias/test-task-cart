<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart\Rules;

use Saippuakauppias\TestCart\Rules\AbstractRule;


class ItemsBasedRule extends AbstractRule
{
    protected $needProducts = [];

    protected $applyOnAll;

    public function __construct(array $needProducts, float $discount, bool $applyOnAll = true) {
        $this->needProducts = $needProducts;
        $this->discount = $discount;
        $this->applyOnAll = $applyOnAll;
    }

    // on all or on last
    // TODO: ApplyStrategy class?
    public function needApplyOnAll(): bool {
        return $this->applyOnAll;
    }

    public function isApplicable(...$products): bool {
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
