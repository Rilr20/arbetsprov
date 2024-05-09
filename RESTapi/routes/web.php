<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/cart/items', 'CartController@AddItems');
Route::get('/cart', 'CartController@GetCart');
Route::put('/cart/items/{id}', "CartController@EditItem");
Route::delete('cart/items/{id}', "CartController@DeleteItem");