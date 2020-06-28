<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart;

use Saippuakauppias\TestCart\Rule;


class RuleManager
{
    protected $rules = [];

    public function addRule(Rule $rule) {
        $this->rules[] = $rule;
    }

    public function __invoke(&$cartItems) {
        for($i = 0; $i < \sizeof($cartItems); $i++) {
            if ($cartItems[$i]->isTaken()) {
                continue;
            }

            for ($j = $i + 1; $j < \sizeof($cartItems); $j++) {
                if ($cartItems[$j]->isTaken()) {
                    continue;
                }

                // 2 products
                foreach($this->rules as $rule) {
                    if (
                        $rule->isApplicable(
                            $cartItems[$i]->getProduct(),
                            $cartItems[$j]->getProduct()
                        )
                    ) {
                        if ($rule->needApplyOnAll()) {
                            $cartItems[$i]->applyRule($rule);
                            $cartItems[$j]->applyRule($rule);
                        } else {
                            // apply to last (based on product name)
                            if (
                                \strcmp(
                                    $cartItems[$i]->getProduct()->getName(),
                                    $cartItems[$j]->getProduct()->getName()
                                ) > 0
                            ) {
                                $cartItems[$i]->applyRule($rule);
                            } else {
                                $cartItems[$j]->applyRule($rule);
                            }
                        }

                        break 2; // sic!
                    }
                }

                // 3 products
                for ($k = $j + 1; $k < \sizeof($cartItems); $k++) {
                    foreach($this->rules as $rule) {
                        if (
                            $rule->isApplicable(
                                $cartItems[$i]->getProduct(),
                                $cartItems[$j]->getProduct(),
                                $cartItems[$k]->getProduct()
                            )
                        ) {
                            // apply on all by default
                            $cartItems[$i]->applyRule($rule);
                            $cartItems[$j]->applyRule($rule);
                            $cartItems[$k]->applyRule($rule);

                            break 2; // sic!
                        }
                    }
                }
            }
        }
    }
}
