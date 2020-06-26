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

    public function getRules(): array {
        return $this->rules;
    }
}
