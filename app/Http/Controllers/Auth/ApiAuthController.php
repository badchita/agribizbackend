<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'type' => 'integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'integer|unique:users',
            'user_type' => 'string|max:255',
            'joined_date' => 'string|max:255',
            'username' => 'string|max:255',
            'birthday' => 'string|max:255',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $request['type'] = $request['type'] ? $request['type']  : 0;
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 401);
        }
        $status_verification = User::where('email', $request->email)->where('status_verification', 0)->first();
        if ($status_verification) {
            $response = ["message" =>'User Not Yet Approved By Admin. Please Wait For Approval'];
            return response($response, 405);
        }
        $status = User::where('email', $request->email)->where('status', 'V')->first();
        if ($status) {
            $response = ["message" =>'User Disabled'];
            return response($response, 404);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    User::where(['id'=> $user->id])->update([
                        'isOnline' => 1,
                    ]);
                    $response = [
                        'token' => $token,
                        'user_id' => $user->id,
                        'user_type' => $user->user_type,
                    ];
                    return response($response, 200);
                } else {
                    $response = ["message" => "Password Does Not Match"];
                    return response($response, 402);
                }
            } else {
                $response = ["message" =>'User does not exist'];
                return response($response, 403);
            }
        }

    }

    public function logout (Request $request) {
        // $token = $request->user()->token();
        // $token->revoke();
        User::where(['id'=> $request->user_id])->update([
            'isOnline' => 0,
        ]);
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}