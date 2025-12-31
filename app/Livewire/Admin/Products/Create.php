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

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'old_price' => 'nullable|numeric|min:0',
        'brand' => 'required|string',
        'category' => 'nullable|string',
        'stock' => 'required|integer|min:0',
        'image' => 'required|image|max:2048', // 2MB Max
        'image_2' => 'nullable|image|max:2048',
        'image_3' => 'nullable|image|max:2048',
        'image_4' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

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

        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.products.create')->layout('layouts.admin');
    }
}
