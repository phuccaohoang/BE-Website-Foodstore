<?php

use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FoodController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/auth/login', [AuthController::class, 'login']);


Route::middleware('jwt.cookie')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/auth/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');

    Route::get('/me', [AuthController::class, 'me']);
});

Route::prefix('/get')->group(function () {
    Route::get('/accounts', [AccountController::class, 'getAccounts']);

    Route::get('/foods', [FoodController::class, 'getFoods']);

    Route::get('/coupons', [CouponController::class, 'getCoupons']);

    Route::get('/orders', [CouponController::class, 'getOrders']);
});
Route::prefix('/update')->group(function () {
    Route::patch('/account-status', [AccountController::class, 'updateAccountStatus']);

    Route::patch('/food-status', [FoodController::class, 'updateFoodStatus']);
    Route::put('/foods', [FoodController::class, 'updateFoods']);

    Route::patch('/coupon-status', [CouponController::class, 'updateCouponStatus']);

    Route::patch('/order-status', [CouponController::class, 'updateOrderStatus']);
    Route::put('/cancel-order', [CouponController::class, 'cancelOrder']);

    Route::patch('/disable-review', [CouponController::class, 'disableReview']);
});
Route::prefix('/store')->group(function () {
    Route::post('/food', [FoodController::class, 'storeFood']);

    Route::post('/coupon', [CouponController::class, 'storeCoupon']);
});
