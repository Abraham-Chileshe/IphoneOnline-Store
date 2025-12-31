<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;

class GlobalSearch extends Component
{
    #[Url]
    public $search = '';
    public $layout = 'desktop';
    public $suggestions = [];

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->suggestions = [];
            return;
        }

        // Fetch matching product names/brands as suggestions
        $this->suggestions = \App\Models\Product::where('is_active', true)
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%');
            })
            ->limit(8)
            ->get(['id', 'name', 'brand'])
            ->toArray();
    }

    public function performSearch($searchQuery = null)
    {
        $query = $searchQuery ?? $this->search;
        $this->search = $query;
        $this->suggestions = [];

        if (!request()->routeIs('home')) {
            return redirect()->route('home', ['search' => $query]);
        }
    }

    public function clearSuggestions()
    {
        $this->suggestions = [];
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
