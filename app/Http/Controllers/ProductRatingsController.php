<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRatings;
use App\Http\Resources\ProductRatingResources;
use App\Models\NotificationsVendor;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;

class ProductRatingsController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $product_id = $request->product_id;

        $product_rating = ProductRatings::select('*')->where('product_id', $product_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
        return ProductRatingResources::collection($product_rating);
    }

    public function store(Request $request)
    {
        $product_rating = new ProductRatings;
        $product_rating->user_id = $request->input('user_id');
        $product_rating->product_id = $request->input('product_id');
        $product_rating->anonymous = $request->input('anonymous');
        $product_rating->review = $request->input('review');
        $product_rating->rating = $request->input('rating');

        $product_rating->save();

        $order_id = $request->order_id;
        Orders::where(['id' => $order_id])->update([
            'rated' => 1,
        ]);

        $notifications_vendor = new NotificationsVendor;
        $seller_id = Products::where('id', $request->product_id)->value('user_id');
        $username = User::where('id', $request->user_id)->value('username');
        $notifications_vendor->user_id = $request->input('user_id');
        $notifications_vendor->product_id = $request->input('product_id');
        $notifications_vendor->title = 'New Product Review';
        $notifications_vendor->subject = 'Someone Reviewed Your Product';
        $notifications_vendor->description = 'From: '.$username;
        $notifications_vendor->to_id = $seller_id;
        $notifications_vendor->from_id = $request->input('user_id');
        $notifications_vendor->status = 'O';
        $notifications_vendor->save();

        $response = ["message" =>'Review Added!'];
        return response($response, 200);
    }
}