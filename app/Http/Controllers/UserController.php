<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResources;

class UserController extends Controller
{
    public function index ($user_id) {
        $users = User::select('*')->where('id', '!=', $user_id)->get();
        return UserResources::collection($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return new UserResources($user);
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
    }
}
