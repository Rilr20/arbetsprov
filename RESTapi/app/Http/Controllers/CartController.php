<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    //
    public function AddItems(Request $request) {
        $cart = new Cart;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json($cart, 201);
    }
    public function GetCart() {
        return response()->json("hi"); 
    }
    public function EditItem(Request $request, string $id) {
        try {
            $cart = Cart::where('product_id', $id)->firstOrFail();
            $cart->quantity = $request->quantity;
            $cart->save();
            return response()->json($cart, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => "Product is not in cart"], 400);
        }

    }
    public function DeleteItem(string $id) {
        try {
            $cart = Cart::where('product_id', $id)->firstOrFail();
            $cart->delete();
            return response()->json(['success' => 'product deleted'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => "Product is not in cart"], 400);
        }
    }
}
