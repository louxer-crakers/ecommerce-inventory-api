<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function(){
    Route::get('products/search', [ProductController::class, 'search']);
    Route::post('products/update-stock', [ProductController::class, 'updateStock']);
    Route::get('inventory/value', [ProductController::class, 'inventoryValue']);

    Route::apiResource('categories', CategoryController::class)->only(['index', 'store']);
    Route::apiResource('products', ProductController::class);
});