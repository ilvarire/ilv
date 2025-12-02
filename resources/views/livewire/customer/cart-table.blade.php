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
                                <th class="column-5"></th>
                            </tr>
                            @forelse ($cart_items as $item)
                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1"
                                            wire:click="removeProductFromCart('{{ $item['product_id'] }}')">
                                            <img src="{{ asset('storage/' . $item['images']->first()->image_url) }}"
                                                alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">{{ $item['name'] }}
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
                                    <td class="column-3">{{ Number::currency($item['unit_price'], 'NGN') }}</td>
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                wire:click="updateQuantity('{{ $item['product_id'] }}', 'decrease')">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="tel"
                                                name="num-product1" wire:model="quantities.{{ $item['product_id'] }}"
                                                wire:change="updatedQuantities('{{ $item['product_id'] }}')" disabled>

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                wire:click="updateQuantity('{{ $item['product_id'] }}', 'increase')">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-5">
                                        <a href="javascript:;"
                                            wire:click="removeProductFromCart('{{ $item['product_id'] }}')">
                                            <i class="zmdi zmdi-close cl3"></i>
                                        </a>
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
                                {{ Number::currency($cart_total, 'NGN') }}
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
                                Shipping fees not included.
                            </p>
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
                                {{ Number::currency($cart_total, 'NGN') }}
                            </span>
                        </div>
                    </div>
                    @if ($cart_total > 0)
                        <a href="{{ route('checkout') }}"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout

                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</form>