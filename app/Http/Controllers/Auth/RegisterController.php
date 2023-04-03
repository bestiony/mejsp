<?php

namespace App\Http\Controllers\Auth;
use App\Models\Settings;
use App\Http\Controllers\Controller;
use App\Models\Freelancers;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscribers;
class RegisterController extends Controller
{


    // Display Login Page For Admin
    public function index()
    {
        return view("main.auth.register");
    }


    public function create(Request $request)
    {

        $setting = Settings::first();
        $front_sections = $setting->sections_status ? json_decode($setting->sections_status,true) : null ;
        $rules =[
            'name'     => 'required|max:100',
            'email'    => 'required|unique:users,email|max:200|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',
            'password' => 'required|min:6|max:255'
        ];
        $errors_translations =[
            // Name
            'name.required' => 'هذا الحقل مطلوب',
            'name.max' => 'يجب ان لا يتعدي الاسم 100 حرف',
            'name.regex' => 'صيغة الاسم غير صحيحة',
            // email
            'email.required' => 'هذا الحقل مطلوب',
            'email.unique' => 'البريد الالكتروني تم استخدامة من قبل',
            'email.max' => 'يجب ان لا يتعدي الاسم 200 حرف',
            'email.regex' => 'صيغة البريد الالكتروني غير صحيحة',
            // phone
            'phone.required' => 'هذا الحقل مطلوب',
            'phone.regex' => 'صيغة رقم الهاتف غير صحيحة',
            'phone.unique' => 'رقم الهاتف تم استخدامة من قبل',
            // password
            'password.required' => 'هذا الحقل مطلوب',
            'password.min' => 'يجب ان لا يقل عن 6 احرف',
            'password.max' => 'يجب ان لا يتعدي عن 255 حرف',
        ];

        if($front_sections['signup_phone'] == 1){
            $rules['phone'] = 'required|unique:users,phone|regex:/[0-9]/|numeric|digits_between:8,14';
        }
        // validate
        $request->validate($rules, $errors_translations );


        // Inputs
        $name      = $request->name;
        $email     = $request->email;
        $phone     = $request->phone;
        $password  = $request->password;

        $insert = User::create([
            'name'     => formatText($name),
            'email'    => $email,
            'phone'    => $phone,
            'password' => Hash::make($password),
            'created_at' => date('Y-m-d')
        ]);
        Subscribers::create(['email'=>$email]);

        if ($insert->save()) {

            if (Auth::guard("user")->attempt(["email" => $email, "password" => $password], true)) {

                return redirect(userPrefix() . "/dashboard");
            } else {

                $request->session()->flash("auth_error_message", 'خطأ في البريد الإلكتروني أو كلمة المرور');
                return back();
            }
        }
    }
}
