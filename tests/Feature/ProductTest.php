<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_products(): void
    {
        Product::factory()->create([
            'name' => 'iPhone 15 Pro',
            'is_active' => true,
            'stock' => 10
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('iPhone 15 Pro');
    }

    public function test_product_detail_page_loads(): void
    {
        $product = Product::factory()->create([
            'name' => 'iPhone 15',
            'is_active' => true,
            'stock' => 5
        ]);

        $response = $this->get("/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_admin_can_create_product(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        $response = $this->get('/admin/products/create');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user);

        $response = $this->get('/admin/products');

        $response->assertStatus(403);
    }
}
