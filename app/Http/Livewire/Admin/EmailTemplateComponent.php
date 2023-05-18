<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailCampaign;
use App\Models\EmailTemplate;
use Exception;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class EmailTemplateComponent extends Component
{
    use WithPagination;
    public $searchTerm;
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';
    public function updatingsearchTerm()
    {
        $this->resetPage();
    }
    public function deleteConfirm($id, $title)
    {
        $this->dispatchBrowserEvent('confirmDelete', [
            'type' => 'warning',
            'title' => $title,
            'text' => '',
            'id' => $id,
        ]);
    }
    public function delete($id)
    {
        try{
            $template = EmailTemplate::findOrFail($id);
            File::delete(resource_path(EMAIL_TEMPLATES_DIRECTORY . $template->template));
            EmailCampaign::where('template_id', $template->id)->update(['template_id' => null]);
            $template->delete();
        }catch(Exception $ex){
            $this->dispatchBrowserEvent('alert_message', [
                'type' => 'error',
                'title' => $ex->getMessage(),
                'text' => '',
            ]);
            return;
        }
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم حذف القالب بنجاح',
            'text' => '',
        ]);
    }

    public function deleteTemplate($template_id){
        $template = EmailTemplate::findOrFail($template_id);
        $template->delete();

    }
    public function render()
    {

        $search = '%' . $this->searchTerm . '%';
        $data['templates'] = EmailTemplate::where('name', 'LIKE', $search)
            ->orWhere('subject', 'LIKE', $search)
            ->orWhere('sender', 'LIKE', $search)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.admin.email-template-component',$data)->extends('admin.layouts.master');
    }
}
