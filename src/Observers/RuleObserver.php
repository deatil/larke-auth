<?php

namespace Larke\Auth\Observers;

use Larke\Auth\Models\Rule;

class RuleObserver
{
    public function saved(Rule $rule)
    {
        $rule->refreshCache();
    }

    public function deleted(Rule $rule)
    {
        $rule->refreshCache();
    }
}
