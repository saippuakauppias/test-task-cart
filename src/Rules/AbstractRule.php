<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Rules;

class AbstractRule
{
    protected $discount = 0.0;

    /**
     * Get discount for this rule
     *
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * Check passed products is applicable for this rule
     *
     * @return bool
     */
    public function isApplicable(...$products): bool
    {
        throw new \Exception('Not implemented');
    }
}
