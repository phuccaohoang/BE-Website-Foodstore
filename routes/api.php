<?php

use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

Route::middleware('jwt.cookie')->group(function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/update/avatar', [AuthController::class, 'updateAvatar']);

    Route::post('/auth/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');

    Route::get('/me', [AuthController::class, 'me']);

    Route::patch('/auth/update-password', [AuthController::class, 'updatePassword']);
});

Route::post('/call-chatbot', [ChatbotController::class, 'callAIChat']);

Route::prefix('/get')->group(function () {

    Route::get('/foods', [FoodController::class, 'getFoods']);
    Route::get('/food', [FoodController::class, 'getFood']);

    Route::get('/categories', [CategoryController::class, 'getCategories']);

    Route::get('/order-status', [OrderStatusController::class, 'getOrderStatus']);


    Route::get('/reviews', [ReviewController::class, 'getReviews']);


    Route::get('/statistics-foods', [OrderDetailController::class, 'statisticsFoods']);
    Route::get('/statistics-foods-not-order', [OrderDetailController::class, 'statisticsFoodsNotOrder']);

    Route::get('/statistics-customers', [OrderController::class, 'statisticsCustomers']);

    Route::get('/statistics-orders', [OrderController::class, 'statisticsOrders']);

    Route::get('/statistics-revenue', [OrderController::class, 'statisticsRevennue']);
});

Route::middleware('jwt.cookie')->group(function () {

    Route::prefix('/get')->group(function () {
        Route::get('/accounts', [AccountController::class, 'getAccounts']);

        Route::get('/customers', [CustomerController::class, 'getCustomers']);

        Route::get('/cart', [CartController::class, 'getCart']);
        Route::get('/cart-payment', [CartController::class, 'getCartPayment']);

        Route::get('/coupons', [CouponController::class, 'getCoupons']);

        Route::get('/coupons-customer', [CouponController::class, 'getCouponsCustomer']);

        Route::get('/orders', [OrderController::class, 'getOrders']);
    });

    Route::prefix('/update')->group(function () {
        Route::patch('/account-status', [AccountController::class, 'updateAccountStatus']);

        Route::put('/customer', [CustomerController::class, 'updateCustomer']);

        Route::patch('/food-status', [FoodController::class, 'updateFoodStatus']);
        Route::put('/foods', [FoodController::class, 'updateFoods']);
        Route::post('/food', [FoodController::class, 'updateFood']);

        Route::put('/category', [CategoryController::class, 'updateCategory']);

        Route::patch('/cart', [CartController::class, 'updateCart']);

        Route::patch('/coupon-status', [CouponController::class, 'updateCouponStatus']);

        Route::patch('/order-status', [OrderController::class, 'updateOrderStatus']);
        Route::put('/cancel-order', [OrderController::class, 'cancelOrder']);

        Route::patch('/disable-review', [ReviewController::class, 'disableReview']);
    });

    Route::prefix('/store')->group(function () {
        Route::post('/food', [FoodController::class, 'storeFood']);

        Route::post('/category', [CategoryController::class, 'storeCategory']);

        Route::post('/cart', [CartController::class, 'storeCart']);

        Route::post('/order', [OrderController::class, 'storeOrder']);

        Route::post('/coupon', [CouponController::class, 'storeCoupon']);

        Route::post('/feedback', [FeedbackController::class, 'storeFeedback']);

        Route::post('/review', [ReviewController::class, 'storeReview']);
    });

    Route::prefix('/delete')->group(function () {
        Route::delete('/feedback', [FeedbackController::class, 'deleteFeedback']);

        Route::delete('/carts', [CartController::class, 'deleteCarts']);
    });
});
