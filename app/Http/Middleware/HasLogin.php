<?php

namespace App\Http\Middleware;

use Auth,Closure,Json,Route;

class HasLogin
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
        $user=$request->user;
        if($user&&$user->id>0){
            return $next($request);
        }else{
            if($request->expectsJson()){
                return Json::response(12);
            }else{
                return response()->redirectToRoute('user:login');
            }
        }
    }
}
