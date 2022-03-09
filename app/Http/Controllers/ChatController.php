<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index($identifier){
        $messages = Chat::select('chat_sender', 'chat_reciever', 'chat_text')
                        ->where('chat_identifier', $identifier)
                        ->get();

        $users = Chat::leftjoin('users', 'users.personal', '=', 'chats.chat_sender')
                                ->where('id', Auth::id())
                                ->where('chat_identifier', $identifier)
                                ->select('chat_reciever', 'personal')
                                ->first();


        return view('message.message',['messages' => $messages, 'user_personal' => $users->personal, 'partner' => $users->chat_reciever, 'url' => $identifier]);

    }

    public function register(Request $request){

        $request->validate([
            'chat_identifier' => 'required',
            'chat_sender' => 'required|string',
            'chat_reciever' => 'required|string',
            'chat_text' => 'required|string|max:300'
        ]);

        $chat_identifier = $request->chat_identifier;

        Chat::create([
            'chat_identifier' => $chat_identifier,
            'chat_sender' => $request->chat_sender,
            'chat_reciever' => $request->chat_reciever,
            'chat_text' => $request->chat_text
        ]);

        return redirect("/message/${chat_identifier}");
    }
}
