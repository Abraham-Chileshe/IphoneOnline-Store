<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class Dashboard extends Component
{
    public function render()
    {
        $totalRevenue = Order::whereIn('status', ['delivered', 'processing', 'shipped'])->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();
        
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->where('is_active', true)
            ->count();
            
        $outOfStockProducts = Product::where('stock', 0)
            ->where('is_active', true)
            ->count();
        
        return view('livewire.admin.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'avgOrderValue' => $avgOrderValue,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
        ])->layout('layouts.admin');
    }
}
