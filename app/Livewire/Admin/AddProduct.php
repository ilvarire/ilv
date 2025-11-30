<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.layout')]

class AddProduct extends Component
{
    use WithFileUploads;
    public $name, $brief, $description, $price, $quantity, $tag_ids = [], $weight, $dimensions, $materials, $category_id, $images = [];
    public $categories;
    public $tags;

    public function mount()
    {
        $this->categories = Category::all();
        $this->tags = Tag::all();
    }
    protected function unmask($value)
    {
        return (float) str_replace([',', ' '], '', $value);
    }

    public function storeProduct()
    {
        $this->price = $this->unmask($this->price);
        $this->weight = $this->unmask($this->weight);

        $this->validate([
            'name' => 'required|max:255',
            'brief' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'weight' => 'required|numeric|max:100',
            'tag_ids' => 'array',
            'tag_ids.*' => 'exists:tags,id',
            'dimensions' => 'nullable|string|max:255',
            'materials' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array|min:3|max:3',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $manager = ImageManager::withDriver(new Driver()); // Make sure 'gd' is enabled

        foreach ($this->images as $key => $image) {
            $img = $manager->read($image->getRealPath());

            $width = $img->width();
            $height = $img->height();

            $expectedRatio = 25 / 31;
            $actualRatio = $width / $height;
            $tolerance = 0.02;

            if (abs($actualRatio - $expectedRatio) > $tolerance) {
                $pro = $key + 1;
                $this->addError("images", "Image must have a 25:31 aspect ratio. product-$pro");
                return;
            }
        };

        $product = Product::create([
            'name' => str($this->name)->trim()->lower()->ucfirst(),
            'slug' => Str::slug($this->name),
            'brief' => str($this->brief)->trim()->lower()->ucfirst(),
            'description' => str($this->description)->trim()->lower()->ucfirst(),
            'price' => str($this->price)->trim()->lower()->ucfirst(),
            'quantity' => str($this->quantity)->trim()->lower()->ucfirst(),
            'weight' => str($this->weight)->trim()->lower()->ucfirst(),
            'dimensions' => str($this->dimensions)->trim()->lower()->ucfirst(),
            'materials' => str($this->materials)->trim()->lower()->ucfirst(),
            'category_id' => str($this->category_id)->trim()->lower()->ucfirst()
        ]);
        if ($this->tag_ids) {
            $product->tags()->sync($this->tag_ids);
        }
        if ($this->images) {
            foreach ($this->images as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path
                ]);
            }
        }

        session()->flash('success', 'product created successfully');
        $this->reset(['name', 'brief', 'description', 'price', 'tag_ids', 'category_id', 'quantity', 'weight', 'dimensions', 'materials', 'images']);
    }

    public function render()
    {
        return view('livewire.admin.add-product');
    }
}
