<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailList;
use App\Models\Subscribers;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mpdf\Tag\Select;
use PharIo\Manifest\Email;

class EditEmailList extends Component
{
    use WithPagination;
    public $name;
    public $search;
    public $emails = [];
    public $show_all = false;
    public $email_list;
    protected $rules = [
        'name' => 'required',
        'emails' => 'required|array',
    ];
    protected $paginationTheme = 'bootstrap';
    // protected $listeners = ['refresh_email_list'=> 'refreshModel'];
    public function updatingsearchTerm()
    {
        $this->resetPage();
    }
    public function updatingShowAll()
    {
        $this->resetPage();
    }

    // public function refreshModel($email_list_id){
    //     $email_list = EmailList::with('subscribers')->where('id',$email_list_id)->select('name')->first();
    //     // dd($this->email_list->name);
    //     $this->name = $email_list->name;
    //     $this->emails = Subscribers::where('email_list_id' , $email_list->id)->pluck('email')->toArray();
    //     dd($this->emails);
    // }
    public function mount($email_list_id)
    {

        $this->email_list = EmailList::findOrFail($email_list_id);
        // dd($this->email_list->name);
        $this->name = $this->email_list->name;
        $this->emails = $this->email_list->subscribers->pluck('email')->toArray();

    }
    public function updatedEmailListId($id)
    {
        $this->email_list = EmailList::find($id);
    }
    public function addToList($email)
    {
        $this->emails[] = $email;
    }
    public function removeFromList($email)
    {
        $key = array_search($email, $this->emails);
        unset($this->emails[$key]);
    }
    public function emptyList()
    {
        $this->emails = [];
    }
    public function updateList()
    {
        $this->validate();
        DB::beginTransaction();
        try{
            $this->email_list->name = $this->name;
            $this->email_list->save();

            Subscribers::where('email_list_id', $this->email_list->id)->update(['email_list_id' => null]);
            $new_emails = Subscribers::
            // whereNull('email_list_id')
            // ->
            whereIn('email', $this->emails)
            ->update(['email_list_id' => $this->email_list->id]);
        } catch(Exception $ex){
            dd($ex->getMessage());
            $this->dispatchBrowserEvent('alert_message', [
                'type' => 'error',
                'title' => 'حدث خطأ',
                'text' => $ex->getMessage(),
            ]);
            DB::rollBack();
        }
        DB::commit();
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم تحديث القائمة البريدية بنجاح',
            'text' => '',
        ]);
    }
    public function createListAtomatically()
    {
        /**
         * get 100 emails that don't have a list
         * create the list
         * add the emails to the list
         */
        $this->emails = Subscribers::whereNull('email_list_id')->pluck('email')->take(100)->toArray();
        $this->updateList();
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        $data['subscribers'] = Subscribers::
            when(!$this->show_all, function ($query) {
                $query->whereIn('email', $this->emails);
            })
            ->where('email', 'LIKE', $search)->paginate(10);
        return view('livewire.admin.edit-email-list', $data);
    }
}
