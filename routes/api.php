<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomePage;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Http\Request;
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

Route::get('/contacts', [ContactController::class, 'index']);
Route::get('/contacts/{id}', [ContactController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);



Route::group(['middleware' => ['jwt.auth']], function () {
    // Маршруты для контактов

    Route::post('/contacts', [ContactController::class, 'store']);
    Route::put('/contacts/{id}', [ContactController::class, 'update']);
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

    // Маршруты для продуктов

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Маршруты для клиентов

    Route::post('/clients', [ClientController::class, 'store']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

    // Маршруты для заказов

    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

});

