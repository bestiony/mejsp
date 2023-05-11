<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailTemplate;
use Livewire\Component;

class CreateEmailTemplate extends Component
{
    public $name;
    public $subject;
    public $body;
    public $status = 1;
    protected $rules = [
        'name' => 'required',
        'subject' => 'required',
        'body' => 'required',
        'status' => 'required',
    ];
    public function createTemplate()
    {

        $template =  EmailTemplate::create($this->validate());
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
