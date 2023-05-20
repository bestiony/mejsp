<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailTemplate;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEmailTemplate extends Component
{
    use WithFileUploads;
    public $name;
    public $subject;
    public $template;
    public $sender;
    public $status = 1;
    protected $rules = [
        'name' => 'required|unique:email_templates,name',
        'subject' => 'required',
        'template' => 'required',
        'sender' => 'required',
        'status' => 'required',
    ];
    public function createTemplate()
    {
        $this->validate();
        DB::beginTransaction();
        try {

            $file = $this->template;
            $filePath = $file->path();
            $fileContents = File::get($filePath);
            $file_name = slug($this->name) ;
            $file_new_path = resource_path(EMAIL_TEMPLATES_DIRECTORY .$file_name . '.blade.php');
            File::put($file_new_path, $fileContents);
            $template =  EmailTemplate::create([
                'name' => $this->name,
                'subject' => $this->subject,
                'template' => $file_name,
                'sender' => $this->sender,
                'status' => $this->status,
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            $this->dispatchBrowserEvent('alert_message', [
                'type' => 'error',
                'title' => $ex->getMessage(),
                'text' => '',
            ]);
            return;
        }
        DB::commit();
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم انشاء القالب بنجاح',
            'text' => '',
        ]);
    }
    public function render()
    {
        return view('livewire.admin.create-email-template');
    }
}
