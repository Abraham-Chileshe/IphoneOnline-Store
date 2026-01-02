<?php

namespace App\Livewire\Admin\Cities;

use Livewire\Component;
use App\Models\City;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        session()->flash('success', __('City deleted successfully!'));
    }

    public function toggleStatus($id)
    {
        $city = City::findOrFail($id);
        $city->is_active = !$city->is_active;
        $city->save();
    }

    public function render()
    {
        return view('livewire.admin.cities.index', [
            'cities' => City::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
