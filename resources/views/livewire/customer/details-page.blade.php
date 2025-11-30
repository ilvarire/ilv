<!-- Product Detail -->
<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
                <div class="p-l-25 p-r-30 p-lr-0-lg">
                    <div class="wrap-slick3 flex-sb flex-w" wire:ignore>
                        <div class="wrap-slick3-dots"></div>
                        <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                        <div class="slick3 gallery-lb">
                            @foreach($product->images as $image)
                                <div class="item-slick3" wire:key="{{rand()}}"
                                    data-thumb="{{ asset('storage/' . $image->image_url) }}">
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
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                        {{ $product->name}}
                    </h4>

                    <span class="mtext-106 cl2">
                        {{ Number::currency($product->price, 'GBP') }}
                    </span>

                    <p class="stext-102 cl3 p-t-23">
                        {{ $product->brief}}
                    </p>
                    <p class="stext-109 p-t-2" style="color: {{$product->quantity < 20 ? 'maroon' : 'black'}};">
                        {{ $product->quantity }}
                        @if ($product->quantity < 20)
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
                        <div class="flex-w flex-c-m txt-center">
                            <div class="size-204 flex-w flex-c-m respon6-next">
                                <div class="m-r-11 m-b-10"
                                    style="display: flex; text-align: left; justify-content: start; align-items: center; border: 1px solid #d0d0d0; border-radius: 5px;">

                                    <div style="cursor: pointer;" wire:click="decreaseQuantity">
                                        <i class="fs-16 zmdi zmdi-minus p-lr-15"></i>
                                    </div>
                                    <input type="text" class="cl3" wire:model.live="quantity" id="quantity" value="1"
                                        min="1" max="100"
                                        style="text-align: center; background-color: #fff; height: 40px; width: 35px; padding: 5px;">

                                    <div style="cursor: pointer;" wire:click="increaseQuantity">
                                        <i class="fs-16 zmdi zmdi-plus p-lr-15"></i>
                                    </div>
                                </div>

                                <button wire:click="addToCart('{{ $product->slug }}', {{ $this->quantity }})"
                                    class="flex-c-m  m-b-10 stext-101 cl0 size-101 p-lr-15 trans-04 js-addcart-detail {{ $product->quantity > 0 ? 'bg1 bor1 hov-btn1' : 'bor1 bg2' }}"
                                    {{ $product->quantity > 0 ? '' : 'disabled' }}>
                                    {{ $product->quantity > 0 ? 'Add to cart' : 'Out of Stock' }}
                                </button>
                            </div>
                        </div>
                        @error ('quantity')
                            <h3 class="stext-111 flex-c-m cl6 p-t-2" style="color: maroon">
                                {{$message}}
                            </h3>
                        @enderror
                    </div>
                    <!--  -->
                    <div class="flex-w flex-c-m p-t-40">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="javascript:;" wire:click="addToWish('{{ $product->slug }}', 'modal')"
                                class="fs-14 {{ $this->isInWishlist($product->id) ? 'cl1' : 'cl3'}} hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 tooltip100"
                                data-tooltip="Add to Wishlist">
                                <i class="zmdi zmdi-favorite"></i>
                            </a>
                        </div>

                        @livewire('customer.product-socials', ['product_id' => $product->id])
                    </div>
                </div>
            </div>
        </div>

        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                    </li>

                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional
                            information</a>
                    </li>

                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews
                            ({{$reviews->count()}})</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-43">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6">
                                {{ $product->description}}
                            </p>
                            <br>
                            @if (session()->has('success'))
                                <p class="stext-102 cl6" style="color: seagreen">
                                    {{session('success')}}
                                </p>
                            @endif
                            @error('rating')
                                <p class="stext-102" style="color:brown">{{ $message }}</p>
                            @enderror
                            @error('message')
                                <p class="stext-102" style="color:brown">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- - -->
                    <div class="tab-pane fade" id="information" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <ul class="p-lr-28 p-lr-15-sm">
                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Weight
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            {{ $product->weight}} kg
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Dimensions
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            {{ $product->dimensions}}
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Materials
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            {{ $product->materials}}
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Color
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            Black, Blue, Grey, Green, Red, White
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Size
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            XL, L, M, S
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- - -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <div class="p-b-30 m-lr-15-sm">
                                    <!-- Review -->
                                    <div class="flex-w flex-t p-b-68">
                                        @forelse ($reviews as $review)
                                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                <img src="{{ asset('/images/user.png')}}" alt="AVATAR">
                                            </div>
                                            <div class="size-207">
                                                <div class="flex-w flex-sb-m p-b-17">
                                                    <span class="mtext-107 cl2 p-r-20">
                                                        {{$review->user->name}}
                                                    </span>

                                                    <span class="fs-18 cl11">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="zmdi zmdi-star {{$i <= $review->rating ? '' : 'c16'}}"></i>
                                                        @endfor

                                                        {{-- <i class="zmdi zmdi-star-half"></i> --}}
                                                    </span>
                                                </div>

                                                <p class="stext-102 cl6">
                                                    {{ $review->comment }}
                                                </p>
                                            </div>
                                        @empty
                                            <p class="stext-102 cl6">
                                                No reviews yet
                                            </p>
                                        @endforelse
                                    </div>
                                    @if ($canReview)
                                        <!-- Add review -->

                                        <h5 class="mtext-108 cl2 p-b-7">
                                            Add a review
                                        </h5>

                                        <div class="flex-w flex-m p-t-50 p-b-23" x-data="{ rating: @entangle('rating') }">
                                            <span class="stext-102 cl3 m-r-16">
                                                Your Rating
                                            </span>

                                            <span class="wrap-rating fs-18 cl11 pointer" wire:ignore>

                                                <template x-for="star in 5">
                                                    <i @click="rating = star" :style="rating >= star ? 'color: yellow' : ''"
                                                        class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                </template>
                                                <input class="dis-none" type="number" name="rating">
                                            </span>
                                        </div>

                                        <div class="row p-b-25">
                                            <div class="col-12 p-b-5">
                                                <label class="stext-102 cl3" for="review">Your review</label>
                                                <textarea wire:model.defer="message"
                                                    class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review"
                                                    name="review"></textarea>
                                            </div>
                                        </div>
                                        <button wire:click="submitReview"
                                            class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                            Submit
                                        </button>
                                    @else
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
        <span class="stext-107 cl6 p-lr-25">
            Tags:
            @forelse($product->tags as $tag)
                {{$tag->name}},
            @empty
                n/a
            @endforelse
        </span>

        <span class="stext-107 cl6 p-lr-25">
            Category: {{ $product->category->name}}
        </span>
    </div>

</section>