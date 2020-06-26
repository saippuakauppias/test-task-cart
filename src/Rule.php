<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart;


class Rule
{
    protected $discount = 0.0;

    protected $needProducts = [];

    protected $applyOnAll;

    public function __construct(array $needProducts, float $discount, bool $applyOnAll = true) {
        $this->needProducts = $needProducts;
        $this->discount = $discount;
        $this->applyOnAll = $applyOnAll;
    }

    public function getDiscount(): float {
        return $this->discount;
    }

    // on all or on last
    // TODO: ApplyStrategy class?
    public function needApplyOnAll(): bool {
        return $this->applyOnAll;
    }

    public function isApplicable(...$products) {
        if (\sizeof($products) != \sizeof($this->needProducts)) {
            return false;
        }

        $needProductsCopy = array_merge(array(), $this->needProducts);
        for ($i = 0; $i < \sizeof($products); $i++) {
            foreach ($needProductsCopy as $key => $val) {
                if ($products[$i]->getName() == $needProductsCopy[$key]->getName()) {
                    unset($needProductsCopy[$key]);

                    break;
                }
            }
        }

        return (\sizeof($needProductsCopy) == 0);
    }
}
