<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AdminLoggedInChecking {
    public function handle(Request $request, Closure $next)
    {
        if(Session()->has('login_status') && (url('adminloginpage')==$request->url() || url('adminregisterpage')==$request->url())){
            return back();
        }
        return $next($request);
    }
}