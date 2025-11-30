<footer class="bg3 p-t-75 p-b-32">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Categories
                </h4>

                <ul>
                    @forelse ($categories as $cat)
                        <li class="p-b-10">
                            <a href="{{ route('products', ['category' => $cat->slug]) }}"
                                class="stext-107 cl7 hov-cl1 trans-04">
                                {{ str($cat->name)->title() }}
                            </a>
                        </li>
                    @empty

                    @endforelse

                </ul>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Links
                </h4>

                <ul>

                    <li class="p-b-10">
                        <a href="{{ route('products') }}" class="stext-107 cl7 hov-cl1 trans-04">
                            Products
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="{{ route('wishlist') }}" class="stext-107 cl7 hov-cl1 trans-04">
                            Wishlist
                        </a>
                    </li>
                    <li class="p-b-10">
                        <a href="{{ route('contact') }}" class="stext-107 cl7 hov-cl1 trans-04">
                            Contact
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="{{ route('policy')}}" class="stext-107 cl7 hov-cl1 trans-04">
                            Policy
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    SOCIALS
                </h4>

                <div class="p-t-5">
                    <a href="{{ $contact->instagram_link }}" class="fs-30 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-instagram"></i>
                    </a>

                    <a href="{{ $contact->whatsapp_link }}" class="fs-30 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-whatsapp"></i>
                    </a>

                    <a href="{{ $contact->facebook_link }}" class="fs-30 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-facebook"></i>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Newsletter
                </h4>

                <form wire:submit.prevent="subscribe" method="post">
                    <div class="wrap-input1 w-full p-b-4">
                        <input class="input1 bg-none plh1 stext-107 cl7" type="email" wire:model="email"
                            placeholder="johndoe@example.com" required>
                        <div class="focus-input1 trans-04"></div>
                        @error ('email')
                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                        @enderror
                    </div>

                    <div class="p-t-18">
                        <button type="submit"
                            class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                            Subscribe
                        </button>
                        @if (session('status') === 'subscribed')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2000)" class="m-t-4" style="color: seagreen;">
                                {{ __('Thank you.') }}
                            </p>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        <div class="p-t-40">
            <div class="flex-c-m flex-w p-b-18">
                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
                </a>
            </div>

            <p class="stext-107 cl6 txt-center">
                Copyright © {{ date('Y') }} {{ config('app.name') }}. All rights reserved
            </p>
        </div>
    </div>
</footer>