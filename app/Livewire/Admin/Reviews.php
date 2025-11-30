<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\ProductReview;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout')]

class Reviews extends Component
{
    public $selectedStatus = '';
    public $selectedProduct = '';
    public $comment = null;
    public $rating = null;
    public $status = null;
    public $reviewId = null;
    protected $queryString = [
        'selectedStatus' => ['except' => ''],
        'selectedProduct' => ['except' => '']
    ];
    #[On('edit-review')]
    public function confirmingEdit($id)
    {
        $review = ProductReview::with('user')
            ->where('id', $id)
            ->firstOrFail();

        $this->rating = $review->rating;
        $this->comment = $review->comment;
        $this->status = $review->status;
        $this->reviewId = $review->id;
    }

    public function updateReview()
    {
        $review = ProductReview::findOrFail($this->reviewId);
        $validated = $this->validate([
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        $review->update([
            'status' => $validated['status']
        ]);

        Flux::modal('edit-review')->close();
        return redirect()->route('admin.reviews')->with('success', 'Review status updated');
    }

    #[On('delete-review')]
    public function confirmingDelete($id)
    {
        $this->reviewId = $id;
    }
    public function deleteReview()
    {
        $review = ProductReview::findOrFail($this->reviewId);
        $review->delete();
        Flux::modal('delete-review')->close();
        return redirect()->route('admin.reviews')->with('success', 'deleted successfully');
    }
    public function render()
    {
        $reviews = ProductReview::with(['user', 'product'])
            ->when($this->selectedStatus, fn($q) => $q->where('status', $this->selectedStatus))
            ->when($this->selectedProduct, fn($q) => $q->where('product_id', $this->selectedProduct))
            ->latest()->paginate(20);

        $products = Product::select('id', 'name')->orderBy('name')->get();
        return view('livewire.admin.reviews', [
            'reviews' => $reviews,
            'products' => $products
        ]);
    }
}
