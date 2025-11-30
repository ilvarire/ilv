<x-layouts.customer-layout :title="'Contact'">
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-06.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Contact
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            @livewire('customer.contact-form')
        </div>
    </section>

</x-layouts.customer-layout>