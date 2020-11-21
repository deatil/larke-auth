<?php

namespace Larke\Auth\Contracts;

/**
 * 自定义接口
 */
interface AuthUser
{
    public function getIdentifier()
    {
        return false;
    }
}
