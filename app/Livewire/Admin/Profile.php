<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout')]

class Profile extends Component
{
    public $email;
    public $name;
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->email = $user->email;
        $this->name = $user->name;
    }

    public function updateProfile()
    {
        $user = User::find(Auth::user()->id);
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore(Auth::user()->id),
            ],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->email = str($this->email)->lower();
        $user->name = str($this->name)->lower()->title();
        $user->save();

        return Redirect::route('admin.profile')->with('status', 'profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed']
        ]);
        $user = User::find(Auth::user()->id);
        $user->update([
            'password' => Hash::make($this->password),
        ]);
        $this->reset(['current_password', 'password', 'password_confirmation']);

        // Send password changed email messaged

        return back()->with('status', 'password-updated');
    }
    public function render()
    {
        return view('livewire.admin.profile');
    }
}
