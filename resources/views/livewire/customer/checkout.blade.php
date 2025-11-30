<!-- Shoping Cart -->
<form class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart" wire:ignore.self>
                            <tr class="table_head">
                                <th class="column-1">Product</th>
                                <th class="column-2"></th>
                                <th class="column-3">Price</th>
                                <th class="column-4">Quantity</th>
                                <th class="column-5">Total</th>
                            </tr>
                            @forelse ($cart_items as $item)
                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{ asset('storage/' . $item['images']->first()->image_url) }}"
                                                alt="IMG">
                                        </div>
                                    </td>

                                    <td class="column-2">
                                        <a href="{{ route('product.details', $item['slug']) }}"
                                            class="cl3 pointer">{{ $item['name'] }}</a>
                                        <br>
                                        <p class="stext-109 p-t-2"
                                            style="color: {{$item['stock'] < 20 ? 'maroon' : 'grey'}};">
                                            {{ $item['stock'] }}
                                            @if ($item['stock'] < 20)
                                                LEFT
                                            @else
                                                Available
                                            @endif

                                        </p>
                                    </td>
                                    <td class="column-3">{{ Number::currency($item['unit_price'], 'GBP') }}</td>
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class="btn-num-product-down cl8 trans-04 flex-c-m">
                                            </div>
                                            <input class="mtext-104 cl3 txt-center num-product" type="tel"
                                                name="num-product1" value="X{{ $item['quantity'] }}" disabled>

                                        </div>
                                    </td>
                                    <td class="column-5">
                                        {{ Number::currency($item['total_amount'], 'GBP') }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="table_row">
                                    <td class="column-1" colspan="4">
                                        Cart Empty
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                    <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                        <div class="flex-w flex-m m-r-20 m-tb-5">
                            <input class="stext-104 cl2 bg0 plh4 size-118 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                wire:model.defer="coupon" placeholder="Coupon Code">


                            <div wire:click="applyCoupon"
                                class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                Apply coupon
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Cart Totals
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">
                                Subtotal:
                            </span>
                        </div>

                        <div class="size-209">
                            <span class="mtext-110 cl2">
                                {{ Number::currency($cart_total, 'GBP') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="size-208 w-full-ssm">
                            <span class="stext-110 cl2">
                                Shipping:
                            </span>
                        </div>

                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                            <p class="stext-111 cl6 p-t-2">
                                Product would be delivered within 6-8 working days.
                            </p>

                            <div class="p-t-15">
                                <span class="stext-112 cl8">
                                    Calculate Shipping
                                </span>

                                <div class="bg0 m-b-12 m-t-9">
                                    <select class="text-111 cl8 plh3 size-111 p-lr-15 bg0 bor13"
                                        wire:model.live="selectedCountry" name="time">
                                        <option>Select a country...</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                    @error ('selectedCountry')
                                        <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                    @enderror
                                </div>

                                @if ($states)
                                    <div class="bg0 m-b-12 m-t-9">
                                        <select class="text-111 cl8 plh3 size-111 p-lr-15 bg0 bor13"
                                            wire:model.live="selectedState" name="time">
                                            <option>Select a state/region...</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state }}">{{ $state }}</option>
                                            @endforeach
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                        @error ('selectedState')
                                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                        @enderror
                                    </div>
                                @endif

                                @if ($selectedState)
                                    <div class="bg0 m-b-22">
                                        <input wire:model.defer="city" class="stext-111 cl8 plh3 size-111 p-lr-15 bg0 bor13"
                                            type="text" placeholder="City">
                                        @error ('city')
                                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                        @enderror
                                    </div>
                                    <div class="bg0 m-b-22">
                                        <input wire:model.defer="address"
                                            class="stext-111 cl8 plh3 size-111 p-lr-15 bg0 bor13" type="text"
                                            placeholder="Address">
                                        @error ('address')
                                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                        @enderror
                                    </div>
                                    <div class="bg0 m-b-22">
                                        <input wire:model.defer="phone_number"
                                            class="stext-111 cl8 plh3 size-111 p-lr-15 bg0 bor13" type="text"
                                            placeholder="Phone Number">
                                        @error ('phone_number')
                                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                        @enderror
                                    </div>
                                    <div class="bg0 m-b-22">
                                        <input wire:model.defer="zipCode"
                                            class="stext-111 cl8 plh3 size-111 p-lr-15 bg0 bor13" type="text" name="zipCode"
                                            placeholder="Postcode / Zip">
                                        @error ('zipCode')
                                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                        @enderror
                                    </div>
                                    <div class="bg0 m-b-12 m-t-9">
                                        <select class="text-111 cl8 plh3 size-111 p-lr-15 bg0 bor13"
                                            wire:model.live="paymentMethod">
                                            <option>Select a Payment Method</option>
                                            <option value="transfer">Transfer</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                        @error ('paymentMethod')
                                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                        @enderror
                                    </div>
                                @endif
                                @if ($discount > 0)
                                    <p><strong>Discount:</strong> -{{ Number::currency($discount, 'GBP') }}</p>
                                @endif


                                <span class="stext-112 cl1">
                                    Shipping fee: {{ Number::currency($shippingFee, 'GBP') }}
                                </span><br>
                                <span class="stext-112 cl1">
                                    Total Weight: {{ $totalWeight }}kg
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">
                                Total:
                            </span>
                        </div>

                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2">
                                {{ Number::currency($grand_total, 'GBP') }}
                            </span>
                        </div>
                    </div>

                    <button type="submit" wire:loading.class="bg8" wire:click.prevent="checkout"
                        wire:loading.remove.class="pointer bg3 hov-btn3 trans-04"
                        class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        <span wire:loading.remove>
                            Proceed to Checkout
                        </span>
                        <span class="cl2" wire:loading>
                            <i class="zmdi zmdi-refresh zmdi-hc-spin"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>