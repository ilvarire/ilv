<?php

namespace App\Http\Controllers;

use App\Helpers\CartSession;
use App\Mail\admin\LowStockAlert;
use App\Mail\admin\NewPaymentFailed;
use App\Mail\admin\NewPaymentReceived;
use App\Mail\admin\Outofstock;
use App\Mail\user\PaymentFailed;
use App\Mail\user\PaymentReceived;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaystackController extends Controller
{
    public function handleGatewayCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('cart')->with('error', 'No payment reference found.');
        }

        $paystack = new PaystackService();
        $response = $paystack->verifyPayment($reference);

        if ($response['status'] && $response['data']['status'] === 'success') {
            $payment = Payment::with('order')->where('transaction_reference', $reference)->first();

            if ($payment) {
                if ($payment->status === 'paid') {
                    return redirect()->route('cart')->with('error', 'Not found.');
                }
                $order = Order::with('items.product.category')->findOrFail($payment->order_id);

                $payment->order->update([
                    'status' => 'processing'
                ]);

                $payment->update([
                    'status' => 'paid'
                ]);

                Mail::to($payment->user->email)->queue(
                    new PaymentReceived($payment->user->name, $payment->order, $payment->payment_method)
                );

                // // Send emails to admin
                $admins = User::where('role', 1)->pluck('email');
                foreach ($admins as $adminEmail) {
                    Mail::to($adminEmail)->queue(new NewPaymentReceived($order->reference, $payment->user->email, $payment->payment_method, $order->total_price, $order->created_at));
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

                CartSession::clearCartItems();
                return redirect()->route('order.success', $payment->order->reference)->with('success', 'Payment successful!');
            }

            return redirect()->route('cart')->with('error', 'Payment Order not found.');
        }

        // ❌ Failed payment
        return redirect()->route('cart')->with('error', 'Payment verification failed.');
    }

    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('Paystack webhook received', $payload);

        // Verify the signature (OPTIONAL but recommended)
        $secret = config('paystack.secretKey');
        $signature = $request->header('x-paystack-signature');

        if (!$signature || !hash_equals(hash_hmac('sha512', $request->getContent(), $secret), $signature)) {
            return response('Unauthorized', 401);
        }

        $event = $payload['event'] ?? null;

        switch ($event) {
            case 'charge.success':
                $this->handleChargeSuccess($payload['data']);
                break;

            case 'charge.failed':
                $this->handleChargeFailed($payload['data']);
                break;

            case 'refund.processed':
                $this->handleRefundProcessed($payload['data']);
                break;
        }

        return response('Webhook Handled', 200);
    }

    private function handleChargeSuccess(array $data)
    {
        $order = Order::with('payment')->where('reference', $data['reference'])->first();
        if ($order->payment->status !== 'paid') {
            $order->update([
                'status' => 'processing',
            ]);
            $order->payment->update([
                'status' => 'paid'
            ]);

            Mail::to($order->user->email)->queue(
                new PaymentReceived($order->user->name, $order, $order->payment->payment_method)
            );

            // // Send emails to admin
            $admins = User::where('role', 1)->pluck('email');
            foreach ($admins as $adminEmail) {
                Mail::to($adminEmail)->queue(new NewPaymentReceived($order->reference, $order->payment->user->email, $order->payment->payment_method, $order->total_price, $order->created_at));
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
        }
    }

    private function handleChargeFailed(array $data)
    {
        $order = Order::with('items.product', 'payment.user')->where('reference', $data['reference'])->first();
        if ($order->payment->status !== 'failed') {
            $order->update([
                'status' => 'cancelled',
            ]);
            $order->payment->update([
                'status' => 'failed'
            ]);

            foreach ($order->items as $item) {
                $product = $item->product;

                if ($product) {
                    // Increment back the quantity that was deducted
                    $product->increment('quantity', $item->quantity);
                }
            }

            Mail::to($order->payment->user->email)->queue(
                new PaymentFailed($order->reference, $order->payment->user->name, $order->payment->payment_method, $order->total_price)
            );

            // // Send emails to admin
            $admins = User::where('role', 1)->pluck('email');
            foreach ($admins as $adminEmail) {
                Mail::to($adminEmail)->queue(new NewPaymentFailed($order->reference, $order->payment->user->name, $order->payment->payment_method, $order->total_price, $order->payment->user->email));
            }
        }
    }

    private function handleRefundProcessed(array $data)
    {
        $order = Order::with('items.product')->where('reference', $data['reference'])->first();
        if ($order) {
            $order->update([
                'status' => 'cancelled',
            ]);
            $order->payment->update([
                'status' => 'refunded'
            ]);

            foreach ($order->items as $item) {
                $product = $item->product;

                if ($product) {
                    // Increment back the quantity that was deducted
                    $product->increment('quantity', $item->quantity);
                }
            }
        }
    }
}
