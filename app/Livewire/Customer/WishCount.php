<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use Livewire\Attributes\On;
use Livewire\Component;

class WishCount extends Component
{
    public $wish_count;

    #[On('update-wish-count')]

    public function mount()
    {
        $this->wish_count = count(CartSession::getWishItemsFromSession());
    }
    public function updateCartCount($wish_count)
    {
        $this->wish_count = $wish_count;
    }
    public function render()
    {
        return view('livewire.customer.wish-count');
    }
}
