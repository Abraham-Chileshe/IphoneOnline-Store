<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Settings extends Component
{
    public $usd_to_rub_rate;
    public $usd_to_aed_rate;

    public function mount()
    {
        $this->usd_to_rub_rate = \App\Models\Setting::get('usd_to_rub_rate', 90);
        $this->usd_to_aed_rate = \App\Models\Setting::get('usd_to_aed_rate', 3.67);
    }

    public function save()
    {
        $this->validate([
            'usd_to_rub_rate' => 'required|numeric|min:0.01',
            'usd_to_aed_rate' => 'required|numeric|min:0.01',
        ]);

        \App\Models\Setting::set('usd_to_rub_rate', $this->usd_to_rub_rate);
        \App\Models\Setting::set('usd_to_aed_rate', $this->usd_to_aed_rate);

        session()->flash('success', __('Settings updated successfully.'));
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('layouts.admin');
    }
}
