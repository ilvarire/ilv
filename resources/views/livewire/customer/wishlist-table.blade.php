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
                                <th class="column-5"></th>
                            </tr>
                            @forelse ($wish_items as $item)
                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1"
                                            wire:click="removeProductFromWish('{{ $item['product_id'] }}')">
                                            <img src="{{ asset('storage/' . $item['images']->first()->image_url) }}"
                                                alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">
                                        {{ $item['name'] }}
                                    </td>
                                    <td class="column-3">
                                        {{ Number::currency($item['unit_price'], 'GBP') }}
                                    </td>
                                    <td class="column-5">
                                        <a href="javascript:;"
                                            wire:click="removeProductFromWish('{{ $item['product_id'] }}')">
                                            <i class="zmdi zmdi-close cl3"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="table_row">
                                    <td class="column-1" colspan="4">
                                        No items in Wishlist
                                    </td>
                                </tr>
                            @endforelse

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>