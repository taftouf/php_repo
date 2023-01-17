<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

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

    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'invalid-token'
                ], 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                try{
                    return response()->json([
                        'success' => false,
                        'status' => 401,
                        'message' => 'token-expired',
                        'access_token' => auth()->refresh(),
                        'token_type' => 'bearer',
                        'expires_in' => auth()->factory()->getTTL()
                    ], 401);
                } catch (\Exception $e) {
                    if($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException)
                        return response()->json([
                            'success' => false,
                            'status' => 400,
                            'message' => 'token-blacklisted'
                        ], 400);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'token-not-found'
                ], 401);
            }
        }
        
        if (!Auth::guard('api')->check()) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Bad authorization',
                'data' => []
            ], 401);
        }
        return $next($request);
    }
}
