<header class="{{ $version ?? '' }}">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    {{ $site->top_text }}
                </div>

                <div class="right-top-bar flex-w h-full">
                    @auth
                        <a href="{{ route('profile') }}" class="flex-c-m trans-04 p-lr-25">
                            My Account
                        </a>

                        <a href="{{ route('orders') }}" class="flex-c-m trans-04 p-lr-25">
                            Orders
                        </a>

                        <form action="{{ route('logout') }}" method="post" id="logout">
                            @csrf

                        </form>
                        <button type="submit" form="logout" class="flex-c-m trans-04 p-lr-25">
                            <div class="left-top-bar">
                                Logout
                            </div>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25">
                            Register
                        </a>
                        <a href="#footer" class="flex-c-m trans-04 p-lr-25">
                            Help
                        </a>
                    @endauth

                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('storage/' . $site->logo) }}" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <ul class="main-menu">
                    <li class="{{request()->is('/') ? 'active-menu' : ''}}">
                        <a href="{{ route('home') }}">Home</a>

                    </li>

                    <li class="label1 {{request()->is('products') ? 'active-menu' : ''}}" data-label1="hot">
                        <a href="{{ route('products') }}">Shop</a>
                    </li>

                    <li class="{{request()->is('cart') ? 'active-menu' : ''}}">
                        <a href="{{ route('cart') }}">Cart</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                            @auth
                                <li><a href="{{ route('orders') }}">Orders</a></li>
                                <li><a href="{{ route('payments') }}">Payments</a></li>
                            @endauth
                        </ul>
                    </li>

                    <li class="{{request()->is('about') ? 'active-menu' : ''}}">
                        <a href="{{ route('about') }}">About</a>
                    </li>

                    <li class="{{request()->is('contact') ? 'active-menu' : ''}}">
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">

                    @livewire('customer.cart-count')

                    @livewire('customer.wish-count')
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="{{ route('home') }}">
                <img src="{{ asset('storage/' . $site->logo) }}" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">

            @livewire('customer.cart-count')

            @livewire('customer.wish-count')
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    {{ $site->top_text }}
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    @auth
                        <a href="{{ route('profile') }}" class="flex-c-m p-lr-10 trans-04">
                            My Account
                        </a>

                        <a href="{{ route('orders') }}" class="flex-c-m p-lr-10 trans-04">
                            Orders
                        </a>

                        <form action="{{ route('logout') }}" method="post" id="logout">
                            @csrf

                        </form>

                        <button type="submit" form="logout" class="flex-c-m p-lr-10 trans-04">
                            <div class="left-top-bar">
                                Logout
                            </div>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex-c-m p-lr-10 trans-04">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex-c-m p-lr-10 trans-04">
                            Register
                        </a>
                        <a href="{{ route('contact') }}" class="flex-c-m p-lr-10 trans-04">
                            Help
                        </a>
                    @endauth

                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="{{ route('home') }}">Home</a>

            </li>

            <li>
                <a href="{{ route('products') }}" class="label1 rs1" data-label1="hot">Shop</a>
            </li>

            <li>
                <a href="{{ route('cart') }}">Cart</a>
                <ul class="sub-menu-m">
                    <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                    @auth
                        <li><a href="{{ route('orders') }}">Orders</a></li>
                        <li><a href="{{ route('payments') }}">Payments</a></li>
                    @endauth

                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="{{ route('about') }}">About</a>

            </li>

            <li>
                <a href="{{ route('contact') }}">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    @livewire('customer.search-modal')
</header>