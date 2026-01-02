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
    public $city;

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
        'city' => 'required|in:Moscow,Saint Petersburg,Novokuznetsk',
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
        $this->city = $this->product->city;

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
                'city' => $this->city,
            ];

            // Handle new images with enhanced security
            if ($this->new_image) {
                $filename = \Illuminate\Support\Str::random(40) . '.' . $this->new_image->getClientOriginalExtension();
                $imagePath = $this->new_image->storeAs('products', $filename, 'public');
                
                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('products/' . $filename)) {
                    throw new \Exception('Image upload failed');
                }
                
                $data['image'] = '/storage/' . $imagePath;
            }
            if ($this->new_image_2) {
                $filename2 = \Illuminate\Support\Str::random(40) . '.' . $this->new_image_2->getClientOriginalExtension();
                $data['image_2'] = '/storage/' . $this->new_image_2->storeAs('products', $filename2, 'public');
            }
            if ($this->new_image_3) {
                $filename3 = \Illuminate\Support\Str::random(40) . '.' . $this->new_image_3->getClientOriginalExtension();
                $data['image_3'] = '/storage/' . $this->new_image_3->storeAs('products', $filename3, 'public');
            }
            if ($this->new_image_4) {
                $filename4 = \Illuminate\Support\Str::random(40) . '.' . $this->new_image_4->getClientOriginalExtension();
                $data['image_4'] = '/storage/' . $this->new_image_4->storeAs('products', $filename4, 'public');
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
