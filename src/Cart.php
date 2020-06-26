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

    public function applyRules(array $rules) {
        for($i = 0; $i < \sizeof($this->items); $i++) {
            if ($this->items[$i]->isTaken()) {
                continue;
            }

            for ($j = $i + 1; $j < \sizeof($this->items); $j++) {
                if ($this->items[$j]->isTaken()) {
                    continue;
                }
                foreach($rules as $rule) {
                    $products = [
                        $this->items[$i]->getProduct(),
                        $this->items[$j]->getProduct(),
                    ];
                    if ($rule->isApplicable($this->items[$i]->getProduct(), $this->items[$j]->getProduct())) {
                        if ($rule->needApplyOnAll()) {
                            $this->items[$i]->applyRule($rule);
                            $this->items[$j]->applyRule($rule);
                        } else {
                            $this->items[$j]->applyRule($rule);
                        }

                        break 2; // sic!
                    }
                }
            }
        }
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
