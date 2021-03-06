<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Http\Resources\OrdersResources;
use App\Models\Dashboard;
use App\Models\NotificationsVendor;
use App\Models\Products;
use App\Models\User;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $seller_id = $request->user_id;
        $status = $request->status;
        $order_status = $request->order_status;

        if ($order_status !== null) {
            $orders = Orders::select('*')->where('status', $status)->where('seller_id', $seller_id)->where('order_status', $order_status)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
            return OrdersResources::collection($orders);
        } else {
            if ($status == 'O') {
                $orders = Orders::select('*')->where('status', $status)->where('seller_id', $seller_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
                return OrdersResources::collection($orders);
            } else if ($status == 'V') {
                $orders = Orders::select('*')->where('status', $status)->where('seller_id', $seller_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
                return OrdersResources::collection($orders);
            } else {
                $orders = Orders::select('*')->where('seller_id', $seller_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
                return OrdersResources::collection($orders);
            }
        }
    }
    public function indexAdmin(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $user_id = $request->user_id;
        $status = $request->status;
        $order_status = $request->order_status;
        if ($order_status !== null) {
            $orders = Orders::select('*')->where('status', $status)->where('seller_id', '!=', $user_id)->where('order_status', $order_status)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
            return OrdersResources::collection($orders);
        } else {
            if ($status == 'O') {
                $orders = Orders::select('*')->where('status', 'O')->where('seller_id', '!=', $user_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
                return OrdersResources::collection($orders);
            } else if ($status == 'V') {
                $orders = Orders::select('*')->where('status', 'V')->where('seller_id', '!=', $user_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
                return OrdersResources::collection($orders);
            } else {
                $orders = Orders::select('*')->where('seller_id', '!=', $user_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
                return OrdersResources::collection($orders);
            }
        }
    }

    public function indexCustomer(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $user_id = $request->user_id;
        if ($limit) {
            $orders = Orders::select('*')->where('user_id', $user_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
        return OrdersResources::collection($orders);
        } else {
            $orders = Orders::select('*')->where('user_id', $user_id)->orderBy("created_at", "DESC")->get();
        return OrdersResources::collection($orders);
        }

        // $response = ["offset" => $offset,
        //             "limit" => $request];
        // return response($response, 200);
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

        $notifications_vendor = new NotificationsVendor;
        $username = User::where('id', $request->user_id)->value('username');
        $notifications_vendor->user_id = $request->input('user_id');
        $notifications_vendor->order_id = $unique_no;
        $notifications_vendor->title = 'New Pending Order ORD'.$unique_no;
        $notifications_vendor->subject = 'Pending Order';
        $notifications_vendor->description = 'From: '.$username;
        $notifications_vendor->to_id = $request->input('seller_id');
        $notifications_vendor->from_id = $request->input('user_id');
        $notifications_vendor->status = 'O';
        $notifications_vendor->save();

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

    public function searchAll($order_number)
    {
        $orders = Orders::select('*')->where('order_number', 'LIKE', $order_number . '%')->get();
        return OrdersResources::collection($orders);
    }

    public function updateStatus(Request $request)
    {
        if ($request->order_status == '4') {
            $dashboard = Dashboard::where('id', $request->seller_id)->value('week_income');
            $product = Products::where('id', $request->product_id)->value('quantity');
            $week_income = $dashboard + $request->product_total_price;
            $quantity = $product - $request->quantity;
            Dashboard::where(['user_id' => $request->seller_id])->update([
                'week_income' => $week_income,
            ]);

            if ($quantity == 0) {
                Products::where(['id' => $request->product_id])->update([
                    'quantity' => $quantity,
                    'product_status' => 'Out Of Stocks',
                    'status' => 'V',
                ]);
            } else {
                Products::where(['id' => $request->product_id])->update([
                    'quantity' => $quantity,
                ]);
            }
        }

        if ($request->order_status == '1' || $request->order_status == '2' || $request->order_status == '3') {
            $username = User::where('id', $request->seller_id)->value('username');
            $notifications_vendor = new NotificationsVendor;
            if ($request->order_status == '1') {
                $title = 'Order Has Been Accepted';
                $subject = 'Order '.$request->order_number.' Has Been Accpeted By The Seller';
                $description = 'From: '.$username;
            } else if ($request->order_status == '2') {
                $title = 'Order Being Processed';
                $subject = 'Order '.$request->order_number.' Is Being Process For Shippment';
                $description = 'From: '.$username;
            } else if ($request->order_status == '3') {
                $title = 'Order Delivered';
                $subject = 'Order '.$request->order_number.' Has Been Delivered To You!';
                $description = 'From: '.$username;
            }
            $notifications_vendor->user_id = $request->input('user_id');
            $notifications_vendor->order_id = $request->order_id;
            $notifications_vendor->title = $title;
            $notifications_vendor->subject = $subject;
            $notifications_vendor->description = $description;
            $notifications_vendor->to_id = $request->input('user_id');
            $notifications_vendor->from_id = $request->input('seller_id');
            $notifications_vendor->status = 'O';
            $notifications_vendor->save();
        }

        if ($request->order_status == '-1') {
            $username = User::where('id', $request->user_id)->value('username');
            $notifications_vendor = new NotificationsVendor;

            $title = 'Order Has Been Cancelled';
            $subject = 'Order '.$request->order_number.' Has Been Cancelled';
            $description = 'From: '.$username;

            $notifications_vendor->user_id = $request->input('user_id');
            $notifications_vendor->order_id = $request->order_id;
            $notifications_vendor->title = $title;
            $notifications_vendor->subject = $subject;
            $notifications_vendor->description = $description;
            $notifications_vendor->to_id = $request->input('seller_id');
            $notifications_vendor->from_id = $request->input('user_id');
            $notifications_vendor->status = 'O';
            $notifications_vendor->save();
        }
        Orders::where(['id' => $request->id])->update([
            'order_status' => $request->order_status,
        ]);
    }
}