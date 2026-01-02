<?php

namespace App\Livewire\Admin\Cities;

use Livewire\Component;
use App\Models\City;

class Edit extends Component
{
    public $city;
    public $name_en;
    public $name_ru;
    public $slug;
    public $is_active;

    protected function rules()
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cities,slug,' . $this->city->id,
            'is_active' => 'boolean',
        ];
    }

    public function mount($id)
    {
        $this->city = City::findOrFail($id);
        $this->name_en = $this->city->name_en;
        $this->name_ru = $this->city->name_ru;
        $this->slug = $this->city->slug;
        $this->is_active = (bool) $this->city->is_active;
    }

    public function update()
    {
        $this->validate();

        $this->city->update([
            'name_en' => $this->name_en,
            'name_ru' => $this->name_ru,
            'slug' => $this->slug,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', __('City updated successfully!'));
        return redirect()->route('admin.cities.index');
    }

    public function render()
    {
        return view('livewire.admin.cities.edit')->layout('layouts.admin');
    }
}
