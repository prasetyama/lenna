<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatMessage;
use Session;
use App\Models\User;

class ChatController extends Controller
{
    public function __construct(){
        $this->middleware('check.login');
    }

    public function index(){
        return view('chat');
    }

    public function fetchMessages(){
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request){
        $user = User::Where('id', '=', Session::get('user'))->first();
        $message = $request->input('message');

        $messages = Message::create([
            'user_id'      => $request->input('user'),
            'message'     => $message
        ]);

        broadcast(new ChatMessage($user, $message))->toOthers();
        return ['status' => 'Message Sent!'];
    }
}

