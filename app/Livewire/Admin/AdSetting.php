<?php

namespace App\Livewire\Admin;

use App\Models\Ad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.layout')]
class AdSetting extends Component
{
    use WithFileUploads;
    #[Validate('required|regex:/^[a-zA-Z0-9\s\#\-&]+$/|min:2|max:255')]
    public $name, $text_color;
    #[Validate('nullable|string|min:2|max:255')]
    public $main_text, $sub_text;
    #[Validate('required|string|min:2|max:255')]
    public $link;
    public $confirmingEdit = false;
    public $confirmingDelete = false;
    public $adId = '';
    public $existingAdImage;
    #[Validate('nullable|image|mimes:jpg,jpeg,png|max:2048')]
    public $adImage;

    function edit($id)
    {
        $ad = Ad::findOrFail($id);
        $this->adId = $ad->id;
        $this->name = $ad->name;
        $this->main_text = $ad->main_text;
        $this->sub_text = $ad->sub_text;
        $this->existingAdImage = $ad->image_url;
        $this->link = $ad->link;
        $this->text_color = $ad->text_color;
        $this->confirmingEdit = true;
    }

    function updateAd()
    {
        $this->validate();

        $ad = Ad::findOrFail($this->adId);

        if (!empty($this->adImage)) {
            $manager = ImageManager::withDriver(new Driver);
            $img = $manager->read($this->adImage->getRealPath());
            $width = $img->width();
            $height = $img->height();

            $expectedRatio = 3 / 2;
            $actualRatio = $width / $height;
            $tolerance = 0.02;
            if (abs($actualRatio - $expectedRatio) > $tolerance) {
                $this->addError("adImage", "Ad image must have a 3:2 aspect ratio.");
                return;
            }
        }

        $ad->update([
            'name' => str($this->name)->trim(),
            'main_text' => str($this->main_text)->trim(),
            'sub_text' => str($this->sub_text)->trim(),
            'link' => str($this->link)->trim(),
            'text_color' => str($this->text_color)->trim()
        ]);

        if (!empty($this->adImage)) {
            $path = $this->adImage->store('ad', 'public');
            $ad->update([
                'image_url' => $path
            ]);
        }

        $this->confirmingEdit = false;
        $this->dispatch('modal-close');
        $this->reset(['name', 'main_text', 'adImage', 'sub_text', 'link', 'text_color', 'adId']);
        session()->flash('success', 'Ad updated!');
    }
    public function render()
    {
        $ads = Ad::all();
        return view('livewire.admin.ad-setting', [
            'ads' => $ads
        ]);
    }
}
