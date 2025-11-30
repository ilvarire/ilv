<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class RelatedProducts extends Component
{
    public $slug;
    public $relatedProducts;
    public $selectedProduct;
    public $quantity = 1;

    public function mount()
    {
        $this->getRelatedProducts();
    }
    protected function getRelatedProducts()
    {
        $product = Product::where('slug', $this->slug)->first();
        if ($product) {
            $this->relatedProducts = Product::with('images')
                ->where('slug', '<>', $product->slug)
                ->where('category_id', $product->category_id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }
    }
    #[On('view-product')]

    public function viewProduct($product)
    {
        $selectedProduct = Product::with('images')
            ->where('slug', $product)
            ->where('is_active', true)
            ->firstOrFail();
        if ($selectedProduct) {
            $this->selectedProduct = $selectedProduct;
        }
        $this->dispatch('reinitmodal');
    }
    public function decreaseQuantity()
    {
        $this->dispatch('reinitmodal');
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // Increase quantity method
    public function increaseQuantity()
    {
        $this->dispatch('reinitmodal');
        if ($this->selectedProduct) {
            if ($this->selectedProduct->quantity <= $this->quantity) {
                $this->dispatch('alert-modal', [
                    'message' => 'Requested quantity exceeds available stock.',
                    'type' => 'error',
                    'product' => $this->selectedProduct->name,
                ]);
            } else {
                $this->quantity++;
            }
        }
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::with('images')
            ->where('slug', $productId)
            ->first();

        if (!$product) {
            $this->dispatch('alert-modal', [
                'message' => 'Product not found.',
                'type' => 'error',
                'product' => 'Not Found',
            ]);
        } else {
            if ($product->quantity < $quantity) {
                $this->dispatch('alert-modal', [
                    'message' => 'Quantity exceeds available stock.',
                    'type' => 'error',
                    'product' => 'Not Found',
                ]);
            } else {
                $res = CartSession::addProductToCart($product->id, $quantity);
                // $statusCode = $res->getStatusCode();
                $this->dispatch('update-cart-count', cart_count: $res->getData()->cart_count);
                $this->dispatch('alert-modal', [
                    'message' => $res->getData()->message,
                    'type' => $res->getData()->type,
                    'product' => $product->name,
                ]);
            }
        }
    }

    public function addToWish($productId, $mode = 'none')
    {
        if ($mode === 'modal') {
            $this->dispatch('reinitmodal');
        }
        $product = Product::with('images')
            ->where('slug', $productId)
            ->first();

        if (!$product) {
            $this->dispatch('alert-modal', [
                'message' => 'Product not found.',
                'type' => 'error',
                'product' => 'Not Found',
            ]);
        } else {
            $res = CartSession::addProductToWishlist($product->id);
            // $statusCode = $res->getStatusCode();
            $this->dispatch('update-wish-count', wish_count: $res->getData()->wish_count);
            if ($res->getData()->type === 'success') {
                $this->dispatch('alert-modal', [
                    'message' => $res->getData()->message,
                    'type' => $res->getData()->type,
                    'product' => $product->name,
                ]);
            }
        }
    }

    public function isInWishlist($productId)
    {
        $res = CartSession::isProductInWishlist($productId);
        return $res;
    }
    public function render()
    {
        return view('livewire.customer.related-products');
    }
}
