<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResearchesController;
use App\Jobs\SubscriberTestEmailJob;
use DB;
use Auth;
use Crypt;
use Exception;
use Illuminate\Support\Facades\Session;
use Notification;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Invoices;
use App\Models\Journals;
use App\Mail\MessageMail;
use App\Events\SendMessage;
use App\Models\Conferences;
use App\Models\InvoiceItems;
use Illuminate\Http\Request;
use App\Mail\ResiveOrderMail;
use App\Notifications\Review;
use App\Models\InvoiceJournal;
use App\Models\UsersResearches;
use App\Notifications\Approved;
use App\Notifications\Canceled;
use App\Notifications\EditChat;
use App\Mail\DeleteResearchReason;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoicesController;
use App\Mail\AdminVerfiedUserMail;
use App\Notifications\ResearcheEdit;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ResearchDelete;
use App\Notifications\ResearcheAnswer;
use App\Notifications\ResearcheReject;
use App\Notifications\ResearcheApprove;
use App\Models\InternationalPublicationOrders;
use App\Notifications\AdminConfirmedUserEmail;
use App\Mail\AdminRefusedInternationalPublicationOrderEmail;
use App\Notifications\ResearcheResponse;
use App\Models\Subscribers;
use App\Jobs\SubscriberEmailJob;
use Carbon\Carbon;
use App\Models\Settings;
use App\Models\SupportChat;

class UsersController extends Controller
{
    const PATH = "assets/uploads/user/";
    const IMG_EXT = '.webp';

    public $ending = 15;
    private function endTime()
    {
        return time() + $this->ending * 24 * 60 * 60;
    }
    public function index()
    {

        $query = null;
        $where = null;
        $equal = '=';

        if (isset($_GET['search'])) {
            $query = trim($_GET['search']);
            $where = 'email';
            $equal = 'like';
        }

        $users = User::orderBy('id', 'DESC')->where($where, $equal, $query)->get();
        return view("admin.users.users", compact("users"));
    }


