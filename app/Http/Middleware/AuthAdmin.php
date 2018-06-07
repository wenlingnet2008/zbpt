<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
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
        if(Auth::check()){
            $user = $request->user();
            if(!$user->can('admin_login')){
                return redirect()->guest(route('admin.login'))->withErrors(['email'=>'没有访问权限']);
            }
        }else{
            return redirect()->guest(route('admin.login'));
        }
        return $next($request);
    }
}
