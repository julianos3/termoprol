<?php

namespace AgenciaS3\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OperatorPatnerRedirectlAuthenticated
{
    /**
     * @param $request
     * @param Closure $next
     * @param string $guard
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, $guard = 'trading_partners')
    {
        /*
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('broker.login');
        }
        */

        if (Auth::guard($guard)->check()) {
            //return redirect()->route('broker.home');
        }


        return $next($request);
    }
}
