<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\forgotPasswordMail;
use App\Mail\RegisterMail;
use App\Models\Account;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
                $account = $account->load('customers.carts');
                $user = [
                    'fullname' => $account->customers[0]->fullname,
                    'address' => $account->customers[0]->address,
                    'phone' => $account->customers[0]->phone,
                    'has_carts' => count($account->customers[0]->carts),
                ];
            }
            return response()->json([
                'status' => true,
                'data' => [
                    'email' => $account->email,
                    'avatar' => $account->avatar,
                    'is_admin' => $account->is_admin,
                    ...$user,
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

    // dang ky tai kkhoan
    public function register()
    {

        try {
            $fullname = request('fullname');
            $email = request('email');
            $phone = request('phone');
            $address = request('address');
            $check = Account::where('email', $email)->first();
            if ($check) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid.',
                ], 400);
            }
            $password = Str::random(8);
            $account = Account::create([
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => 0,
                'avatar' => null,
            ]);
            Customer::create([
                'fullname' => $fullname,
                'phone' => $phone,
                'address' => $address,
                'account_id' => $account->id,
            ]);

            Mail::to($email)->send(new RegisterMail($fullname, $password));

            return response()->json([
                'status' => true,
                'message' => 'Store successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // quen mat khau
    public function forgotPassword()
    {

        try {
            $email = request('email');
            $account = Account::where('email', $email)->first();
            if (!$account) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid.',
                ], 400);
            }
            $password = Str::random(8);
            Account::where('email', $email)->update([
                'password' => Hash::make($password),
            ]);

            Mail::to($email)->send(new forgotPasswordMail($account->email, $password));

            return response()->json([
                'status' => true,
                'message' => 'Store successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // avatar 
    public function updateAvatar()
    {

        try {
            $file = request()->file('image');
            $extension = $file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', auth()->user()->id . '.' . $extension);
            Account::where('id', auth()->user()->id)->update([
                'avatar' => $path
            ]);

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
