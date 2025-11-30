<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use Livewire\Attributes\On;
use Livewire\Component;

class WishlistTable extends Component
{
    public $wish_items = [];

    #[On('update-wish-count')]
    public function mount()
    {
        $this->wish_items = CartSession::getWishItemsFromSession();
    }

    public function removeProductFromWish($product_id)
    {
        $res = CartSession::removeProductFromWish($product_id);
        $this->dispatch('update-wish-count', wish_count: $res->getData()->wish_count);
    }
    public function render()
    {
        return view('livewire.customer.wishlist-table');
    }
}
