<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use Closure;
use Illuminate\Http\Request;

class iSLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->hasHeader('Authorization')) {
            if (!AuthController::isTokenValid($request->header('Authorization'))) {
                return $next($request);
            } else {

                AuthController::refreshToken($request->header('Authorization'));
                if (true) {
                } else {
                    return response(['error' => "cannot refresh token try to log in again please "], 401);
                }
            }
        } else {
            return response(['error' => "No Bearer token found in header"], 401);
        }
    }
}
