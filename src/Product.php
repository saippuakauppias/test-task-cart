<?php
declare(strict_types=1);

namespace Saippuakauppias\TestCart;


class Product
{
    protected $name;

    protected $price;

    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }
}
