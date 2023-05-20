<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailCampaign;
use Livewire\Component;
use Livewire\WithPagination;

class EmailCampaignComponent extends Component
{
    use WithPagination;
    public $searchTerm;
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';
    public function updatingsearchTerm()
    {
        $this->resetPage();
    }
    public function cancelCampaign($id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $campaign->pushStatus(CANCELED_CAMPAIGN);
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم إلغاء الحملة بنجاح',
            'text' => '',
        ]);
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
        $campaign = EmailCampaign::findOrFail($id);
        $campaign->delete();
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم حذف الحملة بنجاح',
            'text' => '',
        ]);
    }

    public function deletecampaign($campaign_id)
    {
        $campaign = EmailCampaign::findOrFail($campaign_id);
        $campaign->delete();
    }
    public function render()
    {
        $search = '%' . $this->searchTerm . '%';
        $data['campaigns'] = EmailCampaign::where('name', 'LIKE', $search)
            ->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.email-campaign-component',$data)->extends('admin.layouts.master');
    }
}
