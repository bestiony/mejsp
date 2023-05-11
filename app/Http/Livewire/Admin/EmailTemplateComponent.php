<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailTemplate;
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
        $template = EmailTemplate::findOrFail($id);
        $template->delete();
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
            ->orWhere('body', 'LIKE', $search)
            ->orWhere('subject', 'LIKE', $search)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.admin.email-template-component',$data)->extends('admin.layouts.master');
    }
}
