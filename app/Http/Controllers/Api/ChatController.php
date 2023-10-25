<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\ChatMessage;
use App\Models\User;

class ChatController extends Controller
{
    public function index(){
        $messages =  Message::with('user')->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request){
        $user = User::Where('id', '=', auth()->id())->first();
        $message = $request->input('message');

        $messages = Message::create([
            'user_id'      => auth()->id(),
            'message'     => $message
        ]);

        broadcast(new ChatMessage($user, $message))->toOthers();

        return response()->json(['status' => "success", "data" => $messages]);
    }
}
