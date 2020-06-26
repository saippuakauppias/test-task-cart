<?php
declare(strict_types=1);

namespace Saippuakauppias\TestCart;


interface ProductInterface
{
    public function getName(): string;

    public function getPrice(): float;
}
