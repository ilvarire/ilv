<section class="bg0 p-t-80 p-b-60">
    <div class="container">
        <h3 class="ltext-105 cl5 txt-center respon1 p-b-50">
            Payments
        </h3>
        <div class="wrap-table-shopping-cart">
            <table class="table-shopping-cart">
                <thead>
                    <tr class="table_head">
                        <th class="column-1">Payment#</th>
                        <th class="column-2"></th>
                        <th class="column-3">Amount</th>
                        <th class="column-4">Status</th>
                        <th class="column-5">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr class="table_row pointer" id="paymentTable" data-id="{{ $payment->transaction_reference }}">
                            <td class="column-1" colspan="2">

                                <a href="{{ route('payment.details', $payment->transaction_reference) }}"
                                    class="flex-m cl2 hov1 p-r-15 p-t-10">

                                    {{$payment->transaction_reference }}
                                </a>
                            </td>
                            <td class="column-3">
                                {{ Number::currency($payment->amount, 'GBP') }}
                            </td>
                            <td class="column-4">
                                <span class="p-lr-15 {{ $payment->status === 'Paid' ? 'cl1' : 'cl11' }}">
                                    {{ ucwords($payment->status) }}
                                </span>
                            </td>
                            <td class="column-5">
                                {{ $payment->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr class="table_row">
                            <td class="column-1" colspan="5">
                                <p class="stext-111 cl6 p-t-2">
                                    No payments found.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
            @if ($payments->onFirstPage())
                <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled">
                    <i class="fa fa-long-arrow-left"></i>
                </span>
            @else
                <a href="{{ $payments->previousPageUrl() }}"
                    class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">
                    <i class="fa fa-long-arrow-left"></i>
                </a>
            @endif

            <!-- Next Link -->
            @if ($payments->hasMorePages())
                <a href="{{ $payments->nextPageUrl() }}"
                    class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">
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