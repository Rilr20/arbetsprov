<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/cart/items', [CartController::class, 'AddItems']);
Route::get('/cart', [CartController::class, 'GetCart']);
Route::put('/cart/items/{id}', [CartController::class, 'EditItem']);
Route::delete('cart/items/{id}', [CartController::class, 'DeleteItem']);
