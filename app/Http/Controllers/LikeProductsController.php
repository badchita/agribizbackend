<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikeProducts;
use App\Http\Resources\LikeProductsResources;

class LikeProductsController extends Controller
{
    public function index($user_id=null, $status=null)
    {

    }

    public function all($product_id=null, $user_id=null)
    {
        // if ($user_id == null)
        //     return LikeProducts::select('*')->where('status', 'O')->where('product_id', $product_id)->get();
        // else
            return LikeProducts::select('*')->where('status', 'O')->where('product_id', $product_id)->get();

    }

    public function store(Request $request)
    {
        $like_products = new LikeProducts;
        $like_products->product_id = $request->input('product_id');
        $like_products->user_id = $request->input('user_id');
        $like_products->status = $request->input('status');
        $like_products->save();

        return null;
    }

    public function archive(Request $request)
    {
        LikeProducts::where(['id' => $request->id])->update([
            'status' => $request->status,
        ]);
    }
}
