<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResources;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $carts =  Cart::select('*')->where('status', 'O')->where('user_id', $user_id)->get();
        return CartResources::collection($carts);
    }

    public function store(Request $request)
    {
        $carts = new Cart;
        $carts->user_id = $request->input('user_id');
        $carts->product_id = $request->input('product_id');
        $carts->status = 'O';
        $carts->save();

        return null;
    }

    public function destroy($id)
    {
        $carts = Cart::findOrFail($id);

        if ($carts->delete()) {
            return new CartResources($carts);
        }

        return null;
    }
}