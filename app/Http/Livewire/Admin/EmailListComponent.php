<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailList;
use App\Models\Subscribers;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class EmailListComponent extends Component
{
    use WithPagination;
    public $searchTerm;
    public $email_list_id;
    public $show;
    protected $listeners = ['delete'];

    protected $paginationTheme = 'bootstrap';
    public function updatingsearchTerm()
    {
        $this->resetPage();
    }
    public function updateShow($id){
        $this->show = $id;
        $this->dispatchBrowserEvent('show_model',['class'=> '#edit_list_model-'.$id]);
    }
    // public function selectEmailList($id){
    //     $this->email_list_id = $id;
    //     $this->emit('refresh_email_list',['email_list_id'=>$id] );

    //     $this->dispatchBrowserEvent('show_model');
    // }
    public function mount(){
        // $this->email_list_id = EmailList::first()->id;
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
    public function createManyLists(){
        $last_email_list = EmailList::latest()->first();
        $new_rank = $last_email_list ? $last_email_list->id + 1 : 1;
        $count = 0;
        $already_started = false;
        DB::beginTransaction();
        try{
            while(true){
                $subscribers = Subscribers::whereNull('email_list_id')->take(100)->get();
                if (!$subscribers->count()){
                    if($already_started){
                        break;
                    }
                    $this->dispatchBrowserEvent('alert_message', [
                        'type' => 'error',
                        'title' => 'لا توجد عناوين حرة',
                        'text' => '',
                    ]);
                    return;
                }
                $new_list = EmailList::create(['name' => 'القائمة البريدية -' . $new_rank]);
                Subscribers::whereIn('id',$subscribers->pluck('id'))->update(['email_list_id' => $new_list->id]);
                // $new_list->subscribers()->sync($subscribers);
                $new_rank++;
                $count++;
                $already_started = true;
            }
        } catch(Exception $ex){
            $this->dispatchBrowserEvent('alert_message', [
                'type' => 'error',
                'title' => 'حدث خطأ',
                'text' => $ex->getMessage(),
            ]);
            DB::rollBack();
            return;
        }
        DB::commit();
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم انشاء '.$count.' قوائم البريدية  بنجاح',
            'text' => '',
        ]);
    }
    public function delete($id)
    {
        $list = EmailList::with('subscribers')->findOrFail($id);
        $list->detachSubscribers();
        $list->delete();
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم حذف القائمة البريدية  بنجاح',
            'text' => '',
        ]);
    }

    public function render()
    {

        $search = '%' . $this->searchTerm . '%';
        $data['lists'] = EmailList::
            withCount('subscribers')
            ->where('name', 'LIKE', $search)
            ->orderBy('id','DESC')->paginate(10)
            ;
        return view('livewire.admin.email-list-component', $data)->extends('admin.layouts.master');
    }
}
