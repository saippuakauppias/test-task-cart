<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Products;

class Product
{
    protected $name;

    protected $price;

    /**
     * Create a new Product
     *
     * @param string $name
     * @param float $price
     */
    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
