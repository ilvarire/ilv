<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]

class Payments extends Component
{
    use WithPagination;

    public $search = '';
    public $status;
    public $selectedPayment;
    public $paymentId;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => '']
    ];

    #[On('edit-payment')]
    public function confirmingEdit($payment)
    {
        $this->getPayment($payment);
    }
    protected function getPayment($payment)
    {
        $payment = Payment::with('user', 'order.coupon')
            ->where('transaction_reference', $payment)->firstOrFail();

        $this->selectedPayment = $payment;
    }

    public function confirmPayment($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->status != 'paid') {
            $payment->order->status = 'processing';
            $payment->status = 'paid';
            $payment->save();

            // Mail::to(Auth::user()->email)->send(
            //     new NewOrderNotification($payment)
            // );

            // Mail::to($payment->user->email)->send(
            //     new OrderPlaced($payment)
            // );

            Flux::modal('edit-payment')->close();
            $this->reset();
            session()->flash('success', 'Payment Marked as Paid!');
            return;
        }
        session()->flash('error', 'Payment already marked as paid');
    }

    public function cancelPayment($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->order->status === 'completed') {
            session()->flash('error', 'Cannot cancel payment for completed orders');
            return;
        }
        if ($payment->status != 'paid') {
            session()->flash('error', 'Cannot cancel unpaid payments');
            return;
        }
        $payment->status = 'cancelled';
        $payment->save();
        Flux::modal('edit-payment')->close();
        $this->reset();
        // Mail::to($payment->user->email)->send(
        //     new OrderCancelled($payment)
        // );
        session()->flash('success', 'Payment cancelled!');
    }

    public function refundPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'refunded';
        $payment->save();
        Flux::modal('edit-payment')->close();
        $this->reset();
        session()->flash('success', 'Payment Refunded!');
    }


    #[On('delete-payment')]
    public function confirmingDelete($id)
    {
        $this->paymentId = $id;
    }

    public function deletePayment()
    {
        if ($this->paymentId) {
            $payment = Payment::findOrFail($this->paymentId);
            if ($payment) {
                $payment->delete();
                Flux::modal('delete-payment')->close();
                session()->flash('success', 'Payment deleted');
                $this->reset();
            }
        }
    }
    public function render()
    {
        $payments = Payment::with('user')
            ->when($this->search, fn($query) =>
            $query->whereHas(
                'order',
                fn($q) =>
                $q->where('reference', 'like', '%' . $this->search . '%')
            ))
            ->when(
                $this->status,
                fn($query) =>
                $query->where('status', $this->status)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('livewire.admin.payments', [
            'payments' => $payments
        ]);
    }
}
