<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]

class Countries extends Component
{
    #[Validate("required|unique:countries|max:100")]
    public $name = null;
    #[Validate('required|unique:countries|max:100')]
    public $code = null;

    public $editName = null;
    public $editCode = null;
    public $countryId = null;

    public function storeCountry()
    {
        $name = $this->validateOnly('name')['name'];
        $code = $this->validateOnly('code')['code'];

        Country::create([
            'name' => str(trim($name))->title(),
            'slug' => Str::slug($name),
            'code' => str($code)->trim()->upper()
        ]);

        session()->flash('success', 'new country created');
        $this->reset();
    }

    #[On('edit-country')]
    public function editCountry($mode, $country)
    {
        $country = Country::where('slug', $country)->first();
        if ($country) {
            $this->editName = $country->name;
            $this->editCode = $country->code;
            $this->countryId = $country->id;
        } else {
            return redirect()->route('admin.countries');
        }
    }

    function updateCountry()
    {

        $this->validate([
            'editName' => [
                'required',
                'min:2',
                Rule::unique('countries', 'name')->ignore($this->countryId), // Exclude the current country from the unique validation
            ],
            'editCode' => [
                'required',
                'alpha',
                'max:8',
                Rule::unique('countries', 'code')->ignore($this->countryId), // Exclude the current country from the unique validation
            ],
            'countryId' => 'required|exists:countries,id',
        ]);

        $country = country::findOrFail($this->countryId);

        $country->update([
            'name' => str($this->editName)->trim()->lower()->title(),
            'code' => str($this->editCode)->trim()->upper(),
            'slug' => Str::slug($this->editName)
        ]);
        Flux::modal('edit-country')->close();
        $this->reset();
        session()->flash('success', 'country updated!');
    }

    #[On('delete-country')]
    public function confirmingDelete($id)
    {
        $this->countryId = $id;
    }

    public function deleteCountry()
    {
        if ($this->countryId) {
            $country = country::findOrFail($this->countryId);
            if ($country) {
                $country->delete();
                Flux::modal('delete-country')->close();
                session()->flash('success', 'country deleted');
                $this->reset();
            }
        }
    }

    public function getAllCountries()
    {
        return Country::all();
    }
    public function render()
    {
        $countries = $this->getAllCountries();
        return view('livewire.admin.countries', [
            'countries' => $countries
        ]);
    }
}
