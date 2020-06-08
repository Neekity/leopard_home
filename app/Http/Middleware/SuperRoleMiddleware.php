<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
class SuperRoleMiddleware
{
    public function handle($request, Closure $next){
        if(!auth()->user()->hasAnyRole('超级管理员')){
            abort('401');
        }
        return $next($request);
    }
}