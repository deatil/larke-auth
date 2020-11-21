<?php

namespace Larke\Auth\Observers;

use Larke\Auth\Models\Rule;

class RuleObserver
{
    public function creating(Rule $model)
    {
        $model->id = md5(mt_rand(100000, 999999).microtime());
    }
    
    public function saved(Rule $rule)
    {
        $rule->refreshCache();
    }

    public function deleted(Rule $rule)
    {
        $rule->refreshCache();
    }
}
