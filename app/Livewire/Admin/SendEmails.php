<?php

namespace App\Livewire\Admin;

use App\Models\Newsletter;
use App\Models\SentEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.layout')]

class SendEmails extends Component
{
    use WithFileUploads;
    public $subject, $message, $receivers, $image; // Livewire properties

    public function sendMail()
    {
        $this->validate([
            'subject'   => 'required|string|min:3',
            'message'   => 'nullable|string|min:5',
            'receivers' => 'required|in:all,active,subscribers',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'receivers.in' => 'invalid receivers option'
        ]);


        $emails = [];

        if ($this->receivers === 'active') {
            $emails = User::whereNotNull('email')
                ->where('is_active', true)
                ->pluck('email')->toArray();
        } elseif ($this->receivers === 'subscribers') {
            $emails = Newsletter::pluck('email')->toArray();
        } elseif ($this->receivers === 'all') {
            $userEmails       = User::whereNotNull('email')
                ->where('is_active', true)
                ->pluck('email')->toArray();
            $subscriberEmails = Newsletter::pluck('email')->toArray();

            // Merge & remove duplicates
            $emails = array_unique(array_merge($userEmails, $subscriberEmails));
        }

        if (empty($emails)) {
            session()->flash('success', 'No emails found.');
            return;
        }

        $imagePath = null;

        if ($this->image) {
            $imagePath = $this->image->store('newsletter-images', 'public');
        }

        // foreach ($emails as $email) {
        //     Mail::to($email)->queue(
        //         new AdminNewsletterMail($this->subject, $this->message, $imagePath)
        //     );
        // }
        SentEmail::create([
            'admin' => Auth::user()->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'receivers' => $this->receivers,
            'number' => count($emails),
            'image_url' => $imagePath ?? null
        ]);

        $this->reset();

        session()->flash('success', 'Emails sent successfully!');
    }
    public function render()
    {
        return view('livewire.admin.send-emails');
    }
}
