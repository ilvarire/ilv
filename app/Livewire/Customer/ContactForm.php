<?php

namespace App\Livewire\Customer;

use App\Models\Contact;
use Livewire\Component;

class ContactForm extends Component
{
    public $email;
    public $message;

    public function sendMail()
    {
        $this->validate([
            'email' => 'required|email|max:30',
            'message' => 'required|regex:/^[a-zA-Z0-9\s\.,]+$/|max:1000'
        ]);

        //send mail to support@mail.com

        $this->reset(['email', 'message']);

        return back()->with('status', 'mail-sent');
    }
    public function render()
    {
        $contact = Contact::take(1)->first();
        return view('livewire.customer.contact-form', [
            'contact' => $contact
        ]);
    }
}
