@section('title', __('Overview'))

<div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">{{ __('Total Revenue') }}</div>
            <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">{{ $totalOrders }} {{ $totalOrders == 1 ? __('order') : __('orders') }}</small>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Total Orders') }}</div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">{{ __('All time') }}</small>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Customers') }}</div>
            <div class="stat-value">{{ $totalCustomers }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">{{ __('Registered') }}</small>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Avg. Order Value') }}</div>
            <div class="stat-value">${{ number_format($avgOrderValue, 2) }}</div>
            <small style="color: var(--text-muted); font-size: 12px;">{{ __('Per order') }}</small>
        </div>
    </div>
    
    @if($lowStockProducts > 0 || $outOfStockProducts > 0)
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 20px; margin: 20px 0;">
            <h3 style="color: #ef4444; margin-bottom: 10px; font-size: 16px;">⚠️ {{ __('Stock Alerts') }}</h3>
            @if($lowStockProducts > 0)
                <p style="color: var(--text-main); margin: 5px 0; font-size: 14px;">• {{ $lowStockProducts }} {{ $lowStockProducts == 1 ? __('product') : __('products') }} {{ __('products running low on stock (≤5 units)') }}</p>
            @endif
            @if($outOfStockProducts > 0)
                <p style="color: var(--text-main); margin: 5px 0; font-size: 14px;">• {{ $outOfStockProducts }} {{ $outOfStockProducts == 1 ? __('product') : __('products') }} {{ __('products out of stock') }}</p>
            @endif
            <a href="{{ route('admin.products.index') }}" style="display: inline-block; margin-top: 10px; color: #ef4444; text-decoration: underline; font-size: 14px;">{{ __('View Products') }} →</a>
        </div>
    @endif

    <!-- Recent Orders -->
    <h3 style="margin: 30px 0 15px 0;">{{ __('Recent Orders') }}</h3>
    <div class="data-table-container">
        @if($recentOrders->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Order ID') }}</th>
                        <th>{{ __('Customer') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
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
                                    {{ __(ucfirst($order->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.detail', $order->id) }}" class="action-btn">{{ __('View') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; padding: 40px; color: var(--text-muted);">{{ __('No orders yet') }}</p>
        @endif
    </div>
</div>
