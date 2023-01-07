<?php

namespace App\Http\Middleware;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    //compare role from user table with role from request api
    public function handle(Request $request, Closure $next, $role)
    {
        $user = User::where('email', Auth::user()->email)->first();
        if ($user->role == $role) {
            return $next($request);
        }
        abort(401);
    }
}