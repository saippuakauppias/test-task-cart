<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart\Rules;


class AbstractRule
{
    protected $discount = 0.0;

    public function getDiscount(): float {
        return $this->discount;
    }

    public function isApplicable(): bool {
        throw new \Exception('Not implemented');
    }
}
