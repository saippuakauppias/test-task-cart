<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart;

use Saippuakauppias\TestCart\CartItem;


class Cart
{
    protected $items = [];

    public function addItem(CartItem $item) {
        $this->items[] = $item;

        // resort items (products with higher price on top)
        \usort($this->items, function(CartItem $i1, CartItem $i2) {
            //return strcmp($i1->getProduct()->getName(), $i2->getProduct()->getName());
            return $i2->getProduct()->getPrice() - $i1->getProduct()->getPrice();
        });
    }

    public function applyRules(Callable $checker) {
        $checker($this->items);
    }

    public function getFullPrice(): float {
        $result = 0;
        foreach($this->items as $item) {
            $result += $item->getProductPrice();
        }

        return $result;
    }

    public function getDiscountPrice(): float {
        $result = 0;
        foreach($this->items as $item) {
            $price = $item->getProductPrice();
            $discount = $item->getProductDiscount();

            $result += $price * (1 - $discount);
        }

        return $result;
    }
}
