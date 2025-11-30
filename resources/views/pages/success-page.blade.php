<x-layouts.customer-layout :title="'Order Success'">

    <section class="bg0 p-t-80 p-b-60">
        <div class="container flex-c-m flex-col-c">
            <div class="success-icon m-b-32">
                <svg width="96" height="96" viewBox="0 0 96 96">
                    <circle cx="48" cy="48" r="46" fill="#fff" stroke="#6c7ae0" stroke-width="4" />
                    <path d="M30 49l14 14 22-22" stroke="#6c7ae0" stroke-width="6" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <h3 class="ltext-103 cl1 m-b-16">Thank You!</h3>
            <p class="stext-103 cl3 m-b-24 text-center">Your order has been placed successfully. You will receive an
                email
                confirmation shortly.</p>
            <a href="{{ route('products') }}"
                class="flex-c-m stext-101 cl0 bg1 bor14 hov-btn3 p-lr-50 trans-04 pointer p-tb-15">Continue
                Shopping</a>
        </div>
    </section>

    {{--
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            nameProduct = 'Order';
            swal(nameProduct, "payment was successfull!", "success");
            setTimeout(function () {
                window.location.href = '/orders';
            }, 1500);
        });

    </script> --}}
</x-layouts.customer-layout>