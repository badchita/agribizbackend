<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Http\Resources\OrdersResources;

use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($seller_id=null, $status=null)
    {
        if ($status == 'O') {
            $orders = Orders::select('*')->where('status', $status)->where('seller_id', $seller_id)->get();
            return OrdersResources::collection($orders);
        } else if ($status == 'V') {
            $orders = Orders::select('*')->where('status', $status)->where('seller_id', $seller_id)->get();
            return OrdersResources::collection($orders);
        } else {
            $orders = Orders::select('*')->where('seller_id', $seller_id)->get();
            return OrdersResources::collection($orders);
        }
    }

    public function store(Request $request)
    {
        $orders = new Orders;
        $orders->id = $request->input('id');
        $orders->user_id = $request->input('user_id');
        $orders->seller_id = $request->input('seller_id');
        $orders->product_id = $request->input('product_id');
        $orders->ship_from_address_id = $request->input('ship_from_address_id');

        $unique_no = Orders::orderBy('id', 'DESC')->pluck('id')->first();
        if ($unique_no == null or $unique_no =="") {
            $unique_no = 1;
        } else {
            $unique_no = $unique_no + 1;
        }
        $orders->order_number = 'ORD'.$unique_no;

        $orders->product_total_price = $request->input('product_total_price');
        $orders->quantity = $request->input('quantity');
        $orders->ship_to_address_id = $request->input('ship_to_address_id');
        $orders->order_total_price = $request->input('order_total_price');
        $orders->status = 'O';
        $orders->order_status = '0';
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

    public function search($order_number, $seller_id)
    {
        $orders = Orders::select('*')->where('order_number', 'LIKE', $order_number . '%')->where('seller_id', $seller_id)->get();
        return OrdersResources::collection($orders);
    }

    public function updateStatus(Request $request)
    {
        Orders::where(['id' => $request->id])->update([
            'order_status' => $request->order_status,
        ]);
    }
}