<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\POSController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::apiResource('/employee',EmployeeController::class);
Route::apiResource('/supplier',SupplierController::class);
Route::apiResource('/category',CategoryController::class);
Route::apiResource('/product',ProductController::class);
Route::apiResource('/customer',CustomerController::class);

Route::get('/getting/product/{id}',[POSController::class,'subProduct']);
Route::get('/addToCart/{id}',[CartController::class,'addToCart']);
Route::get('/remove/cart/{id}',[CartController::class,'removeFromCart']);
Route::get('/cart/product',[CartController::class,'cartProduct']);
Route::get('/increment/{id}',[CartController::class,'increment']);
Route::get('/decrement/{id}',[CartController::class,'decrement']);
Route::get('/vats',[CartController::class,'vats']);
Route::post('/orderdone',[POSController::class,'OrderDone']);
Route::get('/orders',[OrderController::class,'orders']);
Route::get('/order/customer/{id}',[OrderController::class,'OrderCustomer']);
Route::get('/order/details/{id}',[OrderController::class,'OrderDetails']);
Route::post('/order/search',[OrderController::class,'OrderSearch']);
Route::get('/today/sell',[POSController::class,'TodaySell']);
Route::get('/today/earning',[POSController::class,'TodayEarning']);
Route::get('/pro/StockOut',[POSController::class,'StockOut']);
