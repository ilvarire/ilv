<?php

namespace App\Livewire\Customer;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Newsletter;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Footer extends Component
{
    public $email;
    public function subscribe()
    {
        $key = 'subscribe-attempts:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 2)) {   // 2 attempts
            throw ValidationException::withMessages([
                'email' => ['Too many attempts. Please try again in 1 minute.']
            ]);
        }

        RateLimiter::hit($key, 60); // lockout time = 60 seconds

        $this->validate([
            'email' => 'required|email|unique:newsletters,email|max:50'
        ], [
            'email.unique' => 'You are already subscribed'
        ]);
        Newsletter::create([
            'email' => $this->email
        ]);
        $this->reset(['email']);

        return back()->with('status', 'subscribed');
    }

    public function render()
    {
        $contact = Contact::take(1)->first();
        $categories = Category::select('name', 'slug')->get();
        return view('livewire.customer.footer', [
            'contact' => $contact,
            'categories' => $categories
        ]);
    }
}
