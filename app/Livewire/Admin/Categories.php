<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.layout')]

class Categories extends Component
{
    use WithFileUploads;
    #[Validate('required|alpha|max:100|unique:categories,name')]
    public $name = null;
    #[Validate('required|image|max:2048')]
    public $image = null;

    #[Validate('required|alpha|max:100|unique:categories,name')]
    public $editName = null;
    public $editIsFeatured = null;
    public $oldImage = null;
    public $editImage = null;
    public $categoryId = null;

    public function storeCategory()
    {
        $validated = $this->validate([
            'name' => 'required|max:100|unique:categories,name',
            'image' => 'required|image|max:2048'
        ]);
        $manager = ImageManager::withDriver(new Driver);
        $img = $manager->read($this->image->getRealPath());
        $width = $img->width();
        $height = $img->height();

        $expectedRatio = 1 / 1;
        $actualRatio = $width / $height;
        $tolerance = 0.02;

        if (abs($actualRatio - $expectedRatio) > $tolerance) {
            $this->addError("image", "Image must have a 1:1 aspect ratio.");
            return;
        }
        $path = $this->image->store('categories', 'public');

        Category::create([
            'name' => str(trim($validated['name']))->title(),
            'slug' => Str::slug($validated['name']),
            'image_url' => $path
        ]);

        session()->flash('success', 'new category created');
        $this->reset();
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    #[On('open-cat-modal')]
    public function editCategory($mode, $category)
    {
        $category = Category::where('slug', $category)->first();
        if ($category) {
            $this->editName = $category->name;
            $this->editIsFeatured = $category->is_featured;
            $this->oldImage = $category->image_url;
            $this->categoryId = $category->id;
        } else {
            return redirect()->route('admin.categories');
        }
    }

    public function updateCategory()
    {
        $category = Category::findOrFail($this->categoryId);
        $validated = $this->validate([
            'editName' => [
                'required',
                'max:100',
                Rule::unique('categories', 'name')->ignore($category->id)
            ],
            'editImage' => 'nullable|image|max:2048',
            'editIsFeatured' => 'nullable|boolean'
        ]);

        $category->update([
            'name' => str(trim($validated['editName']))->title(),
            'slug' => Str::slug($validated['editName']),
            'is_featured' => $this->editIsFeatured
        ]);

        if ($this->editImage) {
            $path = $this->editImage->store('categories', 'public');
            $category->update(['image_url' => $path]);
        }

        Flux::modal('edit-category')->close();
        session()->flash('success', 'category updated');
        $this->reset();
    }

    #[On('delete-category')]
    public function deleteConfirmation($id)
    {
        $this->categoryId = $id;
    }

    public function deleteCategory()
    {
        if ($this->categoryId) {
            $category = $this->getAllCategories()->find($this->categoryId);
            if ($category) {
                $category->delete();
                Flux::modal('delete-category')->close();
                session()->flash('success', 'Category deleted successfully!');
                $this->reset();
            } else {
                Flux::modal('delete-category')->close();
                return redirect()->route('admin.categories');
            }
        }
    }
    public function render()
    {
        $categories = $this->getAllCategories();
        return view('livewire.admin.categories', [
            'categories' => $categories
        ]);
    }
}
