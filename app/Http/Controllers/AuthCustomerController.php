<?php

namespace App\Http\Controllers;

use App\Helpers\CartSession;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCustomerController extends Controller
{
    public function checkout()
    {
        $cart_count = count(CartSession::getCartItemsFromSession());
        if ($cart_count < 1) {
            return redirect(route('cart'));
        }
        return view('pages.checkout-page');
    }
    public function orders()
    {
        return view('pages.orders-page');
    }

    public function orderDetails($reference)
    {

        $order = Order::with(['items.product', 'coupon', 'shippingAddress.shippingFee', 'payment'])
            ->where('reference', $reference)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            abort(404, 'Page not found');
        }

        return view('pages.order-details', ['order' => $order]);
    }
    public function successPage($transaction_reference)
    {
        $payment = Payment::where('user_id', Auth::user()->id)
            ->where('status', 'paid')
            ->where('transaction_reference', $transaction_reference)
            ->firstOrFail();
        return view('pages.success-page', [
            'payment' => $payment
        ]);
    }

    public function profile()
    {
        return view('pages.profile-page');
    }

    public function payments()
    {
        return view('pages.payments-page');
    }

    public function paymentDetails($reference)
    {

        $payment = Payment::with(['order'])
            ->where('transaction_reference', $reference)
            ->where('user_id', Auth::id())
            ->first();

        if (!$payment) {
            abort(404, 'Page not found');
        }

        return view('pages.payment-details', ['payment' => $payment]);
    }
}
