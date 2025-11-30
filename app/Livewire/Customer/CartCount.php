<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCount extends Component
{
    public $cart_count;

    #[On('update-cart-count')]

    public function mount()
    {
        $this->cart_count = count(CartSession::getCartItemsFromSession());
    }
    public function updateCartCount($cart_count)
    {
        $this->cart_count = $cart_count;
    }
    public function render()
    {
        return view('livewire.customer.cart-count');
    }
}
