<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Http\Resources\OrdersResources;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product_price=null)
    {
        if ($product_price == 'O') {
            return Orders::select('*')->where('product_price', 'O')->get();
        } else if ($product_price == 'V') {
            return Orders::select('*')->where('product_price', 'V')->get();
        } else {
            return Orders::all();
        }
        // return Products::select('*')->where('product_price', 'V')->get();

        // return ProductsResource::collection($products);
    }

    public function store(Request $request)
    {
        $orders = new Orders;
        $orders->id = $request->input('id');
        $orders->user_id = $request->input('user_id');
        $orders->product_id = $request->input('product_id');
        $orders->ship_from_address_id = $request->input('ship_from_address_id');
        $orders->order_number = $request->input('order_number');
        $orders->product_name = $request->input('product_name');
        $orders->product_price = $request->input('product_price');
        $orders->quantity = $request->input('quantity');
        $orders->ship_from_address = $request->input('ship_from_address');
        $orders->ship_to_address = $request->input('ship_to_address');
        $orders->shipping_fee = $request->input('shipping_fee');
        $orders->order_total_price = $request->input('order_total_price');
        $orders->status = $request->input('status');
        $orders->order_status = $request->input('order_status');
        $orders->save();

        return null;
    }

    public function update(Request $request)
    {
        Orders::where(['id' => $request->id])->update([
            'product_id' => $request->product_id,
            'ship_from_address_id' => $request->ship_from_address_id,
            'order_number' => $request->order_number,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_status' => $request->product_status,
            'quantity' => $request->quantity,
            'ship_from_address' => $request->ship_from_address,
            'ship_to_address' => $request->ship_to_address,
            'shipping_fee' => $request->shipping_fee,
            'order_total_price' => $request->order_total_price,
            'status' => $request->status,
            'order_status' => $request->order_status,
            'user_id' => $request->user_id,
        ]);
    }

    public function archive(Request $request)
    {
        Orders::where(['id' => $request->id])->update([
            'status' => $request->status,
        ]);
    }

    public function show($id)
    {
        $orders = Orders::findOrFail($id);

        return new OrdersResources($orders);
    }

    public function destroy($id)
    {
        $orders = Orders::findOrFail($id);

        if ($orders->delete()) {
            return new OrdersResources($orders);
        }

        return null;
    }

    public function search($order_number)
    {
        return Orders::select('*')->where('order_number', 'LIKE', $order_number . '%')->get();
    }
}