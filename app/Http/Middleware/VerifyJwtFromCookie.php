<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJwtFromCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated. Token not found.',
            ], 401);
        }
        try {
            $user = JWTAuth::setToken($token)->authenticate();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated. User not found.',
                ], 401);
            }
            auth()->setUser($user);
            $request->merge(['jwt_token' => $token]);
        } catch (TokenExpiredException $e) {
            if ($request->route()->getName() === 'auth.refresh') {
                $request->merge(['jwt_token' => $token]);
                return $next($request);
            }

            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated. Token has expired.',
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated. Token is invalid.',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated. Token error.',
            ], 401);
        }
        return $next($request);
    }
}
