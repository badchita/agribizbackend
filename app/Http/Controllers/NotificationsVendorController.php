<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsVendorResources;
use App\Models\NotificationsVendor;
use Illuminate\Http\Request;

class NotificationsVendorController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $to_id = $request->to_id;
        $status = $request->status;
        if ($status == 'O') {
            $notifications_vendor = NotificationsVendor::select('*')->where('status', $status)->where('to_id', $to_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
            return NotificationsVendorResources::collection($notifications_vendor);
        } else if ($status == 'V') {
            $notifications_vendor = NotificationsVendor::select('*')->where('status', $status)->where('to_id', $to_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
            return NotificationsVendorResources::collection($notifications_vendor);
        } else {
            $notifications_vendor = NotificationsVendor::select('*')->where('to_id', $to_id)->offset($offset)->limit($limit)->orderBy("created_at", "DESC")->get();
            return NotificationsVendorResources::collection($notifications_vendor);
        }
    }

    public function store(Request $request)
    {
        $notifications_vendor = new NotificationsVendor;
        $notifications_vendor->user_id = $request->input('user_id');
        $notifications_vendor->product_id = $request->input('product_id');
        $notifications_vendor->order_id = $request->input('order_id');
        $notifications_vendor->address_id = $request->input('address_id');
        $notifications_vendor->title = $request->input('title');
        $notifications_vendor->content = $request->input('content');
        $notifications_vendor->description = $request->input('description');
        $notifications_vendor->subject = $request->input('subject');
        $notifications_vendor->status = 'O';
        $notifications_vendor->from_id = $request->input('from_id');
        $notifications_vendor->to_id = $request->input('to_id');
        $notifications_vendor->markRead = $request->input('markRead');

        $notifications_vendor->save();

        return null;
    }

    public function update(Request $request)
    {
        NotificationsVendor::where(['id' => $request->id])->update([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'address_id' => $request->address_id,
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'subject' => $request->subject,
            'from_id' => $request->from_id,
            'status' => $request->status,
            'to_id' => $request->to_id,
        ]);
    }

    public function markAsRead(Request $request)
    {
        NotificationsVendor::where(['id' => $request->id])->update([
            'markRead' => $request->markRead,
        ]);

        $response = ["message" =>'1'];
        return response($response, 200);
    }

    public function updateNew(Request $request)
    {
        NotificationsVendor::where(['to_id' => $request->to_id])->update([
            'new' => 0,
        ]);

        $response = ["message" =>'1'];
        return response($response, 200);
    }

    public function show($id)
    {
        $notifications_vendor = NotificationsVendor::find($id);

        return new NotificationsVendorResources($notifications_vendor);
    }
}
