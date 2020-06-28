<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Rules;

use Saippuakauppias\TestTaskCart\Rules\AbstractRule;

class AbstractRuleManager
{
    protected $rules = [];

    /**
     * Add Rule to manager
     *
     * @param AbstractRule $rule
     */
    public function addRule(AbstractRule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * Apply applicable rules to cart items
     *
     * @param array $cartItems
     */
    public function __invoke(array &$cartItems)
    {
        throw new \Exception('Not implemented');
    }
}
