<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
      $products = [
    [
        'name' => 'iPhone 15 Pro 256GB',
        'brand' => 'APPLE',
        'description' => 'Latest iPhone with titanium body and A17 Pro processor',
        'price' => 149000,
        'old_price' => 175000,
        'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&q=80&w=500',
        'stock' => 50,
        'category' => 'Smartphones',
        'rating' => 5.0,
        'reviews_count' => 1204,
        'is_active' => true,
    ],
    
    [
        'name' => 'iPhone 14 Pro Deep Purple',
        'brand' => 'APPLE',
        'description' => 'iPhone 14 Pro in Deep Purple color',
        'price' => 128200,
        'old_price' => 139000,
        'image' => 'https://images.unsplash.com/photo-1663499482523-1c0c1bae4ce1?auto=format&fit=crop&q=80&w=500',
        'stock' => 25,
        'category' => 'Smartphones',
        'rating' => 4.9,
        'reviews_count' => 10400,
        'is_active' => true,
    ],
    [
        'name' => 'iPhone 15 Pro Max 512GB',
        'brand' => 'APPLE',
        'description' => 'The ultimate iPhone with largest display and maximum storage',
        'price' => 189000,
        'old_price' => 210000,
        'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&q=80&w=500',
        'stock' => 15,
        'category' => 'Smartphones',
        'rating' => 5.0,
        'reviews_count' => 892,
        'is_active' => true,
    ],
    [
        'name' => 'iPhone 14 256GB Midnight',
        'brand' => 'APPLE',
        'description' => 'iPhone 14 in sleek midnight black finish',
        'price' => 98000,
        'old_price' => 115000,
        'image' => 'https://images.unsplash.com/photo-1678652197831-2d180705cd2c?auto=format&fit=crop&q=80&w=500',
        'stock' => 40,
        'category' => 'Smartphones',
        'rating' => 4.8,
        'reviews_count' => 5420,
        'is_active' => true,
    ],
    [
        'name' => 'iPhone 13 128GB Starlight',
        'brand' => 'APPLE',
        'description' => 'iPhone 13 with excellent performance at great value',
        'price' => 79000,
        'old_price' => 95000,
        'image' => 'https://images.unsplash.com/photo-1632661674596-df8be070a5c5?auto=format&fit=crop&q=80&w=500',
        'stock' => 60,
        'category' => 'Smartphones',
        'rating' => 4.7,
        'reviews_count' => 8750,
        'is_active' => true,
    ],
    [
        'name' => 'iPhone 15 Plus 256GB Blue',
        'brand' => 'APPLE',
        'description' => 'Large display iPhone 15 Plus in beautiful blue',
        'price' => 135000,
        'old_price' => 155000,
        'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&q=80&w=500',
        'stock' => 35,
        'category' => 'Smartphones',
        'rating' => 4.9,
        'reviews_count' => 2340,
        'is_active' => true,
    ],
    [
        'name' => 'iPhone 14 Pro Max 1TB Gold',
        'brand' => 'APPLE',
        'description' => 'Maximum storage iPhone 14 Pro Max in elegant gold',
        'price' => 165000,
        'old_price' => 185000,
        'image' => 'https://images.unsplash.com/photo-1678911820864-e2c567c655d7?auto=format&fit=crop&q=80&w=500',
        'stock' => 12,
        'category' => 'Smartphones',
        'rating' => 5.0,
        'reviews_count' => 6890,
        'is_active' => true,
    ],

    [
        'name' => 'iPhone 13 Pro 512GB Sierra Blue',
        'brand' => 'APPLE',
        'description' => 'iPhone 13 Pro with ProMotion display and triple camera',
        'price' => 115000,
        'old_price' => 135000,
        'image' => 'https://images.unsplash.com/photo-1678911820864-e2c567c655d7?auto=format&fit=crop&q=80&w=500',
        'stock' => 12,
        'stock' => 20,
        'category' => 'Smartphones',
        'rating' => 4.8,
        'reviews_count' => 7650,
        'is_active' => true,
    ],
  
   

];
        
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
