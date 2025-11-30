<?php

namespace App\Livewire\Customer;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentsTable extends Component
{
    public function render()
    {
        $perPage = 10;
        $payments = Payment::with(['order'])->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->simplePaginate($perPage);

        return view('livewire.customer.payments-table', [
            'payments' => $payments
        ]);
    }
}
