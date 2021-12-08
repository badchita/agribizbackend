<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatsResources;
use App\Http\Resources\UserResources;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function index(Request $request)
    {
        $chats = Chats::select('*')->where('sender_id', $request->id)->orwhere('from_id', $request->id)->orderBy('updated_at', 'DESC')->get();
        return ChatsResources::collection($chats);
    }

    public function search($username)
    {
        $users = User::select('*')->where('username', 'LIKE', $username . '%')->get();
        return UserResources::collection($users);
    }
}
