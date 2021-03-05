<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request and test JWT
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            $message = 'Authorization Token not found';

            if ($e instanceof TokenInvalidException) {
                $message = 'Token is Invalid';
            } else if ($e instanceof TokenExpiredException) {
                if($request->getRequestUri() == '/api/v1/auth/refresh')
                {
                    return $next($request);
                }

                $message = 'Token is Expired';
            }

            return response()->json(['error' => true, 'message' => $message], 401);
        }

        return $next($request);
    }
}