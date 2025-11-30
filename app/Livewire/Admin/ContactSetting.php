<?php

namespace App\Livewire\Admin;

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class ContactSetting extends Component
{
    public $address, $email, $phone_number, $facebook_link, $tiktok_link, $instagram_link, $whatsapp_link;
    public function mount()
    {
        $contact = Contact::where('id', 1)->firstOrFail();
        $this->address = $contact->address;
        $this->email = $contact->email;
        $this->phone_number = $contact->phone_number;
        $this->facebook_link = $contact->facebook_link;
        $this->tiktok_link = $contact->tiktok_link;
        $this->instagram_link = $contact->instagram_link;
        $this->whatsapp_link = $contact->whatsapp_link;
    }

    public function updateContact()
    {
        $this->validate([
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'facebook_link' => 'required|string|max:200',
            'instagram_link' => 'required|string|max:200',
            'tiktok_link' => 'required|string|max:200',
            'whatsapp_link' => 'required|string|max:200'
        ]);

        $contact = Contact::where('id', 1)->firstOrFail();
        $contact->update([
            'address' => str($this->address)->trim(),
            'email' => str($this->email)->trim()->lower(),
            'phone_number' => str($this->phone_number)->trim(),
            'facebook_link' => str($this->facebook_link)->trim(),
            'instagram_link' => str($this->instagram_link)->trim(),
            'tiktok_link' => str($this->tiktok_link)->trim(),
            'whatsapp_link' => str($this->whatsapp_link)->trim()
        ]);
        session()->flash('success', 'Contact details updated successfully');
    }
    public function render()
    {
        return view('livewire.admin.contact-setting');
    }
}
