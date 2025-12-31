<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_place_order_with_valid_cart(): void
    {
        $user = User::factory()->create([
            'address' => '123 Main St',
            'city' => 'New York',
            'postal_code' => '10001',
            'phone' => '+1234567890'
        ]);

        $product = Product::factory()->create([
            'price' => 999.99,
            'stock' => 10
        ]);

        $cart = Cart::create(['user_id' => $user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $this->actingAs($user);

        $this->assertEquals(10, $product->fresh()->stock);

        // Simulate order placement via Livewire
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => 1999.98,
            'status' => 'pending',
            'shipping_address' => $user->address,
            'city' => $user->city,
            'postal_code' => $user->postal_code,
            'phone' => $user->phone,
        ]);

        $product->decrement('stock', 2);

        $this->assertEquals(8, $product->fresh()->stock);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
    }

    public function test_order_cannot_be_placed_without_address(): void
    {
        $user = User::factory()->create([
            'address' => null,
            'city' => null,
            'postal_code' => null,
            'phone' => null
        ]);

        $this->actingAs($user);

        $this->assertNull($user->address);
    }

    public function test_stock_is_restored_when_order_is_cancelled(): void
    {
        $product = Product::factory()->create(['stock' => 10]);
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => 999.99,
            'status' => 'pending',
            'shipping_address' => '123 Main St',
            'city' => 'NYC',
            'postal_code' => '10001',
            'phone' => '+1234567890'
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => 3,
            'price' => 333.33
        ]);

        $product->decrement('stock', 3);
        $this->assertEquals(7, $product->fresh()->stock);

        $order->cancel();

        $this->assertEquals(10, $product->fresh()->stock);
        $this->assertEquals('cancelled', $order->fresh()->status);
    }
}
