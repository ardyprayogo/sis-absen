<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    // public function handle($request, Closure $next)
    // {
    //     if (Auth::guard('api')->check()) {
    //         return $next($request);
    //     } else {
    //         $message = [
    //             "success" => false,
    //             "message" => "Permission denied."
    //         ];
    //         return response($message, 401);
    //     }
    // }
}
