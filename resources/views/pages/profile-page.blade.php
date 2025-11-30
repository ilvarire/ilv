<x-layouts.customer-layout :title="'Account'">
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-06.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            My Account
        </h2>
    </section>

    @livewire('customer.profile-form')

</x-layouts.customer-layout>