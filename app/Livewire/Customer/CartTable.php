<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class CartTable extends Component
{
    public $cart_items = [];
    public $cart_total = 0;
    public $quantities = [];

    #[On('update-cart-count')]
    public function mount()
    {
        $this->cart_items = CartSession::getCartItemsFromSession();
        $this->cart_total = CartSession::calculateGrandTotal($this->cart_items);
        foreach ($this->cart_items as $item) {
            $this->quantities[$item['product_id']] = $item['quantity'];
        }
    }

    public function removeProductFromCart($product_id)
    {
        $res = CartSession::removeProductFromCart($product_id);
        $this->dispatch('update-cart-count', cart_count: $res->getData()->cart_count);
    }

    public function updatedQuantities($product_id)
    {
        $newQuantity = $this->quantities[$product_id];
        $product = Product::find($product_id);

        if (!is_numeric($newQuantity) || $newQuantity <= 0) {
            $this->dispatch('alert-modal', [
                'message' => 'Invalid quantity.',
                'type' => 'error',
                'product' => 'Error',
            ]);
        } elseif (!$product) {
            $this->dispatch('alert-modal', [
                'message' => 'Product not found.',
                'type' => 'error',
                'product' => 'Not Found',
            ]);
        } elseif ($newQuantity > $product->quantity) {
            $this->dispatch('alert-modal', [
                'message' => 'Quantity exceed available stock.',
                'type' => 'error',
                'product' => $product->name,
            ]);
        } else {
            $res = CartSession::updateProductQuantity($product_id, $newQuantity);
            $this->dispatch('update-cart-count', cart_count: $res->getData()->cart_count);
        }
    }
    public function updateQuantity($product_id, $action)
    {
        $currentQuantity = $this->quantities[$product_id];

        if ($action == 'increase') {
            $this->quantities[$product_id] = $currentQuantity + 1;
        } elseif ($action == 'decrease' && $currentQuantity > 1) {
            $this->quantities[$product_id] = $currentQuantity - 1;
        }

        $this->updatedQuantities($product_id);
    }
    public function render()
    {
        return view('livewire.customer.cart-table');
    }
}
