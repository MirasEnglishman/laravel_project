<?php

use App\Http\Controllers\HomePage;
use Illuminate\Support\Facades\Route;

// Маршруты для страницы контактов
Route::get('/admin', \App\Http\Controllers\AdminController::class);


// Главная страница
Route::get('/', function () {
    return view('welcome');
});
