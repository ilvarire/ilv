<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class ProductSection extends Component
{
    use WithPagination;

    #[Validate('nullable|regex:/^[a-zA-Z0-9\s,.\'-]*$/|max:255')]
    public $search = '';
    public $category = null;
    public $tag = null;
    public $sort = 'default';
    public $priceRange = null;
    public $perPage = 20;
    public $quantity = 1;
    public $productId;
    public $selectedProduct;
    public $page;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => null],
        'tag' => ['except' => null],
        'sort' => ['except' => 'default'],
        'priceRange' => ['except' => null, 'as' => 'price_range'],
    ];

    protected $updatesQueryString = ['search', 'category', 'tag', 'priceRange', 'sort'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setCategory($categoryName)
    {
        $this->category = is_string($categoryName) && ctype_alpha($categoryName) ? (string) $categoryName : null;
        $this->resetPage();
    }

    public function setTag($tagName)
    {
        $this->tag = is_string($tagName) && ctype_alpha($tagName) ? (string) $tagName : null;
        $this->resetPage();
    }

    public function setPriceRange($range)
    {
        $allowedRanges = ['0-50', '50-100', '100-150', '150-200', '200+'];
        $this->priceRange = in_array($range, $allowedRanges) ? $range : null;
        $this->resetPage();
    }

    public function setSort($sortOption)
    {
        $allowedSorts = ['default', 'popularity', 'newness', 'price_low_high', 'price_high_low'];
        $this->sort = in_array($sortOption, $allowedSorts) ? $sortOption : 'default';
        $this->resetPage();
    }

    protected function applyPriceRange($query)
    {
        $priceRanges = [
            '0-50' => [0, 50],
            '50-100' => [50, 100],
            '100-150' => [100, 150],
            '150-200' => [150, 200],
            '200+' => [200, PHP_INT_MAX],
        ];

        if (isset($priceRanges[$this->priceRange])) {
            $query->whereBetween('price', $priceRanges[$this->priceRange]);
        }
        return $query;
    }

    public function applySorting($query)
    {
        return match ($this->sort) {
            'popularity' => $query->withCount('orderItems')->orderBy('order_items_count', 'desc'),
            'newness' => $query->orderBy('created_at', 'desc'),
            'price_low_high' => $query->orderBy('price', 'asc'),
            'price_high_low' => $query->orderBy('price', 'desc'),
            default => $query->orderBy('name', 'asc'),
        };
    }
    public function updatingSearch($search)
    {
        $this->validateOnly($search);
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 24;
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

    public function mount($productId = null)
    {
        $this->productId = $productId;
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

    public function isInWishlist($productId)
    {
        $res = CartSession::isProductInWishlist($productId);
        return $res;
    }
    private function getProducts()
    {
        // Find the category only once
        $category = $this->category ? Category::where('name', $this->category)->first() : null;
        $productsQuery = Product::query()
            ->with(['category', 'tags', 'images'])
            ->where('is_active', true);

        if (!empty($this->search)) {
            $productsQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if ($category) {
            $productsQuery->where('category_id', $category->id);
        }

        if ($this->tag) {
            $productsQuery->whereHas('tags', function ($q) {
                $q->where('tags.slug', $this->tag);
            });
        }

        $productsQuery = $this->applyPriceRange($productsQuery);
        $productsQuery = $this->applySorting($productsQuery);

        $products = $productsQuery->paginate($this->perPage);
        return $products;
    }
    public function render()
    {
        // Eager load categories and tags once
        $categories = Category::where('is_featured', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        $products = $this->getProducts();
        return view('livewire.customer.product-section', [
            'products' => $products,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }
}
