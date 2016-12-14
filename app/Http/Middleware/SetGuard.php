<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetGuard
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
        $user = null;
        foreach(['admin','teacher','student'] as $guard){
            $user = Auth::guard($guard)->user();
            if($user)break;
        }
        $request->user=$user;
        return $next($request);
    }
}
