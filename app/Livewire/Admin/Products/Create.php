<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $brand;
    public $category;
    
    public $stock = 10;
    public $old_price;

    public $image;
    public $image_2;
    public $image_3;
    public $image_4;
    public $is_active = true;
    public $badge_text;
    public $badge_type = 'price';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|string|max:5000',
        'price' => 'required|numeric|min:0.01|max:999999.99',
        'old_price' => 'nullable|numeric|min:0|max:999999.99|gte:price',
        'brand' => 'required|string|max:100',
        'category' => 'nullable|string|max:100',
        'stock' => 'required|integer|min:0|max:10000',
        'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        'image_2' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        'image_3' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        'image_4' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        'badge_text' => 'nullable|string|max:50',
        'badge_type' => 'nullable|in:discount,price,new,sale,hot',
    ];
    
    protected $messages = [
        'old_price.gte' => 'Old price must be greater than or equal to current price.',
        'price.min' => 'Price must be at least $0.01.',
        'stock.max' => 'Stock cannot exceed 10,000 units.',
    ];

    public function save()
    {
        $this->validate();

        try {
            $imagePath = $this->image->store('products', 'public');
            
            $data = [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'old_price' => $this->old_price,
                'brand' => $this->brand,
                'category' => $this->category,
                'stock' => $this->stock,
                'image' => '/storage/' . $imagePath,
                'is_active' => $this->is_active,
                'badge_text' => $this->badge_text,
                'badge_type' => $this->badge_type ?? 'price',
            ];

            if ($this->image_2) {
                $data['image_2'] = '/storage/' . $this->image_2->store('products', 'public');
            }
            if ($this->image_3) {
                $data['image_3'] = '/storage/' . $this->image_3->store('products', 'public');
            }
            if ($this->image_4) {
                $data['image_4'] = '/storage/' . $this->image_4->store('products', 'public');
            }

            \App\Models\Product::create($data);

            session()->flash('success', 'Product created successfully!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            \Log::error('Product creation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to create product. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.products.create')->layout('layouts.admin');
    }
}
