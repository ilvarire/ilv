<x-layouts.customer-layout :title="$order->reference">
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="{{ route('orders') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Orders
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                {{ $order->reference }}
            </span>
        </div>
    </div>

    <section class="bg0 p-t-80 p-b-60">
        <div class="container">
            <h3 class="ltext-105 cl5 txt-center respon1 p-b-50">
                # {{ $order->reference }}
            </h3>
            @if ($order->status === 'cancelled')
                <h6 class="txt-center text-111 p-b-15" style="color: maroon;">
                    ORDER CANCELLED
                </h6>
            @endif

            <div class="order-status-bar flex-w flex-c-m m-b-25">
                <!-- Placed Step -->
                <div
                    class="order-step {{ $order->status !== 'pending' ? 'done' : '' }} {{ $order->status === 'pending' ? 'active' : '' }}">
                    Pending</div>
                <div class="order-line"></div>

                <!-- Processing Step -->
                <div
                    class="order-step {{$order->status === 'shipped' || $order->status === 'delivered' ? 'done' : '' }} {{ $order->status === 'processing' ? 'active' : '' }}">
                    Processing</div>
                <div class="order-line"></div>

                <!-- Shipped Step -->
                <div
                    class="order-step {{$order->status === 'delivered' ? 'done' : '' }} {{ $order->status === 'shipped' ? 'active' : '' }}">
                    Shipped</div>
                <div class="order-line"></div>

                <!-- Delivered Step -->
                <div class="order-step {{ $order->status === 'delivered' ? 'active' : '' }}">
                    Delivered</div>
            </div>

            <div class="flex-w flex-sb-m p-t-18">
                <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                    <span>
                        <span class="cl4">Date</span>
                        {{ $order->created_at->format('F j, Y g:i A') }}
                        <span class="cl12 m-l-4 m-r-6">|</span>
                    </span>
                    <span>
                        <span class="cl4">Payment</span> {{ ucwords($order->payment->status) }}
                        <span class="cl12 m-l-4 m-r-6">|</span>
                    </span>

                    <span>
                        <span class="cl4">{{ ucwords($order->payment->payment_method) }}</span>
                        {{ Number::currency($order->total_price, 'GBP') }}
                        <span class="cl12 m-l-4 m-r-6">|</span>
                    </span>
                    <span>
                        <span class="cl4">Discount</span>
                        {{ $order->coupon_id ? $order->coupon->discount_percentage . '%(' . $order->coupon->code . ')' : '--'}}
                        <span class="cl12 m-l-4 m-r-6">|</span>
                    </span>
                    <span>
                        {{ count($order->items) }} Item(s)
                    </span>
                </span>

            </div>

            <div class="p-t-55">
                <h4 class="mtext-112 cl2 p-b-15">
                    Shipping Details
                </h4>

                <ul>
                    <li>
                        <span class="cl4">Country:</span> {{ ucwords($order->shippingAddress->country->name) }}
                    </li>

                    <li>
                        <span class="cl4">State:</span> {{ ucwords($order->shippingAddress->shippingFee->state) }}
                    </li>

                    <li>
                        <span class="cl4">Address:</span> {{ ucwords($order->shippingAddress->address) }}
                    </li>

                    <li>
                        <span class="cl4">City:</span> {{ ucwords($order->shippingAddress->city) }}
                    </li>
                    <li>
                        <span class="cl4">Zip/Postcode:</span> {{ $order->shippingAddress->zip_code }}

                    </li>

                    <li>
                        <span class="cl4">Phone Number:</span> {{ $order->shippingAddress->phone_number }}
                    </li>
                </ul>
            </div>

            <h4 class="mtext-112 cl2 p-b-15 p-t-30">
                Order Items
            </h4>
            <div class="wrap-table-shopping-cart">
                <table class="table-shopping-cart">
                    <thead>
                        <tr class="table_head">
                            <th class="column-1">Product</th>
                            <th class="column-2">Name</th>
                            <th class="column-3">Price</th>
                            <th class="column-4">Qty</th>
                            <th class="column-5">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->items as $item)
                            <tr class="table_row">
                                <td class="column-1">
                                    <a href="{{ route('product.details', $item->product->slug) }}" class="cl2 hov1">
                                        <div class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                            <img width="90px"
                                                src="{{ asset('storage/' . $item->product->images->first()->image_url) }}"
                                                alt="IMG">
                                        </div>
                                    </a>
                                </td>
                                <td class="column-2">
                                    {{$item->product->name }}
                                </td>
                                <td class="column-3">
                                    {{ Number::currency($item->product->price, 'GBP') }}
                                </td>
                                <td class="column-4">
                                    {{ $item->quantity }}
                                    {{-- <span class="p-lr-15 {{ $order->status === 'delivered' ? 'cl1' : 'cl11' }}">
                                        {{ ucwords($order->status) }}
                                    </span> --}}
                                </td>
                                <td class="column-5">
                                    {{ Number::currency($item->price, 'GBP') }}
                                    {{-- {{ $order->created_at->diffForHumans() }} --}}
                                </td>
                            </tr>
                        @empty
                            <tr class="table_row">
                                <td class="column-1" colspan="5">
                                    <p class="stext-111 cl6 p-t-2">
                                        No Orders found.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
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