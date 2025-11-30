<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Flux\Flux;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]

class Products extends Component
{
    use WithPagination, WithFileUploads;

    public $search = null;
    public $name = null;
    public $productId = null;
    public $product_id = null;
    public $brief, $price, $quantity, $tag_ids = [], $weight, $dimensions, $materials;
    public $description = null;
    public $category_id = null;
    public $is_active = null;
    public $is_featured = null;
    public $newImages = [];
    public $existingImages = [];

    public $deleteId;
    public $tags = [];
    public $prices = [];
    public $sizes = [];
    public $image = null;
    public $selectedCategory = null;
    #[Validate('nullable|numeric|min:0')]
    public $minPrice = null;
    #[Validate('nullable|numeric|min:0')]
    public $maxPrice = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['as' => 'category', 'except' => ''],
        'product_id' => ['except' => ''],
        'minPrice' => ['as' => 'min_price', 'except' => ''],
        'maxPrice' => ['as' => 'max_price', 'except' => ''],
    ];


    #[On('edit-product')]
    public function confirmingEdit($product)
    {
        $product = Product::with('images')
            ->where('slug', $product)
            ->firstOrFail();
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->brief = $product->brief;
        $this->price = $product->price;
        $this->quantity = $product->quantity;
        $this->tags = $product->tags;
        $this->description = $product->description;
        $this->weight = $product->weight;
        $this->dimensions = $product->dimensions;
        $this->materials = $product->materials;
        $this->category_id = $product->category_id;
        $this->existingImages = $product->images;
    }

    public function updateProduct()
    {
        $product = Product::findOrFail($this->productId);

        $this->validate([
            'name' => [
                'required',
                'max:100',
                Rule::unique('products', 'name')->ignore($this->productId),
            ],
            'brief' => [
                'required',
                'string',
                'min:5',
                'max:500'
            ],
            'description' => [
                'required',
                'string',
                'min:5',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'quantity' => [
                'required',
                'numeric'
            ],
            'is_active' => [
                'boolean',
            ],
            'is_featured' => [
                'boolean',
            ],
            'tag_ids' => [
                'array',
            ],
            'tag_ids.*' => [
                'exists:tags,id',
            ],
            'newImages' => [
                'array',
            ],
            'newImages.*' => [
                'nullable',
                'image',
                'max:5120',
            ],
        ], [
            'name.required' => 'The product name is required.',
            'name.max' => 'The name must not be greater than 100 characters.',
            'name.unique' => 'This product name already exists.',

            'description.required' => 'A description is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least 5 characters long.',
            'category_id.required' => 'A category is required.',
            'category_id.exists' => 'The selected category is invalid.',

            'newImage.required' => 'An image is required.',
            'newImage.image' => 'The uploaded file must be an image.',
            'newImage.max' => 'The image must not be larger than 5MB.',
        ]);

        if (!empty($this->newImages)) {
            $manager = ImageManager::withDriver(new Driver); // Make sure 'gd' is enabled

            foreach ($this->newImages as $key => $image) {
                $img = $manager->read($image->getRealPath());

                $width = $img->width();
                $height = $img->height();

                $expectedRatio = 25 / 31;
                $actualRatio = $width / $height;
                $tolerance = 0.02;

                if (abs($actualRatio - $expectedRatio) > $tolerance) {
                    $pro = $key + 1;
                    $this->addError("newImages", "Image must have a 25:31 aspect ratio. product-$pro");
                    return;
                }
            };

            foreach ($product->images as $oldImage) {
                if (Storage::exists($oldImage->image_url)) {
                    Storage::delete($oldImage->image_url);
                }
                $oldImage->delete();
            }
            foreach ($this->newImages as $image) {
                $path = $image->store('producs', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path
                ]);
            }
        }

        $product->update([
            'name' => str($this->name)->trim()->lower()->ucfirst(),
            'brief' => str($this->brief)->trim()->lower()->ucfirst(),
            'price' => str($this->price)->trim(),
            'quantity' => str($this->quantity)->trim(),
            'slug' => Str::slug($this->name),
            'description' => str($this->description)->trim()->lower()->ucfirst(),
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'weight' => str($this->weight)->trim()->lower()->ucfirst(),
            'dimensions' => str($this->dimensions)->trim()->lower()->ucfirst(),
            'materials' => str($this->materials)->trim()->lower()->ucfirst(),
        ]);

        if (!empty($this->tag_ids)) {
            $product->tags()->sync($this->tag_ids);
        }
        $this->reset();
        Flux::modal('edit-product')->close();
        session()->flash('success', 'product updated successfully');
    }

    #[On('delete-product')]
    public function confirmingDelete($id)
    {
        $this->productId = $id;
    }

    public function deleteProduct()
    {
        $product = Product::findOrFail($this->productId);

        // Delete associated images
        if ($product->images->count() > 0) {
            foreach ($product->images as $image) {
                if (File::exists(public_path($image->image_url))) {
                    File::delete(public_path($image->image_url));
                }
            }
        }

        // Delete the product
        $product->delete();
        Flux::modal('delete-product')->close();
        $this->reset();
        session()->flash('success', 'deleted successfully');
    }

    public function getAllCategories()
    {
        return Category::orderBy('name', 'asc')->get();
    }
    public function render()
    {
        $query = Product::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        if (!empty($this->selectedCategory)) {
            $query->where('category_id', $this->selectedCategory);
        }
        if (!empty($this->product_id)) {
            $query->where('id', $this->product_id);
        }
        if (!empty($this->minPrice)) {
            $query->where('price', '>=', $this->minPrice);
        }
        if (!is_null($this->maxPrice)) {
            $query->where('price', '<=', $this->maxPrice);
        }

        $products = $query->with('images', 'category', 'tags')->latest()->paginate(10);
        $categories = Category::all();
        $allTags = Tag::all();
        return view('livewire.admin.products', [
            'products' => $products,
            'categories' => $categories,
            'allTags' => $allTags
        ]);
    }
}
