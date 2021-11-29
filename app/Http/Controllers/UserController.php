<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResources;

class UserController extends Controller
{
    public function index (Request $request) {
        $status = $request->status;
        $user_id = $request->user_id;
        if ($status == 'O') {
            $users = User::select('*')->where('status', $status)->where('id', '!=', $user_id)->get();
            return UserResources::collection($users);
        } else if ($status == 'V') {
            $orders = User::select('*')->where('status', $status)->where('id', '!=', $user_id)->get();
            return UserResources::collection($orders);
        } else {
            $orders = User::select('*')->where('id', '!=', $user_id)->get();
            return UserResources::collection($orders);
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        return new UserResources($user->loadMissing(['products'])->loadMissing(['addresses']));
    }

    public function update(Request $request)
    {
        User::where(['id' => $request->id])->update([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'mobile' => $request->mobile,
            'user_type' => $request->user_type,
            'joined_date' => $request->joined_date,
            'username' => $request->username,
            'address_id' => $request->address_id,
        ]);

        $user = User::find($request->id);

        return new UserResources($user->loadMissing(['products'])->loadMissing(['addresses']));
    }

    public function archive(Request $request)
    {
        User::where(['id' => $request->id])->update([
            'status' => $request->status,
        ]);
    }

    public function search($name, $user_id)
    {
        $users = User::select('*')->where('name', 'LIKE', $name . '%')->where('id', '!=', $user_id)->get();
        return UserResources::collection($users);
    }

    public function updateStatusVerification(Request $request)
    {
        User::where(['id' => $request->id])->update([
            'status_verification' => $request->status_verification,
        ]);

        $user = User::find($request->id);

        return new UserResources($user->loadMissing(['products'])->loadMissing(['addresses']));
    }
}