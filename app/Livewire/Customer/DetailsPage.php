<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DetailsPage extends Component
{
    public $product;
    public $reviews;
    public bool $canReview = false;
    #[Validate('min:1|numeric|required')]
    public $quantity = 1;

    public function mount($product)
    {
        $this->getReviews($product);
        if (Auth::check()) {
            $this->canReview = $this->userCanReview(Auth::id(), $product->id);
        }
    }

    protected function getReviews($product)
    {
        $this->reviews = $product->reviews;
    }

    protected function userCanReview($userId, $productId): bool
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->where('order_items.product_id', $productId)
            ->where('orders.status', 'delivered')
            ->exists();
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1 && is_numeric($this->quantity)) {
            $this->quantity--;
        }
    }

    // Increase quantity method
    public function increaseQuantity()
    {
        if (is_numeric($this->quantity)) {
            $this->quantity++;
        }
    }

    public function addToCart($productId, $quantity = 1)
    {
        $this->dispatch('reinitmodal');
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

    public function submitReview()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
        $this->canReview = $this->userCanReview(Auth::user()->id, $this->product->id);
        if (!$this->canReview) {
            $this->addError('message', 'You cannot review this Product');
            return;
        }
        $this->validate([
            'message' => 'required|string|min:1',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $existingReview = ProductReview::where('user_id', Auth::user()->id)
            ->where('product_id', $this->product->id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $this->rating,
                'message' => $this->message,
                'status' => 'pending', // must be re-approved after edit
            ]);
        } else {
            ProductReview::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
                'comment' => $this->message,
                'rating' => $this->rating,
            ]);
        }
        $this->dispatch('alert-modal', [
            'message' => 'Review submitted successfully!',
            'type' => 'info',
            'product' => $this->product->name,
        ]);
        $this->reset('message', 'rating');
    }
    public function isInWishlist($productId)
    {
        $res = CartSession::isProductInWishlist($productId);
        return $res;
    }
    public function render()
    {
        return view('livewire.customer.details-page');
    }
}
