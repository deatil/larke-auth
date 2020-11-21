<?php

namespace Larke\Auth\Middlewares;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Larke\Auth\Exceptions\UnauthorizedException;
use Larke\Auth\Facades\Enforcer;

/**
 * A HTTP Request Middleware.
 */
class RequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param mixed                    ...$guards
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $identifier = app('larke.auth.user')->getIdentifier();
        if ($identifier === false) {
            throw new UnauthorizedException();
        }

        $this->authorize($request, $guards);

        return $next($request);
    }

    /**
     * Determine if the user is authorized in to any of the given guards.
     *
     * @param \Illuminate\Http\Request $request
     * @param array                    $guards
     *
     * @throws \Larke\Auth\Exceptions\UnauthorizedException
     */
    protected function authorize(Request $request, array $guards)
    {
        $identifier = app('larke.auth.user')->getIdentifier();

        if (empty($guards)) {
            if (Enforcer::enforce($identifier, $request->getPathInfo(), $request->method())) {
                return;
            }
        }

        foreach ($guards as $guard) {
            if (Enforcer::guard($guard)->enforce($identifier, $request->getPathInfo(), $request->method())) {
                return Enforcer::shouldUse($guard);
            }
        }

        throw new UnauthorizedException();
    }
}
