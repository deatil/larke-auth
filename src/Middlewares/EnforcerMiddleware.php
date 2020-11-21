<?php

namespace Larke\Auth\Middlewares;

use Closure;

use Illuminate\Support\Facades\Auth;

use Larke\Auth\Exceptions\UnauthorizedException;
use Larke\Auth\Facades\Enforcer;

/**
 * A basic Enforcer Middleware.
 */
class EnforcerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param mixed                    ...$args
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$args)
    {
        $identifier = app('larke.auth.user')->getIdentifier();
        if ($identifier === false) {
            throw new UnauthorizedException();
        }

        if (! Enforcer::enforce($identifier, ...$args)) {
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
