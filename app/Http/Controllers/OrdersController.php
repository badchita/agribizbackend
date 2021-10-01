<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Http\Resources\Orders as OrdersResource;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orders = $request->isMethod('put') ? Orders::findOrFail($request->id) : new Orders;

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

        if ($orders->save()) {
            return new OrdersResource($orders);
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = Orders::findOrFail($id);

        return new OrdersResource($orders);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orders = Orders::findOrFail($id);

        if ($orders->delete()) {
            return new OrdersResource($orders);
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($order_number)
    {
        return Orders::select('*')->where('order_number', 'LIKE', $order_number . '%')->get();
    }
}