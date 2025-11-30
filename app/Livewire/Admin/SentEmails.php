<?php

namespace App\Livewire\Admin;

use App\Models\SentEmail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class SentEmails extends Component
{
    public $confirmingEdit = false;
    public $confirmingDelete = false;
    public $emailId, $viewAdmin, $viewSubject, $viewMessage, $viewReceivers, $viewNumber, $viewImage, $deleteId;
    function edit($id)
    {
        $email = SentEmail::findOrFail($id);
        $this->emailId = $email->id;
        $this->viewAdmin = $email->admin;
        $this->viewSubject = $email->subject;
        $this->viewMessage = $email->message;
        $this->viewReceivers = $email->receivers;
        $this->viewNumber = $email->number;
        $this->viewImage = $email->image_url;
        $this->confirmingEdit = true;
    }
    public function deleteEmail()
    {
        $email = SentEmail::findOrFail($this->deleteId);
        $email->delete();
        session()->flash('success', 'Email deleted!');
        $this->reset(['deleteId']);
    }
    public function render()
    {
        $emails = SentEmail::orderBy('created_at', 'desc')
            ->paginate(40);
        return view('livewire.admin.sent-emails', [
            'emails' => $emails
        ]);
    }
}
