<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]

class Tags extends Component
{
    #[Validate('required|unique:tags,name|min:2')]

    public $name;
    #[Validate('required|min:2')]
    public $editName;
    public $confirmingEdit = false;
    public $confirmingDelete = false;

    public $deleteId = '';
    public $tagId = '';
    function storeTag()
    {
        $this->validateOnly('name');

        Tag::create([
            'name' => str(trim($this->name))->lower(),
            'slug' => Str::slug($this->name),
        ]);

        session()->flash('success', 'New tag created');
        $this->reset('name');
    }
    #[On('open-tag-modal')]
    public function editTag($mode, $tag)
    {
        $tag = Tag::where('slug', $tag)->first();
        if ($tag) {
            $this->tagId = $tag->id;
            $this->editName = $tag->name;
        } else {
            return redirect()->route('admin.categories');
        }
    }

    function updateTag()
    {
        $this->validateOnly('editName');

        $tag = Tag::findOrFail($this->tagId);
        $tag->update([
            'name' => str(trim($this->editName))->title()
        ]);
        $this->confirmingEdit = false;
        $this->dispatch('modal-close');
        $this->reset(['editName', 'tagId']);
        session()->flash('success', 'Tag updated!');
    }

    #[On('delete-tag')]
    public function deleteConfirmation($id)
    {
        $this->deleteId = $id;
    }

    public function deleteTag()
    {
        $tag = Tag::findOrFail($this->deleteId);
        $tag->delete();
        Flux::modal('delete-tag')->close();
        session()->flash('success', 'Tag deleted!');
        $this->reset(['deleteId']);
    }
    public function render()
    {
        $tags = Tag::all();
        return view('livewire.admin.tags', [
            'tags' => $tags
        ]);
    }
}
