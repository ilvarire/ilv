<?php

namespace App\Livewire\Admin\Layout;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $pendingOrders;

    public function mount()
    {
        // $this->authorizeAccess();
        $this->loadHeaderData();
    }

    public function authorizeAccess()
    {
        if (!Auth::user() || Auth::user()->role !== 1) {
            abort(403, 'Unauthorized');
        }
    }

    public function loadHeaderData()
    {
        $this->pendingOrders = Order::where('status', 'processing')
            ->orWhere('status', 'shipped')
            ->count();
    }
    public function render()
    {
        return view('livewire.admin.layout.header');
    }
}
