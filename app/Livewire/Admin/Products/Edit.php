<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $product;
    public $name;
    public $description;
    public $price;
    public $old_price;
    public $brand;
    public $category;
    public $stock;
    
    public $image;
    public $image_2;
    public $image_3;
    public $image_4;

    public $new_image;
    public $new_image_2;
    public $new_image_3;
    public $new_image_4;

    public $is_active;
    public $badge_text;
    public $badge_type = 'price';

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'old_price' => 'nullable|numeric|min:0',
        'brand' => 'required|string',
        'category' => 'nullable|string',
        'stock' => 'required|integer|min:0',
        'new_image' => 'nullable|image|max:2048',
        'new_image_2' => 'nullable|image|max:2048',
        'new_image_3' => 'nullable|image|max:2048',
        'new_image_4' => 'nullable|image|max:2048',
        'badge_text' => 'nullable|string|max:50',
        'badge_type' => 'nullable|in:discount,price,new,sale,hot',
    ];

    public function mount($id)
    {
        $this->product = \App\Models\Product::findOrFail($id);
        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->price = $this->product->price;
        $this->old_price = $this->product->old_price;
        $this->brand = $this->product->brand;
        $this->category = $this->product->category;
        $this->stock = $this->product->stock;
        
        $this->image = $this->product->image;
        $this->image_2 = $this->product->image_2;
        $this->image_3 = $this->product->image_3;
        $this->image_4 = $this->product->image_4;

        $this->badge_text = $this->product->badge_text;
        $this->badge_type = $this->product->badge_type ?? 'price';

        $this->is_active = (bool) $this->product->is_active;
    }

    public function update()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'old_price' => $this->old_price,
                'brand' => $this->brand,
                'category' => $this->category,
                'stock' => $this->stock,
                'is_active' => $this->is_active,
                'badge_text' => $this->badge_text,
                'badge_type' => $this->badge_type,
            ];

            if ($this->new_image) {
                $data['image'] = '/storage/' . $this->new_image->store('products', 'public');
            }
            if ($this->new_image_2) {
                $data['image_2'] = '/storage/' . $this->new_image_2->store('products', 'public');
            }
            if ($this->new_image_3) {
                $data['image_3'] = '/storage/' . $this->new_image_3->store('products', 'public');
            }
            if ($this->new_image_4) {
                $data['image_4'] = '/storage/' . $this->new_image_4->store('products', 'public');
            }

            $this->product->update($data);

            session()->flash('success', 'Product updated successfully!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            \Log::error('Product update failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update product. Please try again.');
        }
    }


    public function render()
    {
        return view('livewire.admin.products.edit')->layout('layouts.admin');
    }
}
