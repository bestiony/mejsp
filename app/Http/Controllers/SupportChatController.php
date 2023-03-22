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
        $admin=Admins::find(1);
        if($request->file){
            $file_name=$this->UploadFile($request->file);
        }
       $mesage= SupportChat::create([
            'user_email'=>$request->email,
            'message'=>$request->message,
            'admin_id'=>$admin->id,
            'sender'=>'user',
            'document'=>$file_name?? NULL
        ]);

        event(new SendMessage($request->message,$admin->id,$file_name??NULL));
    
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
            'id'=>$mesage->id,
        ];
        // Mail::to($admin->email)->send(new EmailSupportChat($info));
    }

    public function adminSendMessage(Request $request)
    {
        if($request->file){
            $file_name=$this->UploadFile($request->file);
        }
        $mesage= SupportChat::create([
            'user_email'=>$request->email,
            'message'=>$request->message,
            'admin_id'=>auth('admin')->user()->id,
            'sender'=>'admin',
            'document'=>$file_name?? NULL
        ]);
        event(new SendMessage($request->message,$request->email,$file_name??NULL));
        $info = [
            'mail_title' => 'يحاول الدعم التوصل معك',
            'mail_details1' => ': نص الرسالة هو',
            'status'=>5,
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
            'email' =>auth('admin')->user()->email,
            'subject'=>'التواصل مع مستخدم',
            'id'=>$mesage->id,
        ];
        // Mail::to($admin->email)->send(new EmailSupportChat($info));
    }

    function UploadFile($file)
    {
        $file_name=time().$file->getClientOriginalName();
        $file->move('email',$file_name);
        return $file_name;
         
    }
}
