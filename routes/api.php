<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты (без авторизации и без проверки роли)
Route::get('/', function () {
    return view('welcome');
});

// Публичные маршруты для аутентификации
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
Route::get('me', [AuthController::class, 'me']);

// Маршруты для просмотра данных
Route::get('/products', [ProductController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);


// Маршруты для администраторов и модераторов
Route::group(['middleware' => ['jwt.auth']], function () {

    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::post('/orders', [OrderController::class, 'store']);


    // Для модераторов
    Route::group(['middleware' => ['role:moderator']], function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });
});
