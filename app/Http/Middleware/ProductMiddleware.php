<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\SmGeneralSettings;
use App\Envato\Envato;
use GuzzleHttp\Client;
use App\User;

class ProductMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (User::checkAuth() == false || User::checkAuth() == null) {
            return redirect()->route('system.config');
        } else {
            return $next($request);
        }
    }
}
