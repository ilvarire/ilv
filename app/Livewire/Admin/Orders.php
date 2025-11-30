<?php

namespace App\Livewire\Admin;

use App\Mail\admin\LowStockAlert;
use App\Mail\admin\NewPaymentReceived;
use App\Mail\admin\Outofstock;
use App\Mail\user\OrderCancelled;
use App\Mail\user\OrderDelivered;
use App\Mail\user\OrderShipped;
use App\Mail\user\PaymentReceived;
use App\Mail\user\RefundProcessed;
use App\Models\Order;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout')]

class Orders extends Component
{

    public $search = '';
    public $status;
    public $selectedOrder;
    public $orderId;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => '']
    ];

    #[On('edit-order')]
    public function confirmingEdit($order)
    {
        $this->getOrder($order);
    }
    protected function getOrder($order)
    {
        $order = Order::with('items.product', 'shippingAddress')
            ->where('reference', $order)->firstOrFail();

        $this->selectedOrder = $order;
    }

    public function confirmOrderPayment($id)
    {
        $order = Order::with('payment', 'user', 'items.product')->findOrFail($id);
        if ($order->payment->status != 'paid') {
            $order->status = 'processing';
            $order->payment->status = 'paid';
            $order->save();
            $order->payment->save();

            Mail::to($order->user->email)->queue(
                new PaymentReceived($order->user->name, $order, $order->payment->payment_method)
            );

            // // Send emails to admin
            $admins = User::where('role', 1)->pluck('email');
            foreach ($admins as $adminEmail) {
                Mail::to($adminEmail)->queue(new NewPaymentReceived($order->reference, $order->user->email, $order->payment->payment_method, $order->total_price, $order->created_at));
            }

            // Check stock levels and send email notifications to admins
            $lowStockProducts = [];
            $outOfStockProducts = [];

            foreach ($order->items as $orderItem) {
                $product = $orderItem->product;
                if ($product->quantity <= 0) {
                    $outOfStockProducts[] = $product;
                } elseif ($product->quantity <= 10) {
                    $lowStockProducts[] = $product;
                }
            }

            // Notify admins about low stock and out of stock products
            $admins = User::where('role', 1)->pluck('email');

            // Notify for low stock
            if (!empty($lowStockProducts)) {
                foreach ($admins as $adminEmail) {
                    Mail::to($adminEmail)->queue(new LowStockAlert($lowStockProducts));
                }
            }

            // Notify for out of stock
            if (!empty($outOfStockProducts)) {
                foreach ($admins as $adminEmail) {
                    Mail::to($adminEmail)->queue(new Outofstock($outOfStockProducts));
                }
            }

            Flux::modal('edit-order')->close();
            $this->reset();
            session()->flash('success', 'Order Marked as Paid!');
            return;
        }
        session()->flash('error', 'Order already marked as paid');
    }

    public function cancelOrder($id)
    {
        $order = Order::with('payment', 'user', 'items.product')->findOrFail($id);
        if ($order->status === 'delivered') {
            session()->flash('error', 'Cannot cancel delivered orders');
            return;
        }
        if ($order->payment->status != 'paid') {
            session()->flash('error', 'Cannot cancel unpaid orders');
            return;
        }
        $order->status = 'cancelled';
        $order->save();
        Flux::modal('edit-order')->close();
        $this->reset();

        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                // Increment back the quantity that was deducted
                $product->increment('quantity', $item->quantity);
            }
        }

        Mail::to($order->payment->user->email)->queue(
            new OrderCancelled($order->payment->user->name, $order->reference, $order->total_price)
        );

        session()->flash('success', 'Order cancelled!');
    }

    public function refundOrder($id)
    {
        $order = Order::with('payment', 'user', 'items.product')->findOrFail($id);
        if ($order->status === 'delivered') {
            Flux::modal('edit-order')->close();
            session()->flash('error', 'Cannot refund delivered orders');
            return;
        }
        if ($order->payment->status != 'paid') {
            Flux::modal('edit-order')->close();
            session()->flash('error', 'Cannot refund unpaid orders');
            return;
        }
        $order->payment_status = 'refunded';
        $order->save();
        Flux::modal('edit-order')->close();

        Mail::to($order->payment->user->email)->queue(
            new RefundProcessed($order->payment->user->name, $order->reference, $order->total_price, $order->payment->payment_method)
        );

        $this->reset();
        session()->flash('success', 'Order Payment Refunded!');
    }
    public function shipOrder($id)
    {
        $order = Order::with('payment', 'user', 'items.product')->findOrFail($id);
        if ($order->status !== 'processing') {
            Flux::modal('edit-order')->close();
            session()->flash('error', 'Only processing orders can be marked as shipped');
            return;
        }

        $order->status = 'shipped';
        $order->save();
        Flux::modal('edit-order')->close();
        $this->reset();

        Mail::to($order->payment->user->email)->queue(
            new OrderShipped($order->payment->user->name, $order->reference)
        );
        session()->flash('success', 'Order marked as Shipped');
    }

    public function completeOrder($id)
    {
        $order = Order::with('payment', 'user', 'items.product')->findOrFail($id);
        if ($order->status !== 'shipped') {
            Flux::modal('edit-order')->close();
            session()->flash('error', 'Only shipped orders can be marked as delivered');
            return;
        }

        $order->status = 'delivered';
        $order->save();
        Flux::modal('edit-order')->close();
        $this->reset();

        Mail::to($order->payment->user->email)->queue(
            new OrderDelivered($order->payment->user->name, $order->reference)
        );
        session()->flash('success', 'Order marked as Delivered');
    }

    #[On('delete-order')]
    public function confirmingDelete($id)
    {
        $this->orderId = $id;
    }

    public function deleteOrder()
    {
        if ($this->orderId) {
            $order = Order::findOrFail($this->orderId);
            if ($order) {
                $order->delete();
                Flux::modal('delete-order')->close();
                session()->flash('success', 'Order deleted');
                $this->reset();
            }
        }
    }
    public function render()
    {
        $orders = Order::with('user')
            ->when($this->search, fn($query) =>
            $query->whereHas(
                'user',
                fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
            ))
            ->when(
                $this->status,
                fn($query) =>
                $query->where('status', $this->status)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('livewire.admin.orders', [
            'orders' => $orders
        ]);
    }
}
