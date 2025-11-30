<x-layouts.customer-layout :title="'Checkout'">
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            @php
                $previousUrl = url()->previous();
                $previousSegments = explode('/', $previousUrl);
                $lastSegment = end($previousSegments);
            @endphp

            @if($lastSegment)
                @if (ucfirst($lastSegment) == 'Cart')
                    <a href="{{ url('/') }}" class="stext-109 cl8 hov-cl1 trans-04">
                        Home
                        <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                    </a>
                @else
                    <a href="{{ $previousUrl }}" class="stext-109 cl8 hov-cl1 trans-04">
                        {{ ucfirst($lastSegment) }}
                        <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                    </a>
                @endif
            @else
                <a href="{{ url('/') }}" class="stext-109 cl8 hov-cl1 trans-04">
                    Home
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>
            @endif
            <span class="stext-109 cl4">
                Checkout
            </span>
        </div>
    </div>

    <!-- Shoping Cart -->
    @livewire('customer.checkout')


</x-layouts.customer-layout>