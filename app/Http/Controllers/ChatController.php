<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index($identifier){
        $messages = Chat::select('chat_personal', 'chat_partner_personal', 'chat_text')
                        ->where('chat_identifier', $identifier)
                        ->get();

        $user_personal = User::where('id', Auth::id())
                             ->value('personal');

        foreach($messages as $message){
            if($message->chat_personal == $user_personal){
                $partner_name = $message->chat_partner_personal;
                break;
            }elseif($message->chat_personal ==$message->chat_partner_personal ){
                $partner_name = $user_personal;
                break;
            }
        }

        return view('message.message',['messages' => $messages, 'personal' => $user_personal, 'partner' => $partner_name]);

    }

    public function register(){
        return redirect('/home');
    }
}
