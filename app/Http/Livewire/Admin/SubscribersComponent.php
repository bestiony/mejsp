<?php

namespace App\Http\Livewire\Admin;

use App\Models\Subscribers;
use Livewire\Component;
use Livewire\WithPagination;

class SubscribersComponent extends Component
{
    use WithPagination;
    public $searchTerm;
    protected $paginationTheme = 'bootstrap';
    public function updatingsearchTerm()
    {
        $this->resetPage();
    }
    public function render()
    {
        $search = '%' . $this->searchTerm . '%';
        $subscribers = Subscribers::
            query()
            // ->join('users', 'users.email', '=', 'subscribers.email')
            // ->where('users.name', 'LIKE', $search)
            // ->orWhere('users.email', 'LIKE', $search)
            ->orWhere('subscribers.email', 'LIKE', $search)
            // ->get()
            ->paginate(20)
            ;
        $this->dispatchBrowserEvent('reLaunchJS');
        return view('livewire.admin.subscribers-component', compact('subscribers'));
    }
}