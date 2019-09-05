<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
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
       $user=session('user');
        dd($user);
        if(!$user){
            return redirect('log');
        }else{
            return redirect('stock/create');
        }
        // return $next($request);
    }
}
