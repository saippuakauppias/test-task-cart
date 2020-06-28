<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Rules;

use Saippuakauppias\TestTaskCart\Rules\AbstractRuleManager;

class CountBasedRuleManager extends AbstractRuleManager
{
    /**
     * @inheritdoc
     */
    public function __invoke(&$cartItems)
    {
        foreach ($this->rules as $rule) {
            $relevantItems = [];
            foreach ($cartItems as $itemKey => $itemValue) {
                if (
                    !$itemValue->isTaken() &&
                    !$rule->isExcludedProduct($itemValue->getProduct())
                ) {
                    $relevantItems[$itemKey] = $itemValue;
                }
            }

            if ($rule->isApplicable(...$relevantItems)) {
                foreach ($relevantItems as $itemKey => $itemValue) {
                    $cartItems[$itemKey]->applyRule($rule);
                }

                break;
            }
        }
    }
}
