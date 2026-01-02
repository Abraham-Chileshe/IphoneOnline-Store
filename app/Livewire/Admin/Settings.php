<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Settings extends Component
{
    public $usd_to_rub_rate;
    public $usd_to_aed_rate;
    public $store_location;
    public $default_locale;

    public function mount()
    {
        $this->usd_to_rub_rate = \App\Models\Setting::get('usd_to_rub_rate', 90);
        $this->usd_to_aed_rate = \App\Models\Setting::get('usd_to_aed_rate', 3.67);
        $this->store_location = \App\Models\Setting::get('store_location', 'Lusaka');
        $this->default_locale = \App\Models\Setting::get('default_locale', 'en');
    }

    public function save()
    {
        $this->validate([
            'usd_to_rub_rate' => 'required|numeric|min:0.01',
            'usd_to_aed_rate' => 'required|numeric|min:0.01',
            'store_location' => 'required|string|max:255',
            'default_locale' => 'required|in:en,ru',
        ]);

        \App\Models\Setting::set('usd_to_rub_rate', $this->usd_to_rub_rate);
        \App\Models\Setting::set('usd_to_aed_rate', $this->usd_to_aed_rate);
        \App\Models\Setting::set('store_location', $this->store_location);
        \App\Models\Setting::set('default_locale', $this->default_locale);

        session()->flash('success', __('Settings updated successfully.'));
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('layouts.admin');
    }
}
