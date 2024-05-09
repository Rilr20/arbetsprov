<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    //
    const MOMS = 0.25;
    public function AddItems(Request $request) {
        try {
            $cart = Cart::where('product_id', $request->product_id)->first();
            if ($cart == NULL) {
                $cart = new Cart;
                $cart->product_id = $request->product_id;
                $cart->quantity = $request->quantity;
                $cart->save();
            } else {
                $cart->quantity += $request->quantity;
                $cart->save();
            }
        
            $cart = DB::table('products')
                ->select('products.product_name', 'products.price', 'cart.product_id', 'cart.quantity')
                ->leftJoin('cart', 'cart.product_id', '=', 'products.id')
                ->get();
            
            list($totalPrice, $moms) = self::CalculatePrice($cart);

            return response()->json([
                'totalPrice' => $totalPrice,
                'moms' => $moms,
                'cart' =>$cart
            ]);
            } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Product id does not exist'], 400);
        }
    }
    public function GetCart() {
        $cart = DB::table('products')
            ->select('products.product_name', 'products.price', 'cart.product_id', 'cart.quantity')
            ->leftJoin('cart', 'cart.product_id', '=', 'products.id')
            ->get();
        
        list($totalPrice, $moms) = self::CalculatePrice($cart);

        return response()->json([
            'totalPrice' => $totalPrice,
            'moms' => $moms,
            'cart' =>$cart
        ]);
    }
    private function CalculatePrice($cart) {
        $totalPrice = 0;
        foreach ($cart as $key => $value) {
            $totalPrice += ($value->price * $value->quantity);
        }
        $moms = $totalPrice * self::MOMS;
        return [$totalPrice, $moms];
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
