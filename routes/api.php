<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\productController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::group(['prefix' =>'v1/auth'], function(){
    Route::post('register',[AuthController::class, 'register']);
    Route::post('login',[AuthController::class, 'login']);
    
    Route::group(['middleware' => 'checktoken'], function(){
        Route::post('logout',[AuthController::class, 'logout']);
        
    });
});

Route::group(['prefix' =>'v1'], function(){
    Route::group(['middleware' => 'checktoken'], function(){
        Route::get('produk', [productController::class, 'getProduk']);
        Route::post('produk', [productController::class, 'createProduk']);
        Route::put('produk/{id}', [productController::class, 'editProduk']);
        Route::delete('produk/{id}', [productController::class, 'deleteProduk']);
    });
});