<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password', 'is_admin');
        $credentials['status'] = 1;

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
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //
    public function logout()
    {
        try {

            JWTAuth::invalidate(request('jwt_token'));
            $cookie = Cookie::forget('jwt_token');

            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out',
            ])->withCookie($cookie);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //
    public function me()
    {
        try {
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
                'status' => true,
                'data' => [
                    'email' => $account->email,
                    'avatar' => $account->avatar,
                    'is_admin' => $account->is_admin,
                    'info' => $user,
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //
    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh();

            $oldToken = request('jwt_token');
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
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // thay doi mat khau
    public function updatePassword()
    {
        try {
            $account = auth()->user();
            $account_id = $account->id;
            $password = request('password');
            $oldPassword = request('old_password');

            Account::where('id', $account_id)->update([
                'password' => Hash::make($password),
            ]);

            if (!Hash::check($oldPassword, $account->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mật khẩu cũ không chính xác.',
                ], 400);
            }
            if (Hash::check($password, $account->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mật khẩu mới không được trùng với mật khẩu cũ.',
                ], 400);
            }


            return response()->json([
                'status' => true,
                'message' => 'Updated successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
