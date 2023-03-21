<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportChat;
use App\Events\SupportChatEvent;

class SupportChatController extends Controller
{
    public function userSendMessage(Request $request)
    {
        SupportChat::create([
            'user_email'=>$request->email,
            'message'=>$request->message,
            'admin_id'=>4,
            'sender'=>'user',
        ]);
    }

    public function adminSendMessage()
    {
       return event(new SupportChatEvent('hosamdahab778@gmail.com','test push'));
    }
}
