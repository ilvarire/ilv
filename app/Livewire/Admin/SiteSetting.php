<?php

namespace App\Livewire\Admin;

use App\Models\General;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.layout')]
class SiteSetting extends Component
{
    use WithFileUploads;
    public $maintenance, $policy, $site_description, $site_title, $top_text, $og_image, $favicon, $logo;
    public $existing_og_image, $existing_logo, $existing_favicon;
    public function mount()
    {
        $site = General::where('id', 1)->firstOrFail();
        $this->maintenance = $site->maintenance;
        $this->policy = $site->policy;
        $this->site_description = $site->site_description;
        $this->site_title = $site->site_title;
        $this->top_text = $site->top_text;
        $this->existing_og_image = $site->og_image;
        $this->existing_favicon = $site->favicon;
        $this->existing_logo = $site->logo;
    }

    public function toggleMaintenance()
    {
        $general = General::take(1)->first();
        $general->update([
            'maintenance' => !$general->maintenance
        ]);
    }

    public function updateSiteInfo()
    {
        $this->validate([
            'policy' => 'required|string',
            'site_description' => 'required|string',
            'site_title' => 'required|string',
            'top_text' => 'required|string',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'logo' => 'nullable|mimetypes:image/svg+xml,image/png|max:2048',
            'favicon' => 'nullable|mimetypes:image/svg+xml|max:2048'
        ]);

        $site = General::take(1)->first();

        if (!empty($this->og_image)) {
            $path = $this->og_image->store('site', 'public');
            $site->update([
                'og_image' => $path
            ]);
        }
        if (!empty($this->favicon)) {
            $path = $this->favicon->store('site', 'public');
            $site->update([
                'favicon' => $path
            ]);
        }
        if (!empty($this->logo)) {
            $path = $this->logo->store('site', 'public');
            $site->update([
                'logo' => $path
            ]);
        }
        $site->update([
            'policy' => str($this->policy)->trim(),
            'site_description' => str($this->site_description)->trim(),
            'site_title' => str($this->site_title)->trim(),
            'top_text' => str($this->top_text)->trim()
        ]);
        $this->reset();
        redirect()->route('admin.settings.site')->with('success', 'Site setting updated successfully');
    }
    public function render()
    {
        $general = General::take(1)->first();
        return view('livewire.admin.site-setting', [
            'general' => $general
        ]);
    }
}
