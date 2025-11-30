<?php

namespace App\Livewire\Admin;

use App\Models\Newsletter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout')]

class NewsletterEmails extends Component
{
    use WithPagination;
    #[Validate('required|email|unique:newsletters,email')]

    public $email;
    #[Validate('required|email|unique:newsletters,email')]
    public $editEmail;
    public $confirmingEdit = false;
    public $confirmingDelete = false;

    public $deleteId = '';
    public $emailId = '';
    function storeEmail()
    {
        $this->validateOnly('email');

        Newsletter::create([
            'email' => str($this->email)->trim()->lower()
        ]);

        session()->flash('success', 'New email created');
        $this->reset('email');
    }
    public function updating($property)
    {
        $this->validateOnly($property);
    }

    function edit($id)
    {
        $email = Newsletter::findOrFail($id);
        $this->emailId = $email->id;
        $this->editEmail = $email->email;
        $this->confirmingEdit = true;
    }

    function updateEmail()
    {
        $this->validateOnly('editEmail');

        $email = Newsletter::findOrFail($this->emailId);
        $email->update([
            'email' => str($this->editEmail)->trim()->lower()
        ]);
        $this->confirmingEdit = false;
        $this->dispatch('modal-close');
        $this->reset(['editEmail', 'emailId']);
        session()->flash('success', 'Email updated!');
    }

    public function deleteEmail()
    {
        $email = Newsletter::findOrFail($this->deleteId);
        $email->delete();
        session()->flash('success', 'Email deleted!');
        $this->reset(['deleteId']);
    }
    public function render()
    {
        $emails = Newsletter::orderBy('created_at', 'desc')
            ->paginate(40);
        return view('livewire.admin.newsletter-emails', [
            'emails' => $emails
        ]);
    }
}
