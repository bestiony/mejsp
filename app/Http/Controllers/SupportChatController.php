<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportChat;
use App\Events\SendMessage;
use App\Models\Admin\Admins;
use App\Mail\EmailSupportChat;
use Illuminate\Support\Facades\Mail;

class SupportChatController extends Controller
{
    public function userSendMessage(Request $request)
    {
        $admin=Admins::find(4);
        SupportChat::create([
            'user_email'=>$request->email,
            'message'=>$request->message,
            'admin_id'=>$admin->id,
            'sender'=>'user',
        ]);

    
        $info = [
            'mail_title' => 'يحاول مستخدم التوصل معك',
            'mail_details1' => ': نص الرسالة هو',
            'status'=>4,
            'mail_details2' => $request->message,
            'mail_details3' => '',
            'mail_details4' => '',
            'mail_details6'=>'',
            'mail_details7'=>'',
            'mail_details8'=>'',
            'mail_details5' => '',
            'id' => '',
            'file' =>  '',
            'journal' => '',
            'username' => '',
            'email' =>$request->email,
            'subject'=>'التواصل مع مستخدم',
            'id'=>'',
        ];
        Mail::to($admin->email)->send(new EmailSupportChat($info));
    }

    public function adminSendMessage()
    {
        event(new SendMessage('test','hosamdahab778@gmail.com'));
    }
}
