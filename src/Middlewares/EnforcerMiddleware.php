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
        if (Auth::guest()) {
            throw new UnauthorizedException();
            // return $next($request);
        }

        $user = Auth::user();
        $identifier = $user->getAuthIdentifier();
        if (method_exists($user, 'getAuthzIdentifier')) {
            $identifier = $user->getAuthzIdentifier();
        }

        if (!Enforcer::enforce($identifier, ...$args)) {
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