    public function admin_verifies_user($id)
    {
        $user = User::find($id);
        if ($user && !$user->email_verified_at) {

            $user->email_verified_at = now();
            $user->save();
            $data = [];
            $data['name'] = $user->name;


            Mail::to($user->email)->send(new AdminVerfiedUserMail($data));

            $requestData = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'type' => 'email_confirmation',
                'body' => 'تم تأكيد بريدك الإلكتروني بنجاح يمكنك الآن الاستفادة من خدمات المنصة'
            ];

            Notification::send($user, new AdminConfirmedUserEmail($requestData));



        }
        return back();

    }

    public function update_status(Request $request)
    {
        $id = $request->id;
        $row = User::find($id);
        if (!empty($row)) {
            $row->status = $row->status == "0" ? "1" : "0";
            $row->save();
            $request->session()->flash("success", 'تم تحديث حالة المستخدم بنجاح');
            return back();
        } else {
            return back();
        }
    }

    public function show($id)
    {
        $row = User::find($id);
        if (!empty($row)) {

            // Get All conferences
            $conferences = Conferences::with(["confCategory"])->where('user_id', $id)->get();
            $payments = Payment::where('payment_by', $id)->orderBy('id', 'DESC')->get();

            $InternationalPublicationOrders = InternationalPublicationOrders::with([
                "journal" => function ($q) {
                    $q->select("id", 'name', 'price');
                }
            ])->where('user_id', $id)->orderBy('id', 'DESC')->get();


            $researches = UsersResearches::with([
                "journal" => function ($q) {
                    $q->select("id", 'name');
                }
            ])->where('user_id', $id)->orderBy('id', 'DESC')->paginate(5);

            return view("admin.users.show", compact("row", "conferences", "payments", 'researches', 'InternationalPublicationOrders'));
        } else {
            return redirect(adminUrl("users"));
        }
    }

    public function researches()
    {

        $rows = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            },
            'user' => function ($q) {
                $q->select("id", 'email');
            }
        ])->orderBy("id", 'DESC')->get();
        return view("admin.users.researches", compact('rows'));
    }
    //count
    // baik
    public function user_researches()
    {
        $researches = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            },
            'user' => function ($q) {
                $q->select("id", 'email', 'name', 'phone');
            }
        ])->orderBy("id", 'DESC')->paginate('10');

        $pageTitle = 'أبحاث المستخدمين';
        return view("admin.user-researches.all", compact('researches', 'pageTitle'));
    }

    public function user_researches_cat($id)
    {
        $researches = UsersResearches::where('status', $id)->with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            },
            'user' => function ($q) {
                $q->select("id", 'email', 'name', 'phone');
            }
        ])->orderBy("id", 'DESC')->paginate('15');

        $pageTitle = 'أبحاث المستخدمين';
        return view("admin.user-researches.all", compact('researches', 'pageTitle'));
    }
    public function user_researche_details($id)
    {
        $research = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            },
            'user' => function ($q) {
                $q->select("id", 'email', 'name', 'phone');
            }
        ])->find($id);

        $pageTitle = 'تفاصيل البحث';
        return view("admin.user-researches.details", compact('research', 'pageTitle'));
    }



    public function edit_researches($value, $id)
    {
        $user_researche = UsersResearches::find($id);
        $journal = Journals::findOrFail($user_researche->journal_id);
        $invoice = InvoiceJournal::where('journal_id', $journal->id)->first();
        $user_researche->status = $value;
        $user_in = $user_researche->user->id;
        $user_name = $user_researche->user->name;
        $user_researche->update();

        //Subject for email

        $etat = "";

        $researches = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            },
            'user' => function ($q) {
                $q->select("id", 'email', 'name', 'phone');
            }
        ])->orderBy("id", 'DESC')->paginate('5');

        if ($value == 1 || $value == 2) {
            $etat = "تحويل الدراسة للمراجعة";
            $info = [
                'id' => '',
                'mail_title' => 'تعديل في حالة الطلب',
                'mail_details1' => ' قام المراجع بتغيير حالة طلب النشر الخاص بك',
                'mail_details2' => ' يرجى الدخول لحسابك؛ لتفقد حالة الطلب',
                'mail_details3' => '',
                'mail_details4' => '',
                'mail_details5' => '',
                'title' => $user_researche->title,
                'type' => $user_researche->type,
                'journal' => $user_researche->journal->name,
                'abstract' => $user_researche->abstract,
                'file' => asset("assets/uploads/users-researches/" . $user_researche->file),
                'username' => $user_researche->user->name,
                'email' => $user_researche->user->email,
                'status' => $value,
            ];
            $user = User::where('id', $user_in)->first();

            $requestData = [
                'id' => $id,
                'user_id' => $user_in,
                'user_name' => $user_name,
                'type' => 'post',
                'body' => ' تم تحويل طلب النشر الخاص بك للمراجعة، سنبلغك بأخر مستجدات الطلب، يرجى الحرص على الدخول للوحة التحكم الخاصة بك دوريا للاطلاع على حالة طلبك',
            ];
            Notification::send($user, new ResearcheAnswer($requestData));
        } elseif ($value == 3) {
            $etat = "قبول الدراسة للنشر";
            $info = [
                'id' => '',
                'mail_title' => 'تهانينا!',
                'mail_details1' => 'وافقت لجنة المراجعة على نشر دراستك',
                'mail_details2' => 'الإجراءات التالية للنشر هي:-',
                'mail_details3' => '١- اعتماد شهادة قبول النشر',
                'mail_details4' => '٢- جدولة الدراسة ضمن الإصدار التالي للمجلة',
                'mail_details5' => 'لإتمام الإجراءات يجب سداد رسوم التحكيم والنشر باستخدام الفيزا أو الماستر كارد أو الباي بال',
                'title' => $user_researche->title,
                'type' => $user_researche->type,
                'journal' => $user_researche->journal->name,
                'abstract' => $user_researche->abstract,
                'file' => asset("assets/uploads/users-researches/" . $user_researche->file),
                'username' => $user_researche->user->name,
                'email' => $user_researche->user->email,
                'status' => $value,
            ];
            $user = User::where('id', $user_in)->first();

            $requestData = [
                'id' => $id,
                'user_id' => $user_in,
                'user_name' => $user_name,
                'type' => 'approve',
                'body' => 'تهانينا! تم قبول نشر دراستك بعنوان ' . $user_researche->title . ' يرجى الدخول للطلب  لاستكمال إجراءات النشر
                ',
            ];
            Notification::send($user, new ResearcheApprove($requestData));
            // send inviues 
            if ($invoice) {
                $item = $invoice->items;
                $invo = new Invoices();
                $invo->email = $user->email;
                $invo->journal_id = $invoice->journal->id;
                $invo->ending = $this->endTime();
                $invo->users_researches_id = $user_researche->id;
                $invo->sent_reminder = 0;
                $invo->next_reminder = time() + (72 * 60 * 60);
                $invo->save();
                if ($invo) {
                    foreach ($item as $item) {
                        $invo_items = new InvoiceItems();
                        $invo_items->price = $item->price;
                        $invo_items->service_name = $item->service_name;
                        $invo_items->invoice_id = $invo->id;
                        $invo_items->save();
                    }
                }
                $user_email = $user_researche->user->email;
                $etat = "قبول الدراسة للنشر";
                $info = [
                    'id' => '',
                    'mail_title' => 'تهانينا!',
                    'mail_details1' => 'وافقت لجنة المراجعة على نشر دراستك',
                    'mail_details2' => 'الإجراءات التالية للنشر هي:-',
                    'mail_details3' => '١- اعتماد شهادة قبول النشر',
                    'mail_details4' => '٢- جدولة الدراسة ضمن الإصدار التالي للمجلة',
                    'mail_details5' => 'لإتمام الإجراءات يجب سداد رسوم التحكيم والنشر باستخدام الفيزا أو الماستر كارد أو الباي بال',
                    'title' => $user_researche->title,
                    'type' => $user_researche->type,
                    'journal' => $user_researche->journal->name,
                    'abstract' => $user_researche->abstract,
                    'file' => asset("assets/uploads/users-researches/" . $user_researche->file),
                    'username' => $user_researche->user->name,
                    'email' => $user_researche->user->email,
                    'status' => 3,
                    'link' => url('invoice/' . Crypt::encryptString($invo->id))
                ];


                $mail = Mail::to($user_email)->send(new ResiveOrderMail($info, $etat));
                if ($mail) {
                    $id_send = $user_researche->id;
                    $success = "تم ارسال الفاتورة بنجاح";
                    return back()->with(compact('success', 'id_send'));
                }
            }
            // end send
        } elseif ($value == 4) {
            $etat = "رفض نشر الدراسة";
            $info = [
                'id' => '',
                'mail_title' => 'رفض طلب النشر',
                'mail_details1' => 'نأسف لإبلاغك برفض لجنة المراجعة لطلب النشر الخاص بك',
                'mail_details2' => 'لا تتردد بتقديم دراساتك المستقبلية للنشر بالمجلة',
                'mail_details3' => '',
                'mail_details4' => '',
                'mail_details5' => '',
                'title' => $user_researche->title,
                'type' => $user_researche->type,
                'journal' => $user_researche->journal->name,
                'abstract' => $user_researche->abstract,
                'file' => asset("assets/uploads/users-researches/" . $user_researche->file),
                'username' => $user_researche->user->name,
                'email' => $user_researche->user->email,
                'status' => $value,
            ];
            $user = User::where('id', $user_in)->first();

            $requestData = [
                'id' => $id,
                'user_id' => $user_in,
                'user_name' => $user_name,
                'type' => 'reject',
                'body' => 'نعتذر، تم رفض نشر دراستك بعنوان ' . $user_researche->title . ' بسبب عدم مراعاة معايير النشر بالمجلة
                لا تتردد بإرسال أعمالك البحثية مستقبلا
                ',
            ];
            Notification::send($user, new ResearcheReject($requestData));
        } elseif ($value == 5) {
            $etat = "تعديل مطلوب في الدراسة";
            $info = [
                'id' => $user_researche->id,
                'mail_title' => 'وردك رد من المراجع',
                'mail_details1' => 'قام المراجع بإضافة تعليقات مطلوب تنفيذها في دراستك',
                'mail_details2' => '',
                'mail_details3' => '',
                'mail_details4' => '',
                'mail_details5' => '',
                'title' => $user_researche->title,
                'type' => $user_researche->type,
                'journal' => $user_researche->journal->name,
                'abstract' => $user_researche->abstract,
                'file' => asset("assets/uploads/users-researches/" . $user_researche->file),
                'username' => $user_researche->user->name,
                'email' => $user_researche->user->email,
                'status' => $value,
            ];
            $user = User::where('id', $user_in)->first();

            $requestData = [
                'id' => $id,
                'user_id' => $user_in,
                'user_name' => $user_name,
                'type' => 'post',
                'body' => '   لديك تعديل مطلوب في دراستك يمكنك فتح الشات من اجل التفاصيل',
            ];
            Notification::send($user, new ResearcheEdit($requestData));
        }


        $user_email = $user_researche->user->email;

        if ($value != 5 && $value != 3) {
            Mail::to($user_email)->send(new ResiveOrderMail($info, $etat));
        }

        $pageTitle = 'أبحاث المستخدمين';
        return redirect()->back()->with('researches', $researches)->with('pageTitle', $pageTitle);

    }

    public static function user_researches_destroy(Request $request, $inside_call = false)
    {

        $id = $request->id;
        $row = UsersResearches::find($id);

        $user = $row->user;

        $requestData = [
            'id' => $id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'type' => 'delete',
            'body' => 'نعتذر، تم حذف دراستك بعنوان ' . $row->title . ' بسبب ' . $request->reason . '
            لا تتردد بإرسال أعمالك البحثية مستقبلا 
            ',
        ];



        if (!empty($row)) {
            Invoices::where('users_researches_id', $row->id)->delete();
            deleteFile(public_path("assets/uploads/users-researches/"), $row->file);


            $etat = "إشعار بحذف طلب النشر";
            $info = [
                'id' => '',
                'mail_title' => 'حذف الطلب ',
                'mail_details1' => 'نأسف لإبلاغك بحذف لجنة المراجعة لطلب النشر الخاص بك',
                'mail_details2' => 'لا تتردد بتقديم دراساتك المستقبلية للنشر بالمجلة',
                'mail_details3' => '',
                'mail_details4' => '',
                'mail_details5' => '',
                'title' => $row->title,
                'type' => $row->type,
                'journal' => $row->journal ? $row->journal->name : 'لم تختر مجلة',
                'abstract' => $row->abstract,
                'file' => asset("assets/uploads/users-researches/" . $row->file),
                'reason' => $request->reason
            ];
            $row->delete();
            Mail::to($user->email)->send(new DeleteResearchReason($info, $etat));

            Notification::send($user, new ResearchDelete($requestData));
            return response()->json([
                'message' => 'deleted'
            ]);



            if (!$inside_call) {
                $request->session()->flash("success", 'تم  الحذف بنجاح');
                return response()->json([
                    'message' => 'deleted'
                ]);
            }
        }
    }

    // chat  
    public function chat($id, Request $request)
    {
        $user_researches = UsersResearches::findOrFail($id);

        if ($request->notification_id) {
            $noti = DB::table('notifications')->where('id', $request->notification_id)->update(['read_at' => NOW()]);

        }

        $messages = Message::where('research_id', $id)->get();

        foreach ($messages as $item) {
            $item->a_show = 1;
            $item->update();
        }
        $research_id = $id;
        $pageTitle = 'الرسائل ';
        if ($user_researches->status == 5) {
            return view("admin.user-researches.chat", compact('messages', 'pageTitle', 'research_id', 'user_researches'));

        } else {
            return view("admin.user-researches.closed_chat", compact('messages', 'pageTitle', 'research_id', 'user_researches'));
        }



    }

    public function send_facture(request $request)
    {

        $request->validate([
            'link' => 'required|url'
        ]);

        $user_researche = UsersResearches::where('id', $request->research_id)->first();


        $user_email = $user_researche->user->email;
        $etat = "قبول الدراسة للنشر";
        $info = [
            'id' => '',
            'mail_title' => 'تهانينا!',
            'mail_details1' => 'وافقت لجنة المراجعة على نشر دراستك',
            'mail_details2' => 'الإجراءات التالية للنشر هي:-',
            'mail_details3' => '١- اعتماد شهادة قبول النشر',
            'mail_details4' => '٢- جدولة الدراسة ضمن الإصدار التالي للمجلة',
            'mail_details5' => 'لإتمام الإجراءات يجب سداد رسوم التحكيم والنشر باستخدام الفيزا أو الماستر كارد أو الباي بال',
            'title' => $user_researche->title,
            'type' => $user_researche->type,
            'journal' => $user_researche->journal->name,
            'abstract' => $user_researche->abstract,
            'file' => asset("assets/uploads/users-researches/" . $user_researche->file),
            'username' => $user_researche->user->name,
            'email' => $user_researche->user->email,
            'status' => 3,
            'link' => $request->link
        ];


        $mail = Mail::to($user_email)->send(new ResiveOrderMail($info, $etat));
        if ($mail) {
            $id_send = $user_researche->id;
            $success = "تم ارسال الفاتورة بنجاح";
            return back()->with(compact('success', 'id_send'));
        }

    }

    public function chat_store(request $request)
    {

        $request->validate([
            'message' => 'max:1500',
            'file' => 'mimes:doc,docx,pdf,jpg,png,jpeg',
        ]);

        // get File
        $file = $request->file;

        //get Host Webiste
        $host = $request->getSchemeAndHttpHost();

        $message = new Message;
        $message->message = nl2br($request->message);
        $message->research_id = $request->research_id;
        $message->a_show = 1;
        $message->u_show = 0;
        $message->user_id = 1;

        //verify requests File 

        if (!empty($file)) {
            $new_file = random_int(100000, 999999) . "_" . time() . $file->getClientOriginalName();
            $message->file = $host . "/admin-assets/uploads/chats_pictures/" . $new_file;
        } else {
            $new_file = "";
            $message->file = $new_file;
        }

        $user_researches = UsersResearches::where('id', $request->research_id)->first();
        $user_in = $user_researches->user->id;


        $research = UsersResearches::where('id', $message->research_id)->pluck('user_id')->first();

        $user_email = User::where('id', $research)->pluck('email')->first();

        $etat = "تعديل مطلوب في الدراسة";

        $info = [
            'id' => $request->research_id,
            'mail_title' => 'وردك رد من المراجع',
            'mail_details1' => 'قام المراجع بإضافة تعليقات مطلوب تنفيذها في دراستك.',
            'mail_details2' => '',
            'mail_details3' => '',
            'mail_details4' => '',
            'mail_details5' => '',
            'title' => $user_researches->title,
            'type' => $user_researches->type,
            'journal' => $user_researches->journal->name,
            'abstract' => $user_researches->abstract,
            'file' => asset("assets/uploads/users-researches/" . $user_researches->file),
            'username' => $user_researches->user->name,
            'email' => $user_researches->user->email,
            'status' => 7,
        ];


        if ($message->save()) {
            $user = User::where('id', $user_in)->first();

            $requestData = [
                'id' => $user_researches->id,
                'user_id' => $user_in,
                'user_name' => $user->name,
                'type' => 'chat',
                'body' => 'بخصوص طلب نشر الدراسة بعنوان ' . $user_researches->title . ' وردك تعليقات من المراجع
                ',
            ];
            Notification::send($user, new EditChat($requestData));
            if (!empty($file)) {
                // $file->move("admin-assets/uploads/chats_pictures",$new_file);
                upload($file, "admin-assets/uploads/chats_pictures/", $new_file);
            }

            Mail::to($user_email)->send(new ResiveOrderMail($info, $etat));
            //send message pusher
            event(new SendMessage($message, $user_in));
        }

        $messages = Message::where('research_id', $request->research_id)->get();
        $research_id = $request->research_id;
        $pageTitle = 'الرسائل ';
        return redirect()->back()->with('messages', $messages)->with('pageTitle', $pageTitle)->with('research_id', $research_id);
    }




    //baik


    public function destroy(Request $request)
    {
        $id = $request->id;
        $row = User::find($id);
        if (!empty($row)) {
            deleteFile(self::PATH, $row->image);
            $row->delete();
        }
        return back();
    }


    public function researches_destroy(Request $request)
    {

        $id = $request->id;
        $row = UsersResearches::find($id);
        if (!empty($row)) {
            deleteFile(public_path("assets/uploads/users-researches/"), $row->file);
            $row->delete();
        }

    }
    public function admin_edit_research($id)
    {
        $types = [
            1 => 'مقيد الوصول',
            0 => 'مفتوح المصدر',
        ];
        $journals = Journals::select("name", 'id')->get();
        $research = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            },
            'user' => function ($q) {
                $q->select("id", 'email', 'name', 'phone');
            }
        ])->find($id);
        $keywords = [];
        if ($research->keywords) {
            $keywords = explode(",", $research->keywords);

        }
        $pageTitle = 'تعديل البحث';
        return view("admin.user-researches.edit", compact('research', 'pageTitle', 'journals', 'keywords', 'types'));
    }

    public function admin_update_research(Request $request)
    {
        $id = $request->id;
        $research = UsersResearches::find($id);
        $user = User::find($research->user_id);
        $title_exists = UsersResearches::where('title', $request->title)->whereNot('id', $id)->exists();
        if ($title_exists) {
            return response([
                'status' => 'same_study',
                'redirect_to_success_page' => false,
                'order_id' => 457,
                'message' => 'هذاالاسم مستعمل من قبل ',
                // 'form' => 'reset',
            ]);
        }

        $ids = DB::table('journals')->select('id')->get();
        $journalsIDs = [];
        foreach ($ids as $row) {
            array_push($journalsIDs, $row->id);
        }

        $request->validate([
            'title' => 'required|max:1500',
            'keywords' => 'max:3000',
            'keywords_final' => 'required|max:3000',
            'abstract' => 'required|max:10000',
            'type' => 'required|in:0,1',
            'journal' => "required|in:" . implode(",", $journalsIDs),
            // 'file' => 'required|mimes:doc,docx',
        ]);
        if ($request->file) {
            $fileName = slug(mb_substr($request->title ?? "", 0, 75)) . "-" . randomName() . '.' . $request->file->extension();
            upload($request->file, ResearchesController::PATH, $fileName);
            $research->file = $fileName;
        }

        $research->title = $request->title;
        $research->keywords = $request->keywords_final;
        $research->abstract = $request->abstract;
        $research->type = $request->type;
        $research->journal_id = $request->journal;
        $research->update();

        if ($research->invoice) {
            $research->invoice->journal_id = $request->journal;
            $research->invoice->save();
        }

        $requestData = [
            'id' => $id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'type' => 'researche',
            'body' => 'تم تعديل طلبك من طرف الإدارة'
        ];

        Notification::send($user, new ResearcheResponse($requestData));


        return response([
            'status' => true,
            'redirect_to_success_page' => false,
            'order_id' => $id,
            'message' => 'تم تعديل الطلب بنجاح',
            'form' => false,
        ]);
    }


    public static function filter_users_researches()
    {
        /*
        get all unpaid invoices that are linked to a research
        get ones have next_reminder < 1.5 hours
        foreach invoice
        get the sent_reminder
        if 1,2,3,4
        call the admin_send_reminder static function with the reminder and research_id
        else
        delete research and invoice
        */
        $time1 = time();
        $deleted_researches = [];
        $updated_researches = [];
        $check_every = 15 * 60;
        $unpaid_invoices = Invoices::where('payment_response', '0')
            ->whereNot('users_researches_id', 0)
            ->where(function ($query) use ($check_every) {
                $query->where('next_reminder', '<=', time() + $check_every)
                    ->orWhere('next_reminder', '<=', time());
            })
            ->get();
        foreach ($unpaid_invoices as $invoice) {
            $research_id = $invoice->users_researches_id;
            $reminder = $invoice->sent_reminder + 1;
            if ($reminder > 5) {
                $request = new Request();
                $request->setMethod('POST');
                $request->request->add(['id' => $research_id, 'reason' => 'عدم دفع الفاتورة في الآجال المحددة']);
                $deleted_researches[$research_id] = $invoice->id;
                self::user_researches_destroy($request, true);
                sleep(4);
                continue;
            }

            $result = InvoicesController::admin_send_reminder($research_id, $reminder);
            sleep(4);

            $updated_researches[$research_id] = $invoice->id;
        }
        $time2 = time();
        $duration = $time2 - $time1;
        return [
            'deleted' => $deleted_researches,
            'updated' => $updated_researches,
            'duration' => $duration
        ];
    }

    public function admin_create_research()
    {
        $types = [
            1 => 'مقيد الوصول',
            0 => 'مفتوح المصدر',
        ];
        $journals = Journals::select("name", 'id')->get();
        $pageTitle = 'انشاء البحث';
        $users = User::all();
        return view("admin.user-researches.create", compact('pageTitle', 'journals', 'types', 'users'));
    }

    public function admin_store_research(Request $request)
    {
        $user = User::find($request->user_id);
        // return response([
        //     'sth' => 'ssyes'
        // ]);
        $title_exists = UsersResearches::where('title', $request->title)->exists();
        if ($title_exists) {
            return response([
                'status' => 'same_study',
                'redirect_to_success_page' => false,
                'order_id' => 457,
                'message' => 'هذاالاسم مستعمل من قبل ',
                // 'form' => 'reset',
            ]);
        }

        $ids = DB::table('journals')->select('id')->get();
        $journalsIDs = [];
        foreach ($ids as $row) {
            array_push($journalsIDs, $row->id);
        }

        $request->validate([
            'title' => 'required|max:1500',
            'keywords' => 'max:3000',
            'keywords_final' => 'required|max:3000',
            'abstract' => 'required|max:10000',
            'type' => 'required|in:0,1',
            'journal' => "required|in:" . implode(",", $journalsIDs),
            'file' => 'required|mimes:doc,docx',
        ]);


        $fileName = slug(mb_substr($request->title, 0, 75)) . "-" . randomName() . '.' . $request->file->extension();
        upload($request->file, ResearchesController::PATH, $fileName);

        $research = UsersResearches::create([
            'title' => $request->title,
            'keywords' => $request->keywords_final ? $request->keywords_final : $request->keywords,
            'abstract' => $request->abstract,
            'type' => $request->type,
            'file' => $fileName,
            'user_id' => $user->id,
            'journal_id' => $request->journal
        ]);



        $requestData = [
            'id' => $research->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'type' => 'researche',
            'body' => 'تم انشاء طلب من طرف الإدارة'
        ];

        Notification::send($user, new ResearcheResponse($requestData));


        return response([
            'status' => true,
            'redirect_to_success_page' => false,
            'order_id' => $research->id,
            'message' => 'تم انشاء الطلب بنجاح',
            'form' => false,
        ]);
    }

    public function subscribers()
    {
        $subscribers = Subscribers::orderBy('id', 'desc')->get();
        return view("admin.users.subscribers", compact("subscribers"));
    }

    public function emailSubscriberForm()
    {
        return view("admin.users.email");
    }

    public function Ajaxsubscribers(Request $request)
    {
        $subscribers = Subscribers::when($request->email, function ($q) use ($request) {
            $q->where('email', 'like', '%' . $request->email . '%');
        })->get();
        $trs = '';
        foreach ($subscribers as $subscriber) {
            $trs .= '<tr>
                    <td>' . $subscriber->email . '</td>
                    <td><button data-email="' . $subscriber->email . '" data-id="' . $subscriber->id . '" class="btn btn-info edit"><i class="fa fa-edit"></i> تعديل</button></td>
                    <td><button data-id="' . $subscriber->id . '" class="btn btn-danger delete"><i class="fa fa-trash"></i> حذف</button></td>
                </tr>';
        }

        return response()->json(['emails' => $trs]);
    }

    public function destroySubscriber(Request $request)
    {
        Subscribers::findorfail($request->id)->delete();
        Session::flash('message', 'تم الحذف بنجاح');
        return redirect()->back();

    }

    public function EditSubscriber(Request $request)
    {
        $row = Subscribers::findorfail($request->id);
        $row->update($request->only('email'));
        Session::flash('message', 'تم التعديل بنجاح');
        return redirect()->back();
    }

    public function SendMail(Request $request)
    {
        $array= Subscribers::pluck('email')->toArray();
        $time = Carbon::now();
        $setting = Settings::first();
        $logo = $this->UploadFile($request->logo);
        foreach ($array as $email) {
            $details['email'] = $email;
            $details['journal_name'] = $request->journal_name;
            $details['text_one'] = $request->text_one;
            $details['text_two'] = $request->text_two;
            $details['text_three'] = $request->journal_name;
            $details['logo'] = $logo;
            $details['setting'] = $setting;
            $details['email_sender'] = $request->email_sender;
            $details['name_of_email'] = $request->name_of_email;
            $details['subject'] = $request->subject;
            $details['publication_terms'] = $request->publication_terms;
            $details['judgement_comity'] = $request->judgement_comity;

            dispatch(new SubscriberEmailJob($details))->delay($time);
            $time = $time->addSeconds(20);
        }

        Session::flash('message', 'تمت بنجاح');
        return redirect()->back();

    }

    public function SendTestMail(Request $request)
    {
        $array = explode("\r\n", $request->emails);
        $time = Carbon::now();
        foreach ($array as $email) {
            $time = $time->addSeconds(30);
            dispatch(new SubscriberTestEmailJob($email))->delay($time);
        }

        Session::flash('message', 'تمت بنجاح');
        return redirect()->back();

    }

    public function RemoveSubscribers($email)
    {
        Subscribers::where('email', $email)->first()->delete();
        Session::flash('message', 'تمت بنجاح');
        return redirect('/');
    }

    public function RefusedInternationalPublicationOrders(Request $request)
    {
        $row = InternationalPublicationOrders::findorfail($request->international_order_id);
        $row->update(['status' => $request->status, 'reason_to_refused' => $request->reason_to_refused]);
        // Invoices::create(['email'=>$row->user->email,'payment_response'=>$row->payment_response,'ending'=>$this->endTime(),'sent_reminder'=>1]);
        $requestData = [
            'id' => $row->user->id,
            'user_id' => $row->user->id,
            'user_name' => $row->user->name,
            'type' => '',
            'body' => ' تم رفض طلب النشر العام الخاص بيك للاسباب التالية' . $request->reason_to_refused . '',
        ];

        $info = [
            'mail_title' => 'Publication request rejected',
            'mail_details1' => 'Dear ' . $row->user->name . '',
            'status' => 1,
            'mail_details2' => 'We regret to inform you that the review committee rejected your submission
            which has a reference number #' . $row->id . '',
            'mail_details3' => 'For the study entitled " ' . $row->title . '"',
            'mail_details4' => 'the reason of refuse:"' . $request->reason_to_refused . '"',
            'mail_details5' => 'Do not hesitate to submit your future studies for publication in the journal',
            'mail_details6' => '',
            'mail_details7' => '',
            'mail_details8' => '',
            'id' => '',
            'file' => asset(self::PATH . $row->file),
            'journal' => $row->journal->name,
            'username' => $row->user->name,
            'email' => $row->user->email,
            'subject' => 'Publication Rejection',
            'id' => $row->id,
            'from_email' => 'editor@journals.mejsp.com'
        ];

        Mail::to($row->user->email)->send(new AdminRefusedInternationalPublicationOrderEmail($info));
        Notification::send($row->user, new ResearcheReject($requestData));
        Session::flash('message', 'تم رفض الطلب بنجاح');
        return redirect()->back();
    }

    public function AcceptInternationalPublicationOrders(Request $request)
    {
        $row = InternationalPublicationOrders::findorfail($request->international_order_id);
        $row->update(['status' => $request->status]);
        $invoice = Invoices::create(['email' => $row->user->email, 'payment_response' => $row->payment_response, 'ending' => $this->endTime(), 'sent_reminder' => 1]);
        InvoiceItems::create(['price' => $row->journal->price, 'service_name' => 'رسوم نشر', 'invoice_id' => $invoice->id]);
        $requestData = [
            'id' => $row->user->id,
            'user_id' => $row->user->id,
            'user_name' => $row->user->name,
            'type' => 'refused',
            'body' => 'تم قبول طلب النشر الخاص بك',
        ];

        $info = [
            'mail_title' => 'Acceptance of the study for publication',
            'mail_details1' => 'Dear ' . $row->user->name . '',
            'status' => 2,
            'mail_details2' => 'The review committee has approved the publication of your study.',
            'mail_details3' => 'Study Title " ' . $row->title . '"',
            'mail_details4' => 'Requisition reference number:"#' . $row->id . '"',
            'mail_details6' => '1- Approving the publication acceptance certificate.',
            'mail_details7' => '2- Scheduling the study within the next issue of the journal.',
            'mail_details8' => 'To complete the procedures, arbitration and publication fees must be paid using a bank card (Visa or Master Card) by clicking on the (Pay Publication Fees) button.',
            'mail_details5' => 'The following procedures for publication are:-',
            'id' => '',
            'file' => asset(self::PATH . $row->file),
            'journal' => $row->journal->name,
            'username' => $row->user->name,
            'email' => $row->user->email,
            'subject' => 'Publication Acceptance',
            'id' => $row->id,
            'from_email' => 'editor@journals.mejsp.com'
        ];
        Mail::to($row->user->email)->send(new AdminRefusedInternationalPublicationOrderEmail($info));
        Notification::send($row->user, new ResearcheReject($requestData));
        Session::flash('message', 'تم قبول الطلب بنجاح');
        return redirect()->back();
    }

    function UploadFile($file)
    {
        $file_name = time() . $file->getClientOriginalName();
        $file->move('email', $file_name);
        return $file_name;

    }

    public function newSubscriberForm()
    {
        return view("admin.users.new-subscriber");
    }

    public function AddSubscribers(Request $request)
    {
        $emails = explode("\r\n", $request->emails);
        foreach ($emails as $email) {
            Subscribers::updateOrCreate(['email' => $email], ['email' => $email]);
        }
        Session::flash('message', 'تم الاضافة بنجاح');
        return redirect()->route('subscribers-list');
    }

    public function ViewSupportChat($id)
    {
        $pageTitle = 'الرسائل';
        $message_email = SupportChat::find($id);
        $messages = SupportChat::where('user_email', $message_email->user_email)->get();
        // dd(auth('admin')->user());
        return view("admin.ViewSupportChat", compact('pageTitle', 'messages', 'message_email'));
    }
}