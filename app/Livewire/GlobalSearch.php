<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Product;

class GlobalSearch extends Component
{
    #[Url]
    public $search = '';
    
    public $layout = 'desktop';
    public $suggestions = [];

    public function updatedSearch()
    {
        // Clear suggestions if search is too short
        if (strlen($this->search) < 2) {
            $this->suggestions = [];
            return;
        }

        // Fetch matching products
        $this->suggestions = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->limit(8)
            ->get(['id', 'name', 'brand', 'price', 'image'])
            ->toArray();
    }

    public function selectSuggestion($productName)
    {
        $this->search = $productName;
        $this->suggestions = [];
        $this->performSearch();
    }

    public function performSearch()
    {
        // Clear suggestions when performing search
        $this->suggestions = [];
        
        // If not on home page, redirect with search parameter
        if (!request()->routeIs('home')) {
            return redirect()->route('home', ['search' => $this->search]);
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
