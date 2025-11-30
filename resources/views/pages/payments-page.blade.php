<x-layouts.customer-layout :title="'Payments'">
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Payments
            </span>
        </div>
    </div>

    @livewire('customer.payments-table')

    @push('scripts')
        <script>
            document.querySelectorAll('#paymentTable').forEach(function (td) {
                td.addEventListener('click', function () {
                    const itemId = td.getAttribute('data-id');
                    window.location.href = `/payment/${itemId}`;
                });
            });
        </script>
    @endpush
</x-layouts.customer-layout>