<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты (без авторизации и без проверки роли)
Route::get('/', function () {
    return view('welcome');
});

// Публичные маршруты для аутентификации
Route::post('login', [AuthController::class, 'login']);      // Логин
Route::post('logout', [AuthController::class, 'logout']);    // Логаут
Route::post('register', [AuthController::class, 'register']); // Регистрация
Route::post('me', [AuthController::class, 'me']);            // Текущий пользователь

// Маршруты для просмотра данных
Route::get('/products', [ProductController::class, 'index']);
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

// Маршруты для администраторов и модераторов
Route::group(['middleware' => ['jwt.auth']], function () {
    // Для администраторов
    Route::group(['middleware' => ['role:admin']], function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        Route::post('/clients', [ClientController::class, 'store']);
        Route::put('/clients/{id}', [ClientController::class, 'update']);
        Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

        Route::post('/orders', [OrderController::class, 'store']);
        Route::put('/orders/{id}', [OrderController::class, 'update']);
        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });

    // Для модераторов
    Route::group(['middleware' => ['role:moderator']], function () {
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        Route::put('/orders/{id}', [OrderController::class, 'update']);
        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
    });
});
