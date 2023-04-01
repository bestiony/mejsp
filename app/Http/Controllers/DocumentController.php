<?php

namespace App\Http\Controllers;

use App\Mail\DocumentIssuedMail;
use App\Models\Document;
use App\Models\User;
use App\Models\UsersResearches;
use App\Notifications\DocumentIssued;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class DocumentController extends Controller
{
    //
    const DOCUMENT_PATH = "assets/uploads/users-documents/";


    public function user_index()
    {
        $user = User::find(getAuth('user', 'id'));
        $pageTitle = 'مستنداتك';


        $documents = Document::where('user_id',$user->id)->orderBy('id','desc')->get();
        return view('main.user.documents.index', compact('documents','pageTitle'));
    }
    public function user_show()
    {
    }
    public function show()
    {
    }
    public function index()
    {
        $documents = Document::with(['user', 'research'])->orderBy('id','desc')->get();
        $users = User::all();
        return view('admin.documents.index', compact('documents', 'users'));
    }
    public function create()
    {
    }
    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'document_name' => 'required',
            'user_research' => 'required',
            'document_pdf' => 'required|mimes:pdf',
            'document_photo' => 'required|image',
        ]);
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $pdf_fileName = slug(mb_substr($request->document_name ?? "", 0, 75)) . "-" . randomName() . '.' . $request->document_pdf->extension();
        $photo_fileName = slug(mb_substr($request->document_name ?? "", 0, 75)) . "-" . randomName() . '.' . $request->document_photo->extension();
        upload($request->document_pdf, self::DOCUMENT_PATH, $pdf_fileName);
        upload($request->document_photo, self::DOCUMENT_PATH, $photo_fileName);


        $document = Document::create([
            'user_id' =>  $user_id,
            'research_id' =>  $request->user_research,
            'name' => $request->document_name,
            'pdf' => $pdf_fileName,
            'photo' => $photo_fileName,
        ]);

        $requestData = [
            'id' => $document->id,
            'user_id' => $user_id,
            'user_name' => $user->name,
            'type' => 'document',
            'body' => "مرحباً
            تم اعتماد $document->name
            يسرنا استقبال أعمالك البحثية مستقبلاً
            يرجى التواصل معنا حال الرغبة بالحصول على المستندات الورقية الأصلية (شهادة قبول النشر - إفادة النشر - مستلة البحث - الإصدار الكامل المنشور فيه بحثك)",
        ];
        Notification::send($user, new DocumentIssued($requestData));
        $etat = 'اعتماد الشهادة';
        $info = [
            'mail_title' => 'مرحباً',
            'mail_details1' => "تم اعتماد $document->name",
            'mail_details2' => 'يسرنا استقبال أعمالك البحثية مستقبلاً',
            'mail_details3' => 'يرجى التواصل معنا حال الرغبة بالحصول على المستندات الورقية الأصلية (شهادة قبول النشر - إفادة النشر - مستلة البحث - الإصدار الكامل المنشور فيه بحثك)',
            'title' => $document->research->title,
            'type' => $document->research->type,
            'journal' => $document->research->journal->name,
            'abstract' => $document->research->abstract,
            'file' => asset('assets/uploads/users-researches/'.$document->research->file) ,
            'username' => $user->name,
            'email' => $user->email,
        ];


            $mail = Mail::to($user)->send(new DocumentIssuedMail($info, $etat));

        
        return response([
            'status' => true,
            'redirect_to_success_page' => true,
            'message' => 'تم إضافة الوثيقة بنجاح',
            'document_id' => $document->id,
            'close_modal' => true,
            'modal' => 'add-document-modal',
        ]);
    }
    public function get_user_researches(Request $request)
    {
        $researches = UsersResearches::where('user_id', $request->user_id)->get();
        $researches_array = [];
        foreach ($researches as $research) {
            $researches_array[$research->id] = $research->title;
        }
        return response([
            'researches' => $researches_array
        ]);
    }
    public function get_documents(Request $request)
    {
        $documents = Document::where('user_id', $request->user_id)->get();
        $documents_array = [];
        foreach ($documents as $document) {
            $documents_array[$document->id] = [
                'user_id'=>$request->user_id,
                'user_name' => User::find($request->user_id)->name,
                'name' => $document->name,
                'research_name' => $document->research->title,
                'research_id' => $document->research->id,
                'pdf' => $document->pdf,
                'photo' => $document->photo,
            ];
        }
        return response([
            'documents' => $documents_array,
        ]);
    }
    public function edit()
    {
    }
    public function update(Request $request)
    {
        $request->validate([
            'current_document_id'=>'required',
            'user_id' => 'required',
            'edit_document_name' => 'required',
            'new_user_research' => 'required',
        ]);
        $document = Document::find($request->current_document_id);
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $updated_data = [
            'user_id' =>  $user_id,
            'research_id' =>  $request->new_user_research,
            'name' => $request->edit_document_name,
        ];
        if($request->document_pdf){
            $request->validate(['document_pdf'=>'mimes:pdf']);
            $pdf_fileName = slug(mb_substr($request->document_name ?? "", 0, 75)) . "-" . randomName() . '.' . $request->document_pdf->extension();
            upload($request->document_pdf, self::DOCUMENT_PATH, $pdf_fileName);
            $updated_data['pdf'] = $pdf_fileName;
        }
        if($request->document_photo){
            $request->validate(['document_photo'=>'image']);
            $photo_fileName = slug(mb_substr($request->document_name ?? "", 0, 75)) . "-" . randomName() . '.' . $request->document_photo->extension();
            upload($request->document_photo, self::DOCUMENT_PATH, $photo_fileName);
            $updated_data['photo'] = $photo_fileName;
        }


        $document->update($updated_data);

        return response([
            'status' => true,
            'redirect_to_success_page' => true,
            'message' => 'تم تعديل الوثيقة بنجاح',
            'document_id' => $document->id,
            'close_modal' => true,
            'modal' => 'edit-document-modal',
        ]);
    }
    public function destroy(Request $request)
    {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        if ($document) {
            $document->delete();
            return response('', 200);
        } else {
            return response('', 500);
        }
    }
}
