<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        
        // Delete images from storage
        $images = [$product->image, $product->image_2, $product->image_3, $product->image_4];
        foreach ($images as $image) {
            if ($image && str_starts_with($image, '/storage/')) {
                $path = str_replace('/storage/', 'public/', $image);
                if (\Illuminate\Support\Facades\Storage::exists($path)) {
                    \Illuminate\Support\Facades\Storage::delete($path);
                }
            }
        }

        $product->delete();
        session()->flash('success', 'Product deleted successfully!');
    }

    public function render()

    {
        return view('livewire.admin.products.index', [
            'products' => \App\Models\Product::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
