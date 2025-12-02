<section class="bg0 p-t-80 p-b-60">
    <div class="container">
        <h3 class="ltext-105 cl5 txt-center respon1 p-b-50">
            My Orders
        </h3>
        <div class="wrap-table-shopping-cart">
            <table class="table-shopping-cart">
                <thead>
                    <tr class="table_head">
                        <th class="column-1">Order#</th>
                        <th class="column-2"></th>
                        <th class="column-3">Total</th>
                        <th class="column-4">Status</th>
                        <th class="column-5">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="table_row pointer" id="orderTable" data-id="{{ $order->reference }}">
                            <td class="column-1" colspan="2">

                                <a href="{{ route('orders.details', $order->reference) }}"
                                    class="flex-m cl2 hov1 p-r-15 p-t-10">
                                    <div class="wrao-pic-w size-214">
                                        <img width="40px"
                                            src="{{ asset('storage/' . $order->items->first()->product->images->first()->image_url) }}"
                                            alt="IMG">
                                    </div>
                                    {{$order->reference }}
                                </a>
                            </td>
                            <td class="column-3">
                                {{ Number::currency($order->total_price, 'NGN') }}
                            </td>
                            <td class="column-4">
                                <span class="p-lr-15 {{ $order->status === 'delivered' ? 'cl1' : 'cl11' }}">
                                    {{ ucwords($order->status) }}
                                </span>
                            </td>
                            <td class="column-5">
                                {{ $order->created_at->diffForHumans() }}
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

        <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
            @if ($orders->onFirstPage())
                <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled">
                    <i class="fa fa-long-arrow-left"></i>
                </span>
            @else
                <a href="{{ $orders->previousPageUrl() }}"
                    class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">
                    <i class="fa fa-long-arrow-left"></i>
                </a>
            @endif

            <!-- Next Link -->
            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">
                    <i class="fa fa-long-arrow-right"></i>
                </a>
            @else
                <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled">
                    <i class="fa fa-long-arrow-right"></i>
                </span>
            @endif
        </div>

    </div>
</section>