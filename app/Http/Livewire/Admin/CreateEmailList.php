<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailList;
use App\Models\Subscribers;
use Livewire\Component;
use Livewire\WithPagination;

class CreateEmailList extends Component
{
    use WithPagination;
    public $name;
    public $search;
    public $emails = [];
    protected $rules = [
        'name' => 'required',
        'emails' => 'required|array',
    ];
    protected $paginationTheme = 'bootstrap';
    public function updatingsearchTerm()
    {
        $this->resetPage();
    }
    public function addToList($email)
    {
        $this->emails[] = $email;
    }
    public function emptyList(){
        $this->emails = [];
    }
    public function createList()
    {
        $this->validate();
        $list = EmailList::create(['name' => $this->name]);
        $list_emails = Subscribers::whereNull('email_list_id')->whereIn('email', $this->emails)->update(['email_list_id' => $list->id]);

        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم انشاء القائمة البريدية بنجاح',
            'text' => '',
        ]);
    }
    public function createListAtomatically(){
        /**
         * get 100 emails that don't have a list
         * create the list
         * add the emails to the list
         */
        $this->emails = Subscribers::whereNull('email_list_id')->pluck('email')->take(100)->toArray();
        $this->createList();
    }
    public function render()
    {
        $data['subscribers_without_list'] = Subscribers::whereNull('email_list_id')->count();
        $search = '%' . $this->search . '%';
        $data['subscribers'] = Subscribers::
        whereNull('email_list_id')
        ->whereNotIn('email', $this->emails)
        ->where('email', 'LIKE', $search)->paginate(10);
        return view('livewire.admin.create-email-list',$data);
    }
}
