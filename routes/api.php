<?php

use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ReviewController;

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
    Route::get('/food', [FoodController::class, 'getFood']);

    Route::get('/categories', [CategoryController::class, 'getCategories']);

    Route::get('/customers', [CustomerController::class, 'getCustomers']);

    Route::get('/cart', [CartController::class, 'getCart'])->middleware('jwt.cookie');

    Route::get('/coupons', [CouponController::class, 'getCoupons']);

    Route::get('/orders', [OrderController::class, 'getOrders']);

    Route::get('/order-status', [OrderStatusController::class, 'getOrderStatus']);

    Route::get('/reviews', [ReviewController::class, 'getReviews']);
});
Route::prefix('/update')->group(function () {
    Route::patch('/account-status', [AccountController::class, 'updateAccountStatus']);

    Route::patch('/food-status', [FoodController::class, 'updateFoodStatus']);
    Route::put('/foods', [FoodController::class, 'updateFoods']);

    Route::patch('/cart', [CartController::class, 'updateCart']);

    Route::patch('/coupon-status', [CouponController::class, 'updateCouponStatus']);

    Route::patch('/order-status', [OrderController::class, 'updateOrderStatus']);
    Route::put('/cancel-order', [OrderController::class, 'cancelOrder']);

    Route::patch('/disable-review', [ReviewController::class, 'disableReview']);
});
Route::prefix('/store')->group(function () {
    Route::post('/food', [FoodController::class, 'storeFood']);

    Route::post('/cart', [CartController::class, 'storeCart'])->middleware('jwt.cookie');

    Route::post('/order', [CartController::class, 'storeOrder']);

    Route::post('/coupon', [CouponController::class, 'storeCoupon']);

    Route::post('/feedback', [FeedbackController::class, 'storeFeedback']);
});
Route::prefix('/delete')->group(function () {
    Route::delete('/feedback', [FeedbackController::class, 'deleteFeedback']);

    Route::delete('/carts', [CartController::class, 'deleteCarts']);
});
