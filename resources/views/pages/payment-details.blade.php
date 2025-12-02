<x-layouts.customer-layout :title="$payment->transaction_reference">
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="{{ route('payments') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Payments
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                {{ $payment->transaction_reference }}
            </span>
        </div>
    </div>

    <section class="bg0 p-t-80 p-b-60">
        <div class="container">
            <h3 class="ltext-105 cl5 txt-center respon1 p-b-50">
                # {{ $payment->transaction_reference }}
            </h3>
            @if ($payment->status === 'cancelled')
                <h6 class="txt-center text-111 p-b-15" style="color: maroon;">
                    PAYMENT CANCELLED
                </h6>
            @endif
            @if ($payment->status === 'refunded')
                <h6 class="txt-center text-111 p-b-15" style="color: maroon;">
                    PAYMENT REFUNDED
                </h6>
            @endif
            @if ($payment->status === 'pending')
                <a href="{{ $payment->link ?? '/' }}">
                    <h6 class="txt-center text-111 p-b-15" style="color: seagreen;">
                        PAY NOW
                    </h6>
                </a>

            @endif

            <div class="order-status-bar flex-w flex-c-m m-b-25">
                <!-- Placed Step -->
                <div
                    class="order-step {{ $payment->status !== 'pending' ? 'done' : '' }} {{ $payment->status === 'pending' ? 'active' : '' }}">
                    Pending</div>
                <div class="order-line"></div>

                <!-- Processing Step -->
                <div class="order-step {{ $payment->status === 'paid' ? 'done' : '' }}">
                    Success</div>
            </div>

            <div class="flex-w flex-sb-m p-t-18">
                <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                    <span>
                        <span class="cl4">Date</span>
                        {{ $payment->created_at->format('F j, Y g:i A') }}
                        <span class="cl12 m-l-4 m-r-6">|</span>
                    </span>
                    <span>
                        <span class="cl4">Order</span>
                        <a href="{{ route('orders.details', $payment->order->reference) }}">
                            {{ ucwords($payment->order->status) }}
                        </a>
                        <span class="cl12 m-l-4 m-r-6">|</span>
                    </span>

                    <span>
                        <span class="cl4">{{ ucwords($payment->payment_method) }}</span>
                        {{ Number::currency($payment->amount, 'NGN') }}
                    </span>

                </span>

            </div>

        </div>
    </section>
    @push('styles')
        <style>
            .order-status-bar {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                margin-bottom: 30px;
                gap: 0.5rem;
            }

            .order-step {
                background: #e6e6e6;
                color: #888;
                border-radius: 25px;
                padding: 5px 16px;
                font-family: Poppins-SemiBold;
                font-size: 15px;
                min-width: 90px;
                text-align: center;
                transition: background 0.3s, color 0.3s;
            }

            .order-step.active,
            .order-step.done {
                background: #717fe0;
                color: #fff;
            }

            .order-line {
                flex: 1 1 16px;
                height: 3px;
                background: #dedede;
                margin: 0 6px;
                border-radius: 2px;
            }

            .order-step.done+.order-line {
                background: #717fe0;
            }
        </style>
    @endpush
</x-layouts.customer-layout>