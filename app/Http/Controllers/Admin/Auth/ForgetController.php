<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Mail\ResetMail;
use App\Models\Admin\Admins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ForgetController extends Controller
{
    
    public function forget()
    {
        return view("admin.auth.forget");
    }
    public function send_mail(Request $request)
    {
        $request->validate(['email' => 'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',]);
        $email = $request->email;
        $fetchRow = Admins::select('email', 'verified_code', 'id')->where("email", $email)->first();
        $email = $fetchRow->email;
        $row_for_update = Admins::find($fetchRow->id);
        $code = $row_for_update->verified_code = rand(100000, 900000);
        $row_for_update->save();
        if (!empty($email)) {
            $info = ["link" => admin_url("reset-password/" . Crypt::encryptString($email)), 'code' => $code];
            Mail::to($email)->send(new ResetMail($info));
            $request->session()->flash("message", 'ستصلك رسالة على بريدك الإلكتروني خلال ثوان');
            return back();
        } else {
            $request->session()->flash("error", 'هذا البريد غير موجود رجاء التأكد مرة أخرى');
            return back();
        }
    }
    public function reset()
    {
        return view("admin.auth.reset");
    }
    public function update_password(Request $request, $email_hash)
    {
        $request->validate(['email' => 'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/', 'password' => 'required|min:6|max:255', 'code' => 'required']);
        try {
            $email = $request->email;
            $password = $request->password;
            $code = $request->code;
            $decrypt = Crypt::decryptString($email_hash);
            $getRowFromDB = Admins::select("email", 'verified_code', 'id')->where("email", $email)->get();
            $id = $getRowFromDB->pluck('id');
            $verified_code = $getRowFromDB->pluck('verified_code')[0];
            $row = Admins::find($id[0]);
            if ($decrypt == $email) {
                if ($verified_code == $code) {
                    $row->password = Hash::make($password);
                    $row->verified_code = NULL;
                    if ($row->save()) {
                        return redirect()->to('/' . adminPrefix());
                    }
                } else {
                    $request->session()->flash("error", 'يرجى التحقق من الكود المرفق في البريد');
                    return back();
                }
            } else {
                $request->session()->flash("error", 'خطأ يرجي التحقق من البريد وإعادة المحاولة');
                return back();
            }
        } catch (DecryptException $e) {
            $request->session()->flash("error", 'خطأ في تحديث البيانات حاول مرة أخرى');
            return back();
        }
    }


}
