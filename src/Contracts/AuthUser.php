<?php

declare (strict_types = 1);

namespace Larke\Auth\Contracts;

/**
 * 自定义接口
 */
interface AuthUser
{
    public function getIdentifier();
}
