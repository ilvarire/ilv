<?php

namespace App\Livewire\Customer;

use App\Mail\user\PasswordChanged;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ProfileForm extends Component
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
            // 'email' => [
            //     'required',
            //     'string',
            //     'lowercase',
            //     'email',
            //     'max:255',
            //     Rule::unique(User::class)->ignore(Auth::user()->id),
            // ],
        ]);

        // if ($user->isDirty('email')) {
        //     $user->email_verified_at = null;
        // }
        // $user->email = str($this->email)->lower();
        $user->name = str($this->name)->lower()->title();
        $user->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
    }

    public function updatePassword()
    {
        $key = 'change-password-attempts:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 2)) {
            throw ValidationException::withMessages([
                'email' => ['Too many attempts. Please try again in 1 minute.']
            ]);
        }

        RateLimiter::hit($key, 180);

        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed']
        ]);
        $user = User::find(Auth::user()->id);
        $user->update([
            'password' => Hash::make($this->password),
        ]);
        $this->reset(['current_password', 'password', 'password_confirmation']);

        $timestamp = now();
        $ip = request()->ip();
        $agent = request()->userAgent();
        Mail::to($user->email)
            ->send(new PasswordChanged($timestamp, $ip, $agent, $user->name));

        return back()->with('status', 'password-updated');
    }
    public function render()
    {
        return view('livewire.customer.profile-form');
    }
}
