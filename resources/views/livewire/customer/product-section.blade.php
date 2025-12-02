<div>
    <div class="container">
        @if ($page !== 'products')
            <div class="p-b-10">
                <h3 class="ltext-105 cl5 txt-center respon1">
                    Products
                </h3>
            </div>
        @endif
        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10" wire:ignore>
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5">
                    🛒🛍️
                </button>
            </div>

            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                    <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Filter
                </div>

                <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                    <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                    <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Search
                </div>
            </div>

            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15" wire:ignore>
                <div class="bor8 dis-flex p-l-15">
                    <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>

                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" style="background: #fff" type="text"
                        wire:model.live.debounce.500ms="search" placeholder="Search">
                </div>
            </div>

            <!-- Filter -->
            <div class="dis-none panel-filter w-full p-t-10" wire:ignore.self>
                <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                    <div class="filter-col1 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Sort By
                        </div>

                        <ul>
                            <li class="p-b-6">
                                <button wire:click="setSort('default')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'default',
                                    'filter-link stext-106 trans-04' => $sort !== 'default',
                                ])>
                                    Default
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setSort('popularity')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'popularity',
                                    'filter-link stext-106 trans-04' => $sort !== 'popularity',
                                ])>
                                    Popularity
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setSort('newness')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'newness',
                                    'filter-link stext-106 trans-04' => $sort !== 'newness',
                                ])>
                                    Newness
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setSort('price_low_high')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'price_low_high',
                                    'filter-link stext-106 trans-04' => $sort !== 'price_low_high',
                                ])>
    Price: Low to High
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setSort('price_high_low')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'price_high_low',
                                    'filter-link stext-106 trans-04' => $sort !== 'price_high_low',
                                ])>
    Price: High to Low
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-col2 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Price
                        </div>

                        <ul>
                            <li class="p-b-6">
                                <button wire:click="setPriceRange('{{null}}')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === null,
                                    'filter-link stext-106 trans-04' => $priceRange !== null,
                                ])>
    All
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setPriceRange('0-50')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '0-50',
                                    'filter-link stext-106 trans-04' => $priceRange !== '0-50',
                                ])>
    $0.00 - $50.00
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setPriceRange('50-100')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '50-100',
                                    'filter-link stext-106 trans-04' => $priceRange !== '50-100',
                                ])>
    $50.00 - $100.00
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setPriceRange('100-150')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '100-150',
                                    'filter-link stext-106 trans-04' => $priceRange !== '100-150',
                                ])>
    $100.00 - $150.00
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setPriceRange('150-200')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '150-200',
                                    'filter-link stext-106 trans-04' => $priceRange !== '150-200',
                                ])>
    $150.00 - $200.00
                                </button>
                            </li>

                            <li class="p-b-6">
                                <button wire:click="setPriceRange('200+')" @class([
                                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '200+',
                                    'filter-link stext-106 trans-04' => $priceRange !== '200+',
                                ])>
                    $200.00+
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-col4 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Categories
                        </div>

                        <div class="flex-w p-t-4 m-r--5">
                            <button wire:click="setCategory('{{null}}')" @class([
                                'flex-c-m stext-107 cl1 size-301 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $category === null,
                                'flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $category !== null,
                            ])>
                                All
                            </button>
                            @forelse ($categories as $cat)
                                <button wire:click="setCategory('{{ $cat->slug }}')" @class([
                                    'flex-c-m stext-107 cl1 size-301 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $category === $cat->slug,
                                    'flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $category !== $cat->slug,
                                ])>
                                    {{$cat->name}}
                                </button>
                            @empty
                            @endforelse

                        </div>
                    </div>

                    <div class="filter-col4 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Tags
                        </div>

                        <div class="flex-w p-t-4 m-r--5">
                            <button wire:click="setTag('{{null}}')" @class([
                                'flex-c-m stext-107 cl1 size-301 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $tag === null,
                                'flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $tag !== null,
                            ])>
                                All
                            </button>
                            @forelse ($tags as $t)
                                <button wire:click="setTag('{{ $t->slug }}')" @class([
                                    'flex-c-m stext-107 cl1 size-301 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $tag === $t->name,
                                    'flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $tag !== $t->name,
                                ])>
                                    {{$t->name}}
                                </button>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row isotope-grid">
            @forelse ($products as $product)
                <div wire:key="{{rand()}}" wire:ignore.self
                    class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->category->slug}}">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0"
                            style="border-top-left-radius: 25px; border-bottom-right-radius: 25px;">
                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="IMG-PRODUCT">
                            <a href="javascript:;"
                                wire:click="$dispatch('view-product', { product: '{{ $product->slug }}' })"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="{{ route('product.details', $product->slug)}}"
                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{$product->name}}
                                </a>

                                <span class="stext-105 cl3">
                                    {{ Number::currency($product->price, 'NGN') }}
                                </span>
                            </div>

                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="javascript:;" wire:click="addToWish('{{ $product->slug }}')"
                                    class="btn-addwish-b2 dis-block pos-relative {{ $this->isInWishlist($product->id) ? 'js-addedwish-b2' : ''}}">
                                    <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                        alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png"
                                        alt="ICON">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="stext-111 flex-c-m w-full cl6 p-t-45">No products found</p>
            @endforelse
        </div>

        <!-- Load more -->
        @if ($products->hasMorePages())
            <div class="flex-c-m flex-w w-full p-t-45">
                <a href="javascript:;" wire:click="loadMore"
                    class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                    Load More
                </a>
            </div>
        @endif
    </div>


    <div class="wrap-modal1 js-modal1 p-t-60 p-b-20" wire:ignore.self>
        <div class="overlay-modal1 js-hide-modal1"></div>

        @if(isset($selectedProduct) && is_iterable($selectedProduct->images ?? null))
        <div class="container">
            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                <button class="how-pos3 hov3 trans-04 js-hide-modal1" wire:click="$dispatch('close-product-modal')">
                    <img src="images/icons/icon-close.png" alt="CLOSE">
                </button>

                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div id="slick3" class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                <div class="slick3 gallery-lb">
                                    @forelse($selectedProduct->images as $image)
                                    <div class="item-slick3" data-thumb="{{ asset('storage/' . $image->image_url) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="IMG-PRODUCT">
                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ asset('storage/' . $image->image_url) }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="p-r-50 p-t-5 p-lr-0-lg">
                            <a href="{{ route('product.details', $selectedProduct->slug)}}">
                                <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                    {{ $selectedProduct->name }}
                                </h4>
                            </a>

                            <span class="mtext-106 cl2">
                                {{ Number::currency($selectedProduct->price, 'NGN') }}
                            </span>

                            <p class="stext-102 cl3 p-t-23">
                                {{ $selectedProduct->brief }}
                            </p>
                            <p class="stext-109 p-t-2"
                                style="color: {{$selectedProduct->quantity < 20 ? 'maroon' : 'black'}};">
                                {{ $selectedProduct->quantity }}
                                @if ($selectedProduct->quantity < 20)
                                    LEFT
                                @else
                                    AVAILABLE
                                @endif
                                <span class="fs-18 cl11" style="margin-left: 5px;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="zmdi zmdi-star {{$i <= $product->averageRating() ? '' : 'cl3'}}"></i>

                                    @endfor

                                    <span class="cl3 stext-111">
                                        {{$product->averageRating() ? number_format($product->averageRating(), 1) : '0.0'}}
                                        Rating
                                    </span>
                                </span>
                            </p>

                            <!--  -->
                            <div class="p-t-33">
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-204 flex-w flex-m respon6-next">
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div wire:click="decreaseQuantity"
                                                class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="text" disabled
                                                name="num-product" name="quantity" value="{{ $quantity }}">

                                            <div wire:click="increaseQuantity"
                                                class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>

                                        <button
                                            wire:click="addToCart('{{ $selectedProduct->slug }}', {{ $this->quantity }})"
                                            {{--
                                            wire:click="$dispatch('alert-modal', { message: 'Added to cart', type: 'error', product: '{{ $selectedProduct->name }}' })"
                                            --}}
                                            class="flex-c-m stext-101 cl0 size-101 p-lr-15 trans-04 js-addcart-detail {{ $selectedProduct->quantity > 0 ? 'bg1 bor1 hov-btn1' : 'bor1 bg2' }}"
                                            {{ $selectedProduct->quantity > 0 ? '' : 'disabled' }}>
                                            {{ $selectedProduct->quantity > 0 ? 'Add to cart' : 'Out of Stock' }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!--  -->
                            <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                <div class="flex-m bor9 p-r-10 m-r-11">
                                    <a href="javascript:;"
                                        wire:click="addToWish('{{ $selectedProduct->slug }}', 'modal')"
                                        class="fs-14 {{ $this->isInWishlist($selectedProduct->id) ? 'cl1' : 'cl3'}} hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 tooltip100"
                                        data-tooltip="Add to Wishlist">
                                        <i class="zmdi zmdi-favorite"></i>
                                    </a>
                                </div>

                                @livewire('customer.product-socials', ['product_id' => $selectedProduct->id])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>