<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password', 'is_admin');

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $cookie = Cookie::make(
                'jwt_token', // Tên cookie
                $token,      // Giá trị token
                config('jwt.refresh_ttl'), // Thời gian sống của cookie (phút)
                '/',
                null,
                false,
                true,
                false,
                'Lax'
            );

            return response()->json([
                'status' => true,
                'message' => 'Login Successful',
                'access_token' => $token,
            ], 200)->withCookie($cookie);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }
    //
    public function logout()
    {
        JWTAuth::invalidate(request()->get('jwt_token'));
        $cookie = Cookie::forget('jwt_token');

        return response()->json([
            'message' => 'Successfully logged out',
        ])->withCookie($cookie);
    }
    //
    public function me()
    {
        /** @var \App\Models\Account $account */
        $account = auth()->user();
        if ($account->is_admin == 1) {
            $account = $account->load('administrators');
            $user = [
                'fullname' => $account->administrators[0]->fullname
            ];
        } else {
            $account = $account->load('customers');
            $user = [
                'fullname' => $account->customers[0]->fullname,
                'address' => $account->customers[0]->address,
                'phone' => $account->customers[0]->phone,
            ];
        }
        return response()->json([
            'message' => 'My info',
            'data' => [
                'email' => $account->email,
                'avatar' => $account->avatar,
                'is_admin' => $account->is_admin,
                'info' => $user,
            ],
        ], 200);
    }
    //
    public function refresh()
    {
        $oldToken = request()->get('jwt_token');
        JWTAuth::setToken($oldToken);
        $newToken = JWTAuth::refresh();

        JWTAuth::invalidate($oldToken);

        $cookie = Cookie::make(
            'jwt_token', // Tên cookie
            $newToken,      // Giá trị token
            config('jwt.refresh_ttl'), // Thời gian sống của cookie (phút)
            '/',
            null,
            false,
            true,
            false,
            'Lax'
        );
        return response()->json([
            'status' => true,
            'message' => 'Refresh token',
            'access_token' => $newToken,
        ], 200)->withCookie($cookie);
    }
}
