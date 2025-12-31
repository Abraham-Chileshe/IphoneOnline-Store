@section('title', 'Overview')

<div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">{{ $totalOrders }} {{ Str::plural('order', $totalOrders) }}</small>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">All time</small>
        </div>
        <div class="stat-card">
            <div class="stat-label">Customers</div>
            <div class="stat-value">{{ $totalCustomers }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">Registered</small>
        </div>
        <div class="stat-card">
            <div class="stat-label">Avg. Order Value</div>
            <div class="stat-value">${{ number_format($avgOrderValue, 2) }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">Per order</small>
        </div>
    </div>
    
    @if($lowStockProducts > 0 || $outOfStockProducts > 0)
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 20px; margin: 20px 0;">
            <h3 style="color: #ef4444; margin-bottom: 10px; font-size: 16px;">⚠️ Stock Alerts</h3>
            @if($lowStockProducts > 0)
                <p style="color: var(--text-main); margin: 5px 0; font-size: 14px;">• {{ $lowStockProducts }} {{ Str::plural('product', $lowStockProducts) }} running low on stock (≤5 units)</p>
            @endif
            @if($outOfStockProducts > 0)
                <p style="color: var(--text-main); margin: 5px 0; font-size: 14px;">• {{ $outOfStockProducts }} {{ Str::plural('product', $outOfStockProducts) }} out of stock</p>
            @endif
            <a href="{{ route('admin.products.index') }}" style="display: inline-block; margin-top: 10px; color: #ef4444; text-decoration: underline; font-size: 14px;">View Products →</a>
        </div>
    @endif

    <!-- Recent Orders -->
    <h3 style="margin: 30px 0 15px 0;">Recent Orders</h3>
    <div class="data-table-container">
        @if($recentOrders->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.detail', $order->id) }}" class="action-btn">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; padding: 40px; color: var(--text-muted);">No orders yet</p>
        @endif
    </div>
</div>
