<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;


class AdminAuthentication {
    public function handle(Request $request, Closure $next)
    {
        if(!Session()->has('login_status')){
            return redirect('adminloginpage')->with('fail','Please Login First');
        }
        return $next($request);
    }
}