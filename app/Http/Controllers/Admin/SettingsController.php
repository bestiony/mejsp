<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReceivedEmails;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\Journals;


class SettingsController extends Controller
{
    public $social_websites = ['facebook', 'whatsapp', 'youtube', 'twitter', 'linkedin'];
    public $sections = ['signup_phone','blog','blog_en','journals','add_research','international_publishing','international_conference'];
    public $study_submition_sections = ['title','keywords-list','abstract','type','journal','file'];


    public function index()
    {
        $social_websites = $this->social_websites;
        $setting = Settings::first();

        // Emails
        $emails = ReceivedEmails::orderBy("id","DESC")->get();

        //front show hide sections
        $front_sections = $setting->sections_status ? json_decode($setting->sections_status,true) : null ;
        if(!$front_sections){
            $new_sections = [];
            foreach($this->sections as $section){
                $new_sections[$section] = 1;
            }
            $setting->sections_status = json_encode($new_sections);
            $setting->save();
            $front_sections = $new_sections;
        }
        $journals = Journals::select('id','name', 'is_enabled')->get()->toArray();
        return view("admin.settings.setting", compact('setting','journals', 'social_websites', 'emails', 'front_sections'));    }

    public function social_store(Request $request)
    {

        $social = Settings::first();
        if ($social == null) {
            $validate = [];
            $data = [];
            foreach ($this->social_websites as $website) {
                $validate[$website] = "nullable|url";
                $data[$website] = $request[$website];
            }
            $request->validate($validate);
            $insert = Settings::create($data);
            if ($insert->save()) {
                $request->session()->flash("success", "تم إضافة البيانات بنجاح");
                return back();
            }
        } else {
            return back();
        }
    }
    public function social_update(Request $request)
    {

        $social = Settings::first();
        if ($social != null) {
            $validate = [];
            foreach ($this->social_websites as $website) {
                $validate[$website] = "nullable|url";
                $social[$website] = $request[$website];
            }
            $request->validate($validate);
            if ($social->save()) {
                $request->session()->flash("success", "تم تحديث البيانات بنجاح");
                return back();
            }
        } else {
            return back();
        }
    }


      // mail
      public function mail_store(Request $request)
      {
  
          $social = Settings::first();
  
          if ($social == null) {
  
              // Validate Request 
              $request->validate([
                  "mail" => "required"
              ]);
  
              // Insert Data To DB
              $insert = Settings::create([
                  "mail" => $request->mail
              ]);
  
              if ($insert->save()) {
                  $request->session()->flash("success", "تم إضافة البريد الإلكتروني بنجاح");
                  return back();
              }
          } else {
              return back();
          }
      }
      public function mail_update(Request $request)
      {

          $social = Settings::first();
  
  
          if ($social != null) {
  
  
              // Validate Request 
              $request->validate([
                  "mail" => "required"
              ]);
  
              // Insert Data To DB
              $social->mail = $request->mail;
  
              if ($social->save()) {
                  $request->session()->flash("success", "تم تحديث البريد الإلكتروني بنجاح");
                  return back();
              }
          } else {
  
              return back();
          }
      }
  
      // phone
      public function phone_store(Request $request)
      {

          $social = Settings::first();
  
          if ($social == null) {
  
              // Validate Request 
              $request->validate([
                  "phone" => "required"
              ]);
  
              // Insert Data To DB
              $insert = Settings::create([
                  "phone" => $request->phone
              ]);
  
              if ($insert->save()) {
                  $request->session()->flash("success", "تم إضافة رقم الهاتف بنجاح");
                  return back();
              }
          } else {
              return back();
          }
      }
  
      public function phone_update(Request $request)
      {

          $social = Settings::first();
  
  
          if ($social != null) {
  
  
              // Validate Request 
              $request->validate([
                  "phone" => "required"
              ]);
  
              // Insert Data To DB
              $social->phone = $request->phone;
  
              if ($social->save()) {
                  $request->session()->flash("success", "تم تحديث رقم الهاتف بنجاح");
                  return back();
              }
          } else {
  
              return back();
          }
      }
      public function alert_in_chat_update(Request $request)
      {

          $social = Settings::first();
  
  
          if ($social != null) {
  
  
              // Validate Request 
              $request->validate([
                  "alert_in_chat" => "string|min:10"
              ]);
  
              // Insert Data To DB
              $social->alert_in_chat = $request->alert_in_chat;
  
              if ($social->save()) {
                  $request->session()->flash("success", "تم تحديث التنبيه بنجاح");
                  return back();
              }
          } else {
  
              return back();
          }
      }
      public function front_sections_update(Request $request)
      {

          $setting = Settings::first();
  
  
          if ($setting != null) {
              

                 $front_sections = $setting->sections_status ? json_decode($setting->sections_status,true) : null ;

                foreach($this->sections as $section){
                   if($request[$section]){
                    $front_sections[$section] = 1;
                   }else{
                    $front_sections[$section] = 0;
                   }
                }
                $setting->sections_status = json_encode($front_sections);
                $setting->save();
     
              if ($setting->save()) {
                  $request->session()->flash("success", "تم تحديث الأقسام بنجاح");
                  return back();
              }
          } else {
  
              return back();
          }
      }
      
      public function study_submition_sections_update(Request $request){
        $setting = Settings::first();


        if ($setting != null) {


               $study_submition_sections = $setting->study_submition_sections ? json_decode($setting->study_submition_sections,true) : null ;
              foreach($this->study_submition_sections as $section){
                 if($request[$section]){
                  $study_submition_sections[$section] = 1;
                 }else{
                  $study_submition_sections[$section] = 0;
                 }
              }
              $setting->study_submition_sections = json_encode($study_submition_sections);
              $setting->save();

            if ($setting->save()) {
                $request->session()->flash("success", "تم تحديث الأقسام بنجاح");
                return back();
            }
        } else {

            return back();
        }
      }
      
      public function updateJournalsStatus(Request $request)
    {
        $to_be_enabled =  $request->journals_statuses ?? [];
        $journals = Journals::all();
        foreach($journals as $journal){
            if(in_array($journal->id, $to_be_enabled)){
                $journal->is_enabled = true;
                $journal->update();
            } else{
                $journal->is_enabled = false;
                $journal->update();
            }
        }
        $request->session()->flash("success", "تم تحديث المجلات بنجاح");
        return back();

    }
    
      public function email_confirmation_alerts_page()
      {
        $setting = Settings::first();
        return view ('admin.settings.email_confirm_alerts',compact('setting'));
      }
      public function email_confirmation_alerts(Request $request)
      {

          $setting = Settings::first();
          $this->validate($request,[
            'confirm_email_alerts' => 'string|nullable'
          ]);
  
          if ($setting != null) {
              
            $setting->confirm_email_alerts = $request->confirm_email_alerts ?? null;
              
            if ($setting->save()) {
                  $request->session()->flash("success", "تم تحديث التنبيهات بنجاح");
                  return back();
              }
          } else {
  
              return back();
          }
      }




}
