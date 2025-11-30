<x-layouts.customer-layout :title="'Products'">
    <section class="bg0 p-t-23 p-b-140">
        @livewire('customer.product-section', ['page' => 'products'])
    </section>
</x-layouts.customer-layout>