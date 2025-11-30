<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use Livewire\Attributes\On;
use Livewire\Component;

class SlideCart extends Component
{
    public $cart_items;
    public $cart_total = 0;
    public function mount()
    {
        $this->cart_items = CartSession::getCartItemsFromSession();
        $this->cart_total = CartSession::calculateGrandTotal($this->cart_items);
    }

    #[On('update-cart-count')]
    public function updateCartCount()
    {
        $this->cart_items = CartSession::getCartItemsFromSession();
        $this->cart_total = CartSession::calculateGrandTotal($this->cart_items);
    }

    public function removeProductFromCart($product_id)
    {
        $res = CartSession::removeProductFromCart($product_id);
        $this->dispatch('update-cart-count', cart_count: $res->getData()->cart_count);
    }
    public function render()
    {
        return view('livewire.customer.slide-cart');
    }
}
