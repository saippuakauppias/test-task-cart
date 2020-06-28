<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Rules;

use Saippuakauppias\TestTaskCart\Rules\AbstractRule;

class AbstractRuleManager
{
    protected $rules = [];

    public function addRule(AbstractRule $rule)
    {
        $this->rules[] = $rule;
    }

    public function __invoke(&$cartItems)
    {
        throw new \Exception('Not implemented');
    }
}
