<?php

namespace App\Livewire\Admin\Cities;

use Livewire\Component;
use App\Models\City;
use Illuminate\Support\Str;

class Create extends Component
{
    public $name_en;
    public $name_ru;
    public $slug;
    public $is_active = true;

    protected $rules = [
        'name_en' => 'required|string|max:255',
        'name_ru' => 'required|string|max:255',
        'slug' => 'required|string|unique:cities,slug|max:255',
        'is_active' => 'boolean',
    ];

    public function updatedNameEn($value)
    {
        $this->slug = $value; // We keep it simple as requested, using name as slug
    }

    public function save()
    {
        $this->validate();

        City::create([
            'name_en' => $this->name_en,
            'name_ru' => $this->name_ru,
            'slug' => $this->slug,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', __('City created successfully!'));
        return redirect()->route('admin.cities.index');
    }

    public function render()
    {
        return view('livewire.admin.cities.create')->layout('layouts.admin');
    }
}
