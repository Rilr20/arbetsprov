<?php

use App\Http\Controllers\CartController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/token', function () {
    // return view('welcome');
    $token = csrf_token();
    return response()->json(['token' => $token]);
});

Route::post('/cart/items', [CartController::class, 'AddItems'])->middleware(Authenticate::class);
Route::get('/cart', [CartController::class, 'GetCart'])->middleware(Authenticate::class);
Route::put('/cart/items/{id}', [CartController::class, 'EditItem'])->middleware(Authenticate::class);
Route::delete('cart/items/{id}', [CartController::class, 'DeleteItem'])->middleware(Authenticate::class);
