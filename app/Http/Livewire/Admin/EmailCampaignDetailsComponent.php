<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmailCampaign;
use Livewire\Component;
use Livewire\WithPagination;

class EmailCampaignDetailsComponent extends Component
{
    use WithPagination;
    public $campaign;
    protected $listeners = ['delete'];

    public function mount(EmailCampaign $campaign){
        $this->campaign = $campaign;
    }
    public function reactivateCampaign($id){
        $this->campaign->status = RESUMEABLE_CAMPAIGN;
        $this->campaign->save();
        $this->dispatchBrowserEvent('alert_message', [
            'type' => 'success',
            'title' => 'تم اعادة تنشيط الحملة بنجاح',
            'text' => '',
        ]);
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
        return redirect()->route('email_campaigns');
    }

    public function render()
    {
        $data['history_log'] = $this->campaign->history_log ?? [];
        $data['emails_count'] = count($this->campaign->emails);
        return view('livewire.admin.email-campaign-details-component',$data)->extends('admin.layouts.master');
    }
}
