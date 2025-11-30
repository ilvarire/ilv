<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrdersTable extends Component
{
    public function render()
    {
        $perPage = 10;
        $orders = Order::with(['items.product.images'])->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->simplePaginate($perPage);

        return view('livewire.customer.orders-table', [
            'orders' => $orders
        ]);
    }
}
