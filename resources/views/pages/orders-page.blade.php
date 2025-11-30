<x-layouts.customer-layout :title="'My Orders'">
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                My Orders
            </span>
        </div>
    </div>

    @livewire('customer.orders-table')

    @push('scripts')
        <script>
            document.querySelectorAll('#orderTable').forEach(function (td) {
                td.addEventListener('click', function () {
                    const itemId = td.getAttribute('data-id');
                    window.location.href = `/order/${itemId}`;
                });
            });
        </script>
    @endpush
</x-layouts.customer-layout>