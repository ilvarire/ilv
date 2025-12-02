<div>
    <div class="container">
        <div class=" p-t-45 p-b-15">
            <h3 class="ltext-106 cl5 txt-center">
                Related Products
            </h3>
        </div>

        <!-- Slide2 -->
        <div class="wrap-slick2">
            <div class="slick2">
                @forelse ($relatedProducts as $product)
                    <div wire:key="{{rand()}}" wire:ignore.self
                        class="item-slick2 p-l-15 p-r-15 p-b-105 {{$product->category->slug}}">
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
                                        <img class="icon-heart1 dis-block trans-04" src="/images/icons/icon-heart-01.png"
                                            alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                            src="/images/icons/icon-heart-02.png" alt="ICON">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="stext-111 flex-c-m w-full cl6 p-t-45">No products found</p>
                @endforelse
            </div>
        </div>
    </div>


    <div class="wrap-modal1 js-modal1 p-t-60 p-b-20" wire:ignore.self>
        <div class="overlay-modal1 js-hide-modal1"></div>

        @if(isset($selectedProduct) && is_iterable($selectedProduct->images ?? null))
        <div class="container">
            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                <button class="how-pos3 hov3 trans-04 js-hide-modal1" wire:click="$dispatch('close-product-modal')">
                    <img src="/images/icons/icon-close.png" alt="CLOSE">
                </button>

                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div id="slick3" class="wrap-slick3 flex-sb flex-w" wire:ignore>
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