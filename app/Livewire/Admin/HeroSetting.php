<?php

namespace App\Livewire\Admin;

use App\Models\Hero;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.layout')]
class HeroSetting extends Component
{
    use WithFileUploads;
    public $heading, $main_text, $text_color;
    public $link;
    public $confirmingEdit = false;
    public $heroId = '';
    public $existingHeroImage;
    public $heroImage;

    function edit($id)
    {
        $hero = Hero::findOrFail($id);
        $this->heroId = $hero->id;
        $this->heading = $hero->heading;
        $this->main_text = $hero->main_text;
        $this->existingHeroImage = $hero->image_url;
        $this->link = $hero->link;
        $this->text_color = $hero->text_color;
        $this->confirmingEdit = true;
    }

    function updateHero()
    {
        $this->validate([
            'heading' => 'required|regex:/^[a-zA-Z0-9\s\-&]+$/|min:2',
            'main_text' => 'required|regex:/^[a-zA-Z0-9\s\-&]+$/|min:2',
            'link' => 'required|string|min:2|max:60',
            'text_color' => 'required|string|min:2',
            'heroImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $hero = Hero::findOrFail($this->heroId);
        if (!empty($this->heroImage)) {
            $manager = ImageManager::withDriver(new Driver);
            $img = $manager->read($this->heroImage->getRealPath());
            $width = $img->width();
            $height = $img->height();

            $expectedRatio = 64 / 31;
            $actualRatio = $width / $height;
            $tolerance = 0.02;
            if (abs($actualRatio - $expectedRatio) > $tolerance) {
                $this->addError("heroImage", "Hero image must have a 64:31 aspect ratio.");
                return;
            }
        }

        $hero->update([
            'heading' => str($this->heading)->trim(),
            'main_text' => str($this->main_text)->trim(),
            'link' => str($this->link)->trim(),
            'text_color' => str($this->text_color)->trim()
        ]);

        if (!empty($this->heroImage)) {
            $path = $this->heroImage->store('hero', 'public');
            $hero->update([
                'image_url' => $path
            ]);
        }

        $this->reset(['main_text', 'heading', 'link', 'heroImage', 'text_color', 'heroId']);
        $this->dispatch('modal-close');
        session()->flash('success', 'Hero updated!');
    }
    public function render()
    {
        $heros = Hero::all();
        return view('livewire.admin.hero-setting', [
            'heros' => $heros
        ]);
    }
}
