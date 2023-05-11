<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailCampaign;
use App\Models\EmailList;
use App\Models\EmailTemplate;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CreateEmailCampaign extends Component
{
    use WithPagination;
    public $name;
    public $status;
    public $time_gap;
    public $launch_at;
    public $template_id;
    public $search;
    public $email_templates;
    public $emails = [];
    public $selected_email_lists = [];
    protected $rules = [
        'name' => 'required',
        'emails' => 'required|array',
        'time_gap' => 'required',
        'launch_at' => 'required',
        'template_id' => 'required',
    ];
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->email_templates = EmailTemplate::all();
    }
    public function updatingsearchTerm()
    {
        $this->resetPage();
    }

    public function createCampaign()
    {
        $this->validate();
        $campaign = EmailCampaign::create([
            'name' => $this->name,
            'emails' => $this->emails,
            'time_gap' => $this->time_gap,
            'launch_at' => $this->launch_at,
            'template_id' => $this->template_id,
        ]);
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم انشاء الحملة بنجاح',
            'text' => '',
        ]);
        $this->resetPage();

    }
    public function createCampaignAtomatically()
    {
        $now = Carbon::now();
        $max_into_the_future = Carbon::now()->addMinutes(80);
        $campaigns = EmailCampaign::
        where('launch_at', '>', $now)
        ->
        where('launch_at', '<', $max_into_the_future)
        ->get();
        dd($campaigns);
    }
    public function emptyList()
    {
        $this->selected_email_lists = [];
        $this->emails = [];
    }
    public function addToList($id)
    {
        $list = EmailList::findOrFail($id);
        $this->selected_email_lists[] = $id;
        $this->emails = array_merge(array_unique($this->emails), $list->subscribers->pluck('email')->toArray());
    }

    public function render()
    {
        $search = '%' . $this->search . '%';
        $data['email_lists'] = EmailList::where('name', 'LIKE', $search)
            ->whereNotIn('id', $this->selected_email_lists)
            ->paginate(5);

        // dd($data['email_lists']);
        return view('livewire.admin.create-email-campaign', $data);
    }
}
