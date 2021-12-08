<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConvsersationsResources;
use App\Models\Chats;
use App\Models\Conversations;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    public function index(Request $request)
    {
        $conversations = Conversations::select('*')->where('conversation_id', $request->id)->orderBy('created_at', 'ASC')->get();
        return ConvsersationsResources::collection($conversations);
    }

    public function store(Request $request)
    {
        $conversations = new Conversations;
        $conversations->sender_id = $request->input('sender_id');
        $conversations->from_id = $request->input('from_id');

        $check_cId = Conversations::where('conversation_id', $request->input('conversation_id'))->first();
        $new_conversation_id = Conversations::orderBy('id', 'DESC')->pluck('id')->first();
        if ($check_cId == null or $check_cId =="") {
            $chats = new Chats;
            $chats->sender_id = $request->input('sender_id');
            $chats->from_id = $request->input('from_id');
            $chats->conversation_id = $new_conversation_id + 1;
            $chats->from_username = $request->input('from_username');
            $chats->sender_username = $request->input('sender_username');
            $chats->save();
            $conversations->conversation_id = $new_conversation_id + 1;
        } else {
            $conversations->conversation_id = $request->input('conversation_id');
        }
        $conversations->from_username = $request->input('from_username');
        $conversations->sender_username = $request->input('sender_username');
        $conversations->message = $request->input('message');
        $conversations->save();

        return null;
    }
}
